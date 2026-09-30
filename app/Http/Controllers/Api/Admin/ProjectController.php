<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    // Admin listing: everything, draft or published, newest first within order.
    public function index(): JsonResponse
    {
        $projects = Project::with(['images', 'links'])->orderBy('order')->get();

        return response()->json(['data' => ProjectResource::collection($projects)]);
    }

    public function show(Project $project): JsonResponse
    {
        $project->load(['images', 'links']);

        return response()->json(['data' => new ProjectResource($project)]);
    }

    public function store(StoreProjectRequest $request): JsonResponse
    {
        $data = $request->safe()->except(['cover_image', 'images', 'image_captions', 'links']);

        if (empty($data['slug'])) {
            $data['slug'] = Project::uniqueSlug($request->input('title'));
        }

        if ($request->hasFile('cover_image')) {
            $data['cover_image_path'] = $request->file('cover_image')->store('projects/covers', 'public');
        }

        $project = Project::create($data);

        $this->syncImages($project, $request);
        $this->syncLinks($project, $request);

        $project->load(['images', 'links']);

        return response()->json(['data' => new ProjectResource($project)], 201);
    }

    public function update(UpdateProjectRequest $request, Project $project): JsonResponse
    {
        $data = $request->safe()->except(['cover_image', 'images', 'image_captions', 'links']);

        if ($request->hasFile('cover_image')) {
            if ($project->cover_image_path) {
                Storage::disk('public')->delete($project->cover_image_path);
            }
            $data['cover_image_path'] = $request->file('cover_image')->store('projects/covers', 'public');
        }

        $project->update($data);

        // Additive: new images/links append. Removing an individual image/link uses its own endpoint below.
        $this->syncImages($project, $request);
        $this->syncLinks($project, $request, replace: true);

        $project->load(['images', 'links']);

        return response()->json(['data' => new ProjectResource($project)]);
    }

    public function destroy(Project $project): JsonResponse
    {
        if ($project->cover_image_path) {
            Storage::disk('public')->delete($project->cover_image_path);
        }
        foreach ($project->images as $image) {
            Storage::disk('public')->delete($image->image_path);
        }

        $project->delete(); // images/links cascade via FK

        return response()->json(['message' => 'Project deleted.']);
    }

    // Remove a single gallery image without touching the rest of the project.
    public function destroyImage(Project $project, int $imageId): JsonResponse
    {
        $image = $project->images()->findOrFail($imageId);
        Storage::disk('public')->delete($image->image_path);
        $image->delete();

        return response()->json(['message' => 'Image removed.']);
    }

    // Remove a single link (e.g. delete just the repo link, keep the live link).
    public function destroyLink(Project $project, int $linkId): JsonResponse
    {
        $project->links()->findOrFail($linkId)->delete();

        return response()->json(['message' => 'Link removed.']);
    }

    private function syncImages(Project $project, $request): void
    {
        if (!$request->hasFile('images')) {
            return;
        }

        $captions = $request->input('image_captions', []);

        foreach ($request->file('images') as $index => $file) {
            $path = $file->store('projects/gallery', 'public');
            $project->images()->create([
                'image_path' => $path,
                'caption' => $captions[$index] ?? null,
                'order' => $project->images()->count(),
            ]);
        }
    }

    private function syncLinks(Project $project, $request, bool $replace = false): void
    {
        if (!$request->has('links')) {
            return;
        }

        if ($replace) {
            $project->links()->delete();
        }

        foreach ($request->input('links', []) as $index => $link) {
            $project->links()->create([
                'label' => $link['label'],
                'type' => $link['type'],
                'url' => $link['url'],
                'order' => $index,
            ]);
        }
    }
}
