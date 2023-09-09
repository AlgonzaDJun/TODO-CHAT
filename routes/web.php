<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\FriendListController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PusherController;
use App\Http\Controllers\TodoController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [TodoController::class, 'index'])->name('todo');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('todo', TodoController::class);
    Route::get('/todo', [TodoController::class, 'index']);
    Route::put('/todo/checked/{id}', [TodoController::class, 'checked'])->name('todo.checked');

    Route::get('/chat', [ChatController::class, 'index']);
    Route::get('/chat/{id}', [ChatController::class, 'room'])->name('chat.room');
    Route::get('/add-friends', [ChatController::class, 'addFriends']);
    Route::post('/send-chat/{id}', [PusherController::class, 'sendMessage'])->name('chat.send');
    Route::post('/add-new-friend', [FriendListController::class, 'addFriend'])->name('add-new-friend');
    // Route::get('/add-friends', [FriendListController::class, 'getFriend']);
});

Route::get('/newchat', [PusherController::class, 'sendNotif']);


require __DIR__ . '/auth.php';
