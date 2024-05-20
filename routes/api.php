<!-- 0.1.6 -->

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// use App\Http\Controllers\Admin\Api\V1\CategoryController;
// use App\Http\Controllers\Admin\Api\V1\CountryController;
// use App\Http\Controllers\Admin\Api\V1\FilmController;
// use App\Http\Controllers\Admin\Api\V1\GenderController;
// use App\Http\Controllers\Admin\Api\V1\RatingController;
// use App\Http\Controllers\Admin\Api\V1\ReviewController;
// use App\Http\Controllers\Admin\Api\V1\UserController;

use App\Http\Controllers\Mobile\Api\V1\AuthController;
use App\Http\Controllers\Mobile\Api\V1\StreamController;

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
    
    Route::post("/users/{id}/reviews", [ReviewController::class, 'store']);
    Route::get("/users/{user}/reviews", [ReviewController::class, 'index']);
    Route::delete("/users/{user}/reviews/{review}", [ReviewController::class, 'destroy']);

    // Route::post("/users/{user}/ratings", [RatingController::class, 'store']);
    Route::get("/users/{user}/ratings", [RatingController::class, 'index']);
    Route::delete("/users/{user}/ratings/{rating}", [RatingController::class, 'destroy']);

    // ------------------------------  ----------------------------//

    
});

Route::post('/start-stream', [StreamController::class, 'startStream']);

// Public Routes
Route::post("/auth/signup", [AuthController::class, "register"]);
Route::post("/auth/signin", [AuthController::class, "login"]);


Route::get('/test', function(){
    return view('test_admin');
});

