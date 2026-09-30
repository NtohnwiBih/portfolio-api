<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAchievementRequest;
use App\Models\Achievement;
use Illuminate\Http\JsonResponse;

class AchievementController extends Controller
{
    public function index(): JsonResponse
    {
        $achievements = Achievement::with('tags')->orderBy('order')->get();

        return response()->json(['data' => $achievements]);
    }

    public function store(StoreAchievementRequest $request): JsonResponse
    {
        $achievement = Achievement::create($request->safe()->except('tags'));
        $this->syncTags($achievement, $request->input('tags', []));

        return response()->json(['data' => $achievement->load('tags')], 201);
    }

    public function update(StoreAchievementRequest $request, Achievement $achievement): JsonResponse
    {
        $achievement->update($request->safe()->except('tags'));

        if ($request->has('tags')) {
            $this->syncTags($achievement, $request->input('tags', []));
        }

        return response()->json(['data' => $achievement->load('tags')]);
    }

    public function destroy(Achievement $achievement): JsonResponse
    {
        $achievement->delete();

        return response()->json(['message' => 'Achievement deleted.']);
    }

    private function syncTags(Achievement $achievement, array $tags): void
    {
        $achievement->tags()->delete();
        foreach ($tags as $tag) {
            $achievement->tags()->create(['tag' => $tag]);
        }
    }
}
