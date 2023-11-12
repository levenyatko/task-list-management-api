<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\UserLoginRequest;
use App\Http\Requests\Auth\UserLogoutRequest;
use App\Http\Resources\Auth\LoginResource;
use App\Services\Api\AuthService;

class AuthController extends Controller
{
    /**
     * User login.
     *
     * @param UserLoginRequest $request Request with user data.
     * @param AuthService $service Service to process data.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(UserLoginRequest $request, AuthService $service): \Illuminate\Http\JsonResponse
    {
        if ($service->checkUserCredentials($request->getLoginData())) {
            $token = $service->createAccessToken($request->getEmail());
            return response()->json(new LoginResource($token));
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }

    /**
     * User logout.
     *
     * @param UserLogoutRequest $request Request.
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(UserLogoutRequest $request): \Illuminate\Http\JsonResponse
    {
        $token = $request->user()->token();
        $token->revoke();

        return response()->json(['message' => 'You have been successfully logged out.'], 200);
    }
}
