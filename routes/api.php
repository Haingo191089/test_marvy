<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\ScoreController;

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

// user routes
Route::post(UserController::REGISTER_URL, [UserController::class, UserController::REGISTER_METHOD]);
Route::get(UserController::GET_USER_INFO_URL, [UserController::class, UserController::GET_USER_INFO_METHOD])->where('user_id', '\d+');
Route::get(UserController::GET_ALL_USER_INFO_URL, [UserController::class, UserController::GET_ALL_USER_INFO_METHOD]);

//score routes
Route::post(ScoreController::SAVE_SCORE_URL, [ScoreController::class, ScoreController::SAVE_SCORE_METHOD])->middleware('validateToken');