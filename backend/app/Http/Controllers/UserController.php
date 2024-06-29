<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use App\Repositories\UserRepository;

class UserController extends Controller
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Retrieve current logged user data as JSON Response.
     *
     * @return JsonResponse
     */

    public function me(): JsonResponse
    {
        $user = Auth::user();
        
        return response()->json($user);
    }
}
