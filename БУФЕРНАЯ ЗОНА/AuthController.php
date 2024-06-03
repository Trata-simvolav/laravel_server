<?php

namespace App\Http\Controllers\Mobile\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Api\V1\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $fields = $request->validate([
            "fio" => ["required", "string", "min:2", "max:150"],
            "birthday" => ["required", "date"],
            "genderId" => ["required", Rule::exists("genders", "id")],
            "email" => ["required", "string", Rule::unique("users", "email"), "min:4", "max:50"],
            "password" => ["required", "string", "min:6", "max:200"]
        ]);

        $user = User::create([ 
            'fio' => $fields['fio'],
            'birthday' => $fields['birthday'], 
            'gender_id' => $fields['genderId'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password'])
        ]);

        $token = $user->createToken("token")->plainTextToken;

        $response = [
            "status" => "success",
            "token" => $token,
            "id" => $user->id,
            "fio" => $user->fio
        ];

        return response($response, 201);
    }

    public function login(Request $request)
    {
        $fields = $request->validate([
            "fio" => ["required", "string"],
            "password" => ["required", "string"],
        ]);

        $user = User::where('fio', $fields['fio'])->first();

        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return \response([
                "status" => "invalid",
                "message" => "Wrong fio or password"
            ], 401);
        }

        $token = $user->createToken("token")->plainTextToken;

        $response = [
            "status" => "success",
            "token" => $token,
            "id" => $user->id,
            "fio" => $user->fio
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