<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\userController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//User Related Routes
Route::get('/', [userController::class, "ShowCorrectHomePage"]);
Route::post('/register', [userController::class, "register"]);
Route::post('/login', [userController::class, "login"]);
Route::post('/logout', [userController::class, "logout"]);

//Post Related Routes
Route::get('/create-post', [PostController::class, "showCreateForm"]);
Route::post('/create-post', [PostController::class, "storeNewPost"]);
Route::get('/post/{post}', [PostController::class, "viewSinglePost"]);
