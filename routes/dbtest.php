<?php

use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\DB;

Route::get('/', function () {

    // // insert 3 user
    // $user = DB::insert("insert into users(name, email, password) values(?,?,?)", [
    //     'miella',
    //     'miella@example.org',
    //     bcrypt('Aa123456'),
    // ]);



    // $user = DB::table('users')->insert([
    //     'name' => 'miella1',
    //     'email' => 'miella1@example.org',
    //     'password' => bcrypt('Aa123456'),
    // ]);

    // $user = User::create([
    //     'name' => 'miella2',
    //     'email' => 'miella2@example.org',
    //     'password' => 'Aa123456',
    // ]);




    // fetch all users

    // raw************************************************
    // $users = DB::select("select * from users");

    // query builder *************************************
    // $users = DB::table('users')->get();

    // eloquent*******************************************
    // $users = User::all();

    // insert an user

    // raw************************************************
    // $user = DB::insert("insert into users(name, email, password) values(?,?,?)", [
    //     'miella',
    //     'miella@example.org',
    //     'Aa123456'
    // ]);

    // query builder***************************************    
    // $user = DB::table('users')->insert([
    //     'name' => 'miella',
    //     'email' => 'miella@example.org',
    //     'password' => 'Aa123456',
    // ]);

    // eloquent*********************************************
    // try {
    //     $user = User::create([
    //         'name' => 'miella',
    //         'email' => 'miella@example.org',
    //         'password' => 'Aa123456',
    //     ]);
    // } catch (QueryException $e) {
    //     dd($e->getMessage());
    // }


    // update an user

    // raw************************************************************
    // $user = DB::update("update users set name='maella' where id=4");

    // query builder**************************************************
    // $user = DB::table('users')
    //     ->where('email', 'miella@example.org')
    //     ->update([
    //         'name' => 'maella'
    //     ]);

    // eloquent*****************************************************
    // try {
    //     $user = User::where('id', 7)
    //         ->update([
    //             'email' => 'miella@example.org',
    //         ]);
    // } catch (QueryException $e) {
    //     dd($e->getMessage());
    // }

    // oppure
    // $user = User::find(7)->update([
    //     'email' => 'miella@example.org',
    // ]);



    // delete an user

    // raw************************************************************
    //$user = DB::delete("delete from users where id=4");

    // query builder**************************************************
    // $user = DB::table('users')
    //     ->where('name', 'maella')
    //     ->delete();

    // eloquent********************************************************
    // try {
    //     $user = User::where('id', 7)
    //         ->delete();
    // } catch (QueryException $e) {
    //     dd($e->getMessage());
    // }

    // oppure
    // $user = User::find(7)->delete();



    // dd($users);

    dd('dbtext******************************');
});