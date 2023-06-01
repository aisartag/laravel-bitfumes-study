<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AvatarController;
use App\Models\User;
use Illuminate\Support\Facades\Route;


use Laravel\Socialite\Facades\Socialite;



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



Route::post('/auth/redirect', function () {
    return Socialite::driver('github')->redirect();
})->name('login.github');

Route::get('/auth/callback', function () {
    $userGithub = Socialite::driver('github')->stateless()->user();

    //  dd($userGithub);

    // updateOrCreate
    $user =  User::firstOrCreate(['email' => $userGithub->email], [
        'name' => $userGithub->name ?? $userGithub->nickname,
        'password' => 'password',
    ]);

    Auth::login($user);

    return redirect('/dashboard');
});
