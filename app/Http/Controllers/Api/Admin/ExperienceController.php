<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreExperienceRequest;
use App\Http\Resources\ExperienceResource;
use App\Models\Experience;
use Illuminate\Http\JsonResponse;

class ExperienceController extends Controller
{
    public function index(): JsonResponse
    {
        $experiences = Experience::with('highlights')->orderBy('order')->orderByDesc('start_date')->get();

        return response()->json(['data' => ExperienceResource::collection($experiences)]);
    }

    public function store(StoreExperienceRequest $request): JsonResponse
    {
        $experience = Experience::create($request->safe()->except('highlights'));
        $this->syncHighlights($experience, $request->input('highlights', []));
        $experience->load('highlights');

        return response()->json(['data' => new ExperienceResource($experience)], 201);
    }

    public function update(StoreExperienceRequest $request, Experience $experience): JsonResponse
    {
        $experience->update($request->safe()->except('highlights'));

        if ($request->has('highlights')) {
            $this->syncHighlights($experience, $request->input('highlights', []));
        }
        $experience->load('highlights');

        return response()->json(['data' => new ExperienceResource($experience)]);
    }

    public function destroy(Experience $experience): JsonResponse
    {
        $experience->delete(); // highlights + snapshots cascade/null via FK

        return response()->json(['message' => 'Experience deleted.']);
    }

    private function syncHighlights(Experience $experience, array $highlights): void
    {
        $experience->highlights()->delete();
        foreach ($highlights as $index => $description) {
            $experience->highlights()->create(['description' => $description, 'order' => $index]);
        }
    }
}
