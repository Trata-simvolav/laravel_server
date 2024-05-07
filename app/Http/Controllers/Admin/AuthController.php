<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Api\V1\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $fields = $request->validate([
            "email" => ["required", "email"],
            "password" => ["required", "string"],
        ]);

        $user = User::where('email', $fields['email'])->first();

        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return \response([
                "status" => "invalid",
                "message" => "Wrong email or password"
            ], 401);
        }

        $token = $user->createToken("token")->plainTextToken;

        $response = [
            "status" => "success",
            "token" => $token,
            "id" => $user->id,
            "name" => $user->name
        ];

        return response($response, 201);
    }


    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();

        return [
            "status" => "success"
        ];
    }
}