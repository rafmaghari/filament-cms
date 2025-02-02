<?php

namespace App\Http\Controllers\Auth0;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Auth0Controller extends Controller
{
    use ApiResponse;

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'auth0_id' => 'required|string|unique:users,auth0_id',
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users,email',
        ]);

        User::create($data);

        return $this->successResponse('User created successfully', [], Response::HTTP_CREATED);
    }
}
