<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CapabilityHighlight;
use App\Models\ExpertiseCategory;
use App\Models\ExpertisePrinciple;
use App\Models\ExpertiseStat;
use Illuminate\Http\JsonResponse;

class ExpertiseController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json([
            'principles' => ExpertisePrinciple::orderBy('order')->get(['icon', 'title', 'description']),
            'categories' => ExpertiseCategory::with('items')->orderBy('order')->get()->map(fn ($c) => [
                'icon' => $c->icon,
                'title' => $c->title,
                'items' => $c->items->pluck('label'),
            ]),
            'stats' => ExpertiseStat::orderBy('order')->get(['value', 'label']),
            'highlights' => CapabilityHighlight::orderBy('order')->get()->map(fn ($h) => [
                'title' => $h->title,
                'subtitle' => $h->subtitle,
                'icon' => $h->icon,
                'media_url' => $h->media_url,
                'link' => $h->link,
            ]),
        ]);
    }
}
