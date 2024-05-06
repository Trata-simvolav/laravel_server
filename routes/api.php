<!-- 0.1.3 -->

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\V1\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Protected Routs
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post("auth/signout", [AuthController::class, 'logout']);

    Route::get("/users/{user}", [UserController::class, 'show']);
    Route::put("/users", [UserController::class, 'update']);
    Route::delete("/users", [UserController::class, 'destroy']);
});

// Public Routes
Route::post("/auth/signup", [AuthController::class, "register"]);
Route::post("/auth/signin", [AuthController::class, "login"]);
