<?php

namespace App\Http\Controllers;

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
        ]); // данные для входа
        
        $action = Action::create([
            'storage_type' => 'u',
            'data' => '[]'
        ]); // создание записи в базе для активностей пользователя

        $user = User::create([ 
            'fio' => $fields['fio'],
            'birthday' => $fields['birthday'], 
            'gender_id' => $fields['genderId'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password']),
            'action' => $action->id
        ]); // создание уже непосредственно пользователя

        $token = $user->createToken("token")->plainTextToken; // создание токена, для работы с сервером

        $response = [
            "status" => "success",
            "token" => $token,
            "id" => $user->id,
            "fio" => $user->fio
        ]; // поле ответа

        return response($response, 201);
    }

    public function login(Request $request)
    {
        $fields = $request->validate([
            "fio" => ["required", "string"],
            "password" => ["required", "string"],
        ]); // валидация поступивших данных

        $user = User::where('fio', $fields['fio'])->first(); // поиск в базе пользователя

        if($user->isBanned()){
            return response(['message' => 'This is user banned'], 403);
        } // проверка, не забанен ли пользователь

        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return \response([
                "status" => "invalid",
                "message" => "Wrong fio or password"
            ], 401);
        } // проверка пароля

        $token = $user->createToken("token")->plainTextToken; // создание токена

        $response = [
            "status" => "success",
            "token" => $token,
            "id" => $user->id,
            "fio" => $user->fio
        ]; // поле ответа

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