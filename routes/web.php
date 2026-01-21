<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/NuestrasEstrellas', function () {
    return view('guest.patrocinadores');
});

Route::get('/Cronograma', function () {
    return view('guest.cronograma');
});

Route::get('/Portafolio', function () {
    return view('guest.portafolio');
});