<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ContactMessageController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = ContactMessage::latest();

        if ($request->boolean('unread_only')) {
            $query->where('is_read', false);
        }

        return response()->json([
            'data' => $query->paginate($request->integer('per_page', 20)),
            'unread_count' => ContactMessage::where('is_read', false)->count(),
        ]);
    }

    public function show(ContactMessage $contactMessage): JsonResponse
    {
        return response()->json(['data' => $contactMessage]);
    }

    public function markRead(ContactMessage $contactMessage): JsonResponse
    {
        $contactMessage->update(['is_read' => true]);

        return response()->json(['data' => $contactMessage]);
    }

    public function destroy(ContactMessage $contactMessage): JsonResponse
    {
        $contactMessage->delete();

        return response()->json(['message' => 'Message deleted.']);
    }
}
