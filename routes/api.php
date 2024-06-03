<?php
// 0.1.8
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;  // \Admin\Api\V1
use App\Http\Controllers\Admin\Api\V1\VideoController;

/*
|
|--------------------------------------------------------------------------
|           ADMIN ROUTES
|--------------------------------------------------------------------------
|
*/

// Protected Routs
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post("auth/signout", [AuthController::class, 'logout']);

    Route::get("/users/{user}", [UserController::class, 'show']);
    Route::put("/users", [UserController::class, 'update']);
    Route::delete("/users", [UserController::class, 'destroy']);
    
    

    // ------------------------------  ----------------------------//
});
Route::get("/video/{user_id}", [VideoController::class, 'show']);
    Route::post("/video", [VideoController::class, 'store']);
    Route::delete("/video/{id}", [VideoController::class, 'destroy']);

// Public Routes
Route::post("/auth/signup", [AuthController::class, "register"]); 
Route::post("/auth/signin", [AuthController::class, "login"]);


Route::get('/test', function(){
    return view('test_admin');
});
