<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('/guest/landing-page');
});

Route::get('/login', function () {
    return view('/guest/login');
});
