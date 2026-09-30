<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSocialLinkRequest;
use App\Models\SocialLink;
use Illuminate\Http\JsonResponse;

class SocialLinkController extends Controller
{
    // Flat CRUD — this exact shape (index/store/update/destroy, no nested children)
    // is what ExpertisePrinciple, ExpertiseStat, ExperienceSnapshot, CapabilityHighlight
    // and AchievementGalleryItem admin controllers look like too.
    public function index(): JsonResponse
    {
        return response()->json(['data' => SocialLink::orderBy('order')->get()]);
    }

    public function store(StoreSocialLinkRequest $request): JsonResponse
    {
        return response()->json(['data' => SocialLink::create($request->validated())], 201);
    }

    public function update(StoreSocialLinkRequest $request, SocialLink $socialLink): JsonResponse
    {
        $socialLink->update($request->validated());

        return response()->json(['data' => $socialLink]);
    }

    public function destroy(SocialLink $socialLink): JsonResponse
    {
        $socialLink->delete();

        return response()->json(['message' => 'Social link deleted.']);
    }
}
