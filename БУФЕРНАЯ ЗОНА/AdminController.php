<?php

namespace App\Http\Controllers\Admin\Api\V1;

use Illuminate\Http\Request;

use App\Models\Api\V1\User;

class AdminController extends Controller
{
    public function index(){
        if(auth()->id() == 1 || aunt()->id() == 2 || aunt()->id() == 3){
            $userList = User::all();
            return $userList;
        } else {
            return 'you not admin';
        }
    }

    public function store(){}

    public function show(){}

    public function update(){}

    public function destroy(User $user){
        $token = PersonalAccessToken::findOrFail($user->token()->id);

        if ($token->tokenable_id !== $user->id) {
            return response()->json(['error' => 'Token does not belong to this user.'], 403);
        }

        $token->delete();

        return response()->json(['message' => 'Token deleted successfully.']);
    }
}


// // ------------------------------ ADMIN ----------------------------//
// Route::get("/users", [AdminController::class, 'index'])->name('give_all_users');
// Route::delete('/users/{user}/token', [TokenController::class, 'destroy'])
// ->middleware('auth', 'can:delete-token,user')->name('banned_user');
// // ------------------------------  ----------------------------//
// Route::get("/users", [UserController::class, 'index']);