<?php

use App\Http\Controllers\Api\Admin\AchievementController as AdminAchievementController;
use App\Http\Controllers\Api\Admin\ContactMessageController as AdminContactMessageController;
use App\Http\Controllers\Api\Admin\ExperienceController as AdminExperienceController;
use App\Http\Controllers\Api\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Api\Admin\ProjectController as AdminProjectController;
use App\Http\Controllers\Api\Admin\SocialLinkController as AdminSocialLinkController;
use App\Http\Controllers\Api\AchievementController;
use App\Http\Controllers\Api\ContactMessageController;
use App\Http\Controllers\Api\ExperienceController;
use App\Http\Controllers\Api\ExpertiseController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\SocialLinkController;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public read endpoints — power the live site, no auth required.
|--------------------------------------------------------------------------
*/
Route::get('/home', HomeController::class)->name('home');
Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
Route::get('/experiences', [ExperienceController::class, 'index'])->name('experiences.index');
Route::get('/expertise', [ExpertiseController::class, 'index'])->name('expertise.index');
Route::get('/achievements', [AchievementController::class, 'index'])->name('achievements.index');
Route::get('/social-links', [SocialLinkController::class, 'index'])->name('social-links.index');

// Named so ProjectResource can detect "am I being rendered for a single-item
// response?" via routeIs('*.show') and include the full `description` field
// only there — keeps the list payload lean, gives the detail page everything.
Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
Route::get('/projects/{slug}', [ProjectController::class, 'show'])->name('projects.show');

Route::post('/contact', [ContactMessageController::class, 'store'])->name('contact.store');

Route::post('/login', [AuthController::class, 'login'])
    ->middleware('throttle:5,1')
    ->name('auth.login');
 
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
    Route::get('/me', [AuthController::class, 'me'])->name('auth.me');
});

/*
|--------------------------------------------------------------------------
| Admin endpoints — require a Sanctum token (Authorization: Bearer ...).
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->prefix('admin')->name('admin.')->group(function () {

    Route::get('/profile', [AdminProfileController::class, 'show'])->name('profile.show');
    Route::post('/profile', [AdminProfileController::class, 'update'])->name('profile.update');

    Route::apiResource('experiences', AdminExperienceController::class)->except(['show']);

    Route::apiResource('achievements', AdminAchievementController::class)->except(['show']);

    Route::apiResource('social-links', AdminSocialLinkController::class)->except(['show']);

    // Named routes here become admin.projects.index / admin.projects.show / etc.,
    // distinct from the public projects.index / projects.show above — no collision,
    // and admin.projects.show still matches the '*.show' wildcard ProjectResource checks.
    Route::apiResource('projects', AdminProjectController::class);
    Route::delete('/projects/{project}/images/{image}', [AdminProjectController::class, 'destroyImage'])
        ->name('projects.images.destroy');
    Route::delete('/projects/{project}/links/{link}', [AdminProjectController::class, 'destroyLink'])
        ->name('projects.links.destroy');

    Route::get('/contact-messages', [AdminContactMessageController::class, 'index'])->name('contact-messages.index');
    Route::get('/contact-messages/{contactMessage}', [AdminContactMessageController::class, 'show'])->name('contact-messages.show');
    Route::patch('/contact-messages/{contactMessage}/read', [AdminContactMessageController::class, 'markRead'])->name('contact-messages.read');
    Route::delete('/contact-messages/{contactMessage}', [AdminContactMessageController::class, 'destroy'])->name('contact-messages.destroy');
});