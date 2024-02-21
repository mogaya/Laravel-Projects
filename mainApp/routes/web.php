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

Route::get('/admins-only', function () {
    //code below replaced with middleware
    // if (Gate::allows('visitAdminPages')) {
    //     return 'Only admins should be able to see this page';
    // }
    // return 'You cannot view this page';
    return 'Only admins should be able to see this page';
})->middleware('can:visitAdminPages');

//User Related Routes
Route::get('/', [userController::class, "ShowCorrectHomePage"])->name('login');
Route::post('/register', [userController::class, "register"])->middleware('guest');
Route::post('/login', [userController::class, "login"])->middleware('guest');
Route::post('/logout', [userController::class, "logout"])->middleware('mustBeLoggedIn');
Route::get('/manage-avatar', [userController::class, 'showAvatarForm'])->middleware('mustBeLoggedIn');
Route::post('/manage-avatar', [userController::class, 'storeAvatar']);

//Post Related Routes
Route::get('/create-post', [PostController::class, "showCreateForm"])->middleware('mustBeLoggedIn');
Route::post('/create-post', [PostController::class, "storeNewPost"])->middleware('mustBeLoggedIn');
Route::get('/post/{post}', [PostController::class, "viewSinglePost"]);
Route::delete('/post/{post}', [PostController::class, 'delete'])->middleware('can:delete,post');
Route::get('/post/{post}/edit', [PostController::class, 'showEditForm'])->middleware('can:update,post');
Route::put('/post/{post}', [PostController::class, 'actuallyUpdate'])->middleware('can:update,post');

//Profile related routes
Route::get('/profile/{user:username}', [userController::class, "profile"]);
