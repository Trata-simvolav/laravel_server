<?php

namespace App\Http\Controllers\Admin\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Api\V1\User;
use PersonalAccessToken;

class AdminController extends Controller
{
    public function index(){
        if(auth()->user()->isAdmin()){
            $userList = User::all(); // $userList = User::where('security', '!=', true)->get();
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
        $token = $tokens->find($tokenId);

        if ($token->tokenable_id !== $user->id) {
            return response()->json(['error' => 'Token does not belong to this user.'], 403);
        }

        $token->delete();

        $user = User::FindOrFail($user->id);
        if ($user) {
            $user->banned = true;
            $user->save();
        }

        return response()->json(['message' => 'User banned']);
    }

    // public function banUser($userId)
    // {
    //     $user = User::find($userId);


    //     return redirect()->back()->with('message', 'User has been banned.');
    // }

    public function unbanUser(User $user)
    {
        // $user = User::find($userId);
        if ($user) {
            $user->banned = false;
            $user->save();
        }

        return response()->json(['message' => 'User unbanned']);
    }

}