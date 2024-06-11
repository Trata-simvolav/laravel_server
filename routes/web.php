<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController; // Mobile\Api\V1\
use App\Http\Controllers\Mobile\Api\V1\UserController;

use App\Http\Controllers\Mobile\Api\V1\VideoController; //

/*
|
|--------------------------------------------------------------------------
|           USER ROUTES
|--------------------------------------------------------------------------
|
*/

// Protected Routs
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/aunt/test', function(){
        return view('test_for_aunt');
    });
});

Route::post("auth/signout", [AuthController::class, 'logout']);

Route::get("/users/{user}", [UserController::class, 'show']);
Route::put("/users", [UserController::class, 'update']);
Route::delete("/users", [UserController::class, 'destroy']);

// Route::post("/users/{user}/ratings", [RatingController::class, 'store']);
// Route::get("/users/{user}/ratings", [RatingController::class, 'index']);
// Route::delete("/users/{user}/ratings/{rating}", [RatingController::class, 'destroy']);

Route::get("/video", [VideoController::class, 'index']);
Route::get("/video/{user_id}", [VideoController::class, 'show']);

// Public Routes
Route::post("/auth/signup", [AuthController::class, "register"]);
Route::post("/auth/signin", [AuthController::class, "login"]);

Route::get('/test', function(){
    return view('test_mobile');
});


