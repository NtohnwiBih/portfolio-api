<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /** How long an admin token stays valid. */
    private const TOKEN_TTL_HOURS = 12;

    public function login(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);
 
        $user = User::where('email', $credentials['email'])->first();
 
        // Same message for "no such user" and "wrong password" so emails can't be probed.
        if (! $user || ! Hash::check($credentials['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['These credentials do not match our records.'],
            ]);
        }
 
        // One active admin session per login: drop tokens issued earlier for the SPA.
        $user->tokens()->where('name', 'admin-spa')->delete();
 
        $expiresAt = now()->addHours(self::TOKEN_TTL_HOURS);
        $token = $user->createToken('admin-spa', ['*'], $expiresAt)->plainTextToken;
 
        return response()->json([
            'token' => $token,
            'expires_at' => $expiresAt->toIso8601String(),
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ],
        ]);
    }
 
    /**
     * POST /api/logout  (auth:sanctum)  ->  204
     */
    public function logout(Request $request): JsonResponse
    {
        $token = $request->user()?->currentAccessToken();
 
        // Session-based (transient) tokens have nothing to delete.
        if ($token && method_exists($token, 'delete')) {
            $token->delete();
        }
 
        return response()->json(null, 204);
    }

    /**
     * GET /api/me  (auth:sanctum)
     */
    public function me(Request $request): JsonResponse
    {
        $user = $request->user();

        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
        ]);
    }
}