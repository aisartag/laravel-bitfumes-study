<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AvatarController;

use Illuminate\Support\Facades\Route;


use OpenAI\Laravel\Facades\OpenAI;



/*------------------------------------------------------------------------
|
| test vari
|------------------------------------------------------------------------*/
// require_once __DIR__ . '/dbtest.php';

Route::get('/', function () {
    return view('welcome');
});



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::patch('/profile/avatar', [AvatarController::class, 'update'])->name('profile.avatar');
    Route::post('/profile/avatar/ai', [AvatarController::class, 'generate'])->name('profile.avatar.ai');

});

require __DIR__ . '/auth.php';

