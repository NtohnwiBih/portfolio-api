<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProfileResource;
use App\Http\Resources\SocialLinkResource;
use App\Models\Profile;
use App\Models\Project;
use App\Models\SocialLink;
use Illuminate\Http\JsonResponse;

class HomeController extends Controller
{
    // One call that feeds the whole Home page: hero, quote, nav teaser cards, featured work.
    public function __invoke(): JsonResponse
    {
        $profile = Profile::first();

        return response()->json([
            'profile' => $profile ? new ProfileResource($profile) : null,
            'social_links' => SocialLinkResource::collection(SocialLink::orderBy('order')->get()),
            'featured_projects' => Project::published()
                ->where('is_featured', true)
                ->orderBy('order')
                ->with('images')
                ->get()
                ->map(fn ($p) => [
                    'title' => $p->title,
                    'slug' => $p->slug,
                    'short_description' => $p->short_description,
                    'cover_image_url' => $p->cover_image_url,
                ]),
        ]);
    }
}
