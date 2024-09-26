<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::resource('orgs', App\Http\Controllers\OrgController::class);
