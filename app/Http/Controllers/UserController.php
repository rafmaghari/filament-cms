<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\ApiResponse;
use App\Traits\UserInformation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use ApiResponse, UserInformation;

    public function issueAccessToken(Request $request)
    {
        $decodedToken = base64_decode($request->user['caravea_token']);
        $userId = str_replace('caravea_', '', $decodedToken);

        $user = User::where('auth0_id', $userId)->firstOrFail();
        $token = $user->createToken('CaraveaToken')->accessToken;

        return response()->json([
            'access_token' => $token,
            'expires_in' => config('auth.guards.api.expire'),
        ]);
    }

    public function userInformation(Request $request): JsonResponse
    {
        $userWithAccess = $this->userDetails();

        return $this->successResponse('User information', $userWithAccess);
    }
}
