<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Resources\ProfileResource;
use App\Models\Profile;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    // Singleton resource: no store/destroy, only show/update against the one row.
    public function show(): JsonResponse
    {
        return response()->json(['data' => new ProfileResource(Profile::firstOrCreate([]))]);
    }

    public function update(UpdateProfileRequest $request): JsonResponse
    {
        $profile = Profile::firstOrCreate([]);
        $data = $request->safe()->except(['photo', 'resume']);

        if ($request->hasFile('photo')) {
            if ($profile->photo_path) {
                Storage::disk('public')->delete($profile->photo_path);
            }
            $data['photo_path'] = $request->file('photo')->store('profile', 'public');
        }

        if ($request->hasFile('resume')) {
            if ($profile->resume_path) {
                Storage::disk('public')->delete($profile->resume_path);
            }
            $data['resume_path'] = $request->file('resume')->store('profile', 'public');
        }

        $profile->update($data);

        return response()->json(['data' => new ProfileResource($profile)]);
    }
}
