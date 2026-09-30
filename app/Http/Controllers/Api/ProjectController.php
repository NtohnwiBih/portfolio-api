<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    // Public catalogue — used for a "Projects" page beyond what's in the mockups.
    public function index(Request $request): JsonResponse
    {
        $query = Project::published()->with(['images', 'links'])->orderBy('order');

        if ($type = $request->query('type')) {
            $query->where('type', $type);
        }

        return response()->json(['data' => ProjectResource::collection($query->get())]);
    }

    public function show(string $slug): JsonResponse
    {
        $project = Project::published()->with(['images', 'links'])->where('slug', $slug)->firstOrFail();

        return response()->json(['data' => new ProjectResource($project)]);
    }
}
