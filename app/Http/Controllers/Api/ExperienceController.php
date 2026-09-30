<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ExperienceResource;
use App\Models\Experience;
use App\Models\ExperienceSnapshot;
use Illuminate\Http\JsonResponse;

class ExperienceController extends Controller
{
    public function index(): JsonResponse
    {
        $experiences = Experience::with('highlights')->orderBy('order')->orderByDesc('start_date')->get();
        $snapshots = ExperienceSnapshot::orderBy('order')->get();

        return response()->json([
            'data' => ExperienceResource::collection($experiences),
            'snapshots' => $snapshots->map(fn ($s) => [
                'title' => $s->title,
                'subtitle' => $s->subtitle,
                'icon' => $s->icon,
                'image_url' => $s->image_url,
            ]),
        ]);
    }
}
