<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    /**
     * Get a JWT via given credentials.
     *
     * @param AuthRequest $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function login(AuthRequest $request): JsonResponse
    {
        $token = Auth::attempt($request->all());

        if (!$token) return response()->json([], 401);

        $user = Auth::user();

        return  response()->json([
            'token' => $token,
            'user' => $user
        ]);
    }


    /**
     * Invalidate the token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(): JsonResponse
    {
        Auth::logout();

        return response()->json([], 200);
    }
}
