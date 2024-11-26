<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\{
    MainController,
    AuthController,
    FriendController,
};

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

Route::get('/', [MainController::class, 'index']);

Route::middleware('auth')->group(function() {
    Route::post('/note/color/create', [MainController::class, 'noteColorCreate']);
    Route::post('/note/color/update', [MainController::class, 'noteColorUpdate']);
    Route::get('/note/create', [MainController::class, 'noteCreate']);
    Route::post('/note/submit', [MainController::class, 'noteSubmit']);
    Route::get('/note/{id}/edit', [MainController::class, 'noteEdit']);
    Route::post('/note/{id}/add-friend', [MainController::class, 'noteAddFriend']);
    Route::post('/note/update', [MainController::class, 'noteUpdate']);
    Route::get('/note/{id}', [MainController::class, 'noteView']);
    Route::get('/note/{id}/delete', [MainController::class, 'noteDelete']);

    Route::get('/friends', [FriendController::class, 'show']);
    Route::post('/friend/add', [FriendController::class, 'store']);
    Route::get('/friend/{email}/accept', [FriendController::class, 'accept']);
    Route::get('/friend/{email}/decline', [FriendController::class, 'decline']);
});

Route::post('/#login-modal', [AuthController::class, 'index'])->name('login');
Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);
Route::get('/auth/logout', [AuthController::class, 'logout']);
