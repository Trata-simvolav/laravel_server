
<?php
// 0.2.0
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;  // \Admin\Api\V1
use App\Http\Controllers\Admin\Api\V1\VideoController;
use App\Http\Controllers\Admin\Api\V1\AdminController;
use App\Http\Controllers\Admin\Api\V1\UserController;

/*
|
|--------------------------------------------------------------------------
|                               ADMIN ROUTES
|--------------------------------------------------------------------------
|
*/

// Protected Routs
Route::group(['middleware' => ['auth:sanctum','checkIfBanned']], function () {
// ------------------------------ TESTS ----------------------------//
    Route::get('/aunt/test', function(){
        return view('test_for_aunt');
    });
// ------------------------------ SIGN OUT ----------------------------//
    Route::post("auth/signout", [AuthController::class, 'logout']);
// ------------------------------ USER ----------------------------//
    Route::get("/users/{user}", [UserController::class, 'show'])->name('dive_information_about_user');
    Route::put("/user", [UserController::class, 'update'])->name('update_information');
    Route::delete("/users", [UserController::class, 'destroy'])->name('delete_account');
// ------------------------------ ADMIN ----------------------------//
    Route::get("/users", [AdminController::class, 'index'])->name('give_all_users');
    Route::post('/users/{user}/banned', [AdminController::class, 'destroy'])
        ->middleware('auth', 'can:delete-token,user')->name('banned_user');
    Route::post("/users/{user}/unbanned", [AdminController::class, 'unbanUser'])->name('unban_user');
// ------------------------------ VIDEO ----------------------------//
    Route::get("/video/{user_id}", [VideoController::class, 'show']);
    Route::post("/video", [VideoController::class, 'store']);
    Route::delete("/video/{id}", [VideoController::class, 'destroy']);
});

// Public Routes
Route::post("/auth/signup", [AuthController::class, "register"]);
Route::post("/auth/signin", [AuthController::class, "login"]);




Route::get('/test', function(){
    return view('test_admin');
});
Route::get('error_auth', function(){
    return view('error_aunt');
})->name('error_auth');