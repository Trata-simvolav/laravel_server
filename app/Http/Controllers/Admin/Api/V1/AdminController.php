<?php

namespace App\Http\Controllers\Admin\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Api\V1\User;
use PersonalAccessToken;

class AdminController extends Controller
{
    public function index(){
        if(auth()->user()->isAdmin()){ // проверка, админ ли отправил запрос
            $userList = User::all(); // получения данных о всех пользователях
            return $userList;
        } else {
            return 'you not admin';
        }
    }

    public function store(){}

    public function show(){}

    public function update(){}

    public function destroy(User $user){
        $tokens = $user->tokens(); 
        $tokenId = $user->tokens()->first()->id;
        $token = $tokens->find($tokenId);       // получение токена выбранного пользователя для дальнейшего удаление
                                             // это не даст ему возможнсть пользоваться проектом
        if ($token->tokenable_id !== $user->id) { // проверка, тот ли токен взяли
            return response()->json(['error' => 'Token does not belong to this user.'], 403);
        }

        $token->delete(); // удаление токена

        $user = User::FindOrFail($user->id);
        if ($user) {
            $user->banned = true;
            $user->save();
        } // регистрация блокировки

        return response()->json(['message' => 'User banned']); // поле ответа
    }

    public function unbanUser(User $user)
    {
        if ($user) { 
            $user->banned = false;
            $user->save();
        } // регистрация разблокировка

        return response()->json(['message' => 'User unbanned']); // поле ответа
    }

}