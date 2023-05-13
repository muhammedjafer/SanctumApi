<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required | string',
            'email' => 'required | email | unique:users,email',
            'password' => 'required | string | confirmed'
        ]);

        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password'])
        ]);

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    public function login(Request $request)
    {
        $fields = $request->validate([
            'email' => 'required | email',
            'password' => 'required | string'
        ]);

        $user = User::where('email', $fields['email'])->first();

        if(!$user || !Hash::check($fields['password'], $user->password)) 
        {
            return response([
                'message' => 'Invalid password or email'
            ], 401);
        }

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'logged out'
        ];
    }

    public function refreshToken()
    {
        $user = auth()->user();
        $token = $user->currentAccessToken();

        $newToken = $token->refresh();

        return response()->json([
            'status' => true,
            'message' => 'Token refreshed successfully',
            'user' => $user,
            'authorization' => [
                'token' => $newToken->plainTextToken,
                'type' => 'Bearer'
            ]
        ], 200);

    }

}
