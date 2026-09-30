<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContactMessageRequest;
use App\Models\ContactMessage;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\RateLimiter;

class ContactMessageController extends Controller
{
    public function store(StoreContactMessageRequest $request): JsonResponse
    {
        // Simple abuse guard: 5 submissions per IP per hour.
        $key = 'contact-message:' . $request->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            return response()->json([
                'message' => 'Too many messages sent. Please try again later.',
            ], 429);
        }
        RateLimiter::hit($key, 3600);

        $message = ContactMessage::create([
            ...$request->validated(),
            'ip_address' => $request->ip(),
        ]);

        // Optional: dispatch a Mailable/notification to yourself here, e.g.
        // Mail::to(config('mail.admin_address'))->send(new NewContactMessage($message));

        return response()->json([
            'message' => 'Thanks — your message has been sent.',
            'data' => ['id' => $message->id],
        ], 201);
    }
}
