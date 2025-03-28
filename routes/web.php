<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Models\Message;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\SingletonController;
use App\Http\Controllers\GreetingController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    // return Message::get();
    // return auth()->user()->id;
    // Message::truncate();
    User::where('id', auth()->user()->id)->update(['last_seen' => now()]);
    // return auth()->user();
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/get/messages', [MessageController::class, 'index'])->name('user.message');
    Route::post('/send/message', [MessageController::class, 'create'])->name('send.message');

    Route::get('todos', [TodoController::class, 'index'])->name('todos');
    Route::post('todo/create', [TodoController::class, 'create'])->name('create.todo');

    Route::get('singleton', [SingletonController::class, 'singletonExample'])->name('sinlgeton');

});


Route::get('chats', [ChatController::class, 'index']);
Route::get('greeting/{role}', [GreetingController::class, 'index'])->name('greeting');
require __DIR__.'/auth.php';
