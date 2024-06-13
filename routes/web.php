<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController; // Mobile\Api\V1\
use App\Http\Controllers\Mobile\Api\V1\UserController;
use App\Http\Controllers\Mobile\Api\V1\SubtitlesController;
use App\Http\Controllers\Mobile\Api\V1\VideoController; //

/*
|
|--------------------------------------------------------------------------
|           USER ROUTES
|--------------------------------------------------------------------------
|
*/

// Protected Routs
Route::group(['middleware' => ['auth:sanctum','checkIfBanned']], function () {
    Route::get('/aunt/test', function(){
        return view('test_for_aunt');
    });
// ------------------------------ SIHNOUT ----------------------------//
    
// ------------------------------  ----------------------------//
});

Route::post("auth/signout", [AuthController::class, 'logout']);
// ------------------------------ VIDEO ----------------------------//
    Route::get("/video", [VideoController::class, 'index']);
    Route::get("/video/{user_id}", [VideoController::class, 'show']);
// ------------------------------ USER EDIT ----------------------------//
    Route::get("/users/{user}", [UserController::class, 'show']);
    Route::put("/users", [UserController::class, 'update']);
    Route::put("/user/update_password", [UserController::class, 'update_password'])->name('update_password');
    Route::delete("/users", [UserController::class, 'destroy']);
// ------------------------------ SUBTITLE ----------------------------//
    Route::get("/words/{ident}", [SubtitlesController::class, 'index']); 

// Public Routes
Route::post("/auth/signup", [AuthController::class, "register"]);
Route::post("/auth/signin", [AuthController::class, "login"]);

Route::get('/test', function(){
    return view('test_mobile');
});


