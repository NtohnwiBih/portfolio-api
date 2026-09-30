<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Achievement;
use App\Models\AchievementGalleryItem;
use Illuminate\Http\JsonResponse;

class AchievementController extends Controller
{
    public function index(): JsonResponse
    {
        $achievements = Achievement::with('tags')->orderBy('order')->get()->map(fn ($a) => [
            'id' => $a->id,
            'title' => $a->title,
            'subtitle' => $a->subtitle,
            'description' => $a->description,
            'icon' => $a->icon,
            'metric_label' => $a->metric_label,
            'tags' => $a->tags->pluck('tag'),
        ]);

        $gallery = AchievementGalleryItem::orderBy('order')->get()->map(fn ($g) => [
            'title' => $g->title,
            'subtitle' => $g->subtitle,
            'icon' => $g->icon,
            'media_url' => $g->media_url,
        ]);

        return response()->json(['data' => $achievements, 'gallery' => $gallery]);
    }
}
