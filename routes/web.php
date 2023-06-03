<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AvatarController;
use App\Http\Controllers\TicketController;
use App\Models\User;
use Illuminate\Support\Facades\Route;


use Laravel\Socialite\Facades\Socialite;




use App\Models\Ticket;
use App\Notifications\TicketUpdatedNotification;



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


Route::middleware('auth')->group(function () {
    Route::resource('tickets', TicketController::class);
    // Route::get('/tickets/create', [TicketController::class, 'create'])->name('ticket.create');
    // Route::post('/tickets/create', [TicketController::class, 'store'])->name('ticket.store');
});



// test blade components
Route::get('zezzella', function () {
    return view('zezzella');
});



 
// test notification Update Ticket
Route::get('/notification', function () {


    if($ticket = Ticket::find(4)){
        return (new TicketUpdatedNotification($ticket))
        ->toMail($ticket->user);
    } 

    return 'Not Found';
});
