<?php

namespace App\Http\Controllers\Mobile\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Mail;

use App\Mail\RegistrationConfirmedMail;
use App\Models\Api\V1\User;
use App\Models\Api\V1\Action;

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
        ]); // Вот данные для входа
        
        $action = Action::create([
            'storage_type' => 'u',
            'data' => '[]'
        ]);

        $user = User::create([ 
            'fio' => $fields['fio'],
            'birthday' => $fields['birthday'], 
            'gender_id' => $fields['genderId'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password']),
            'action' => $action->id,
            'securiti'=>true
        ]);

        // Mail::to($fields['email'])->send(new RegistrationConfirmedMail());

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

        if($user->isBanned()){
            return response(['message' => 'This is user banned'], 403);
        }

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