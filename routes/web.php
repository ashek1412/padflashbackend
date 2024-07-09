<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Livewire::setScriptRoute(function ($handle) {
    return Route::get('/padflashback/livewire/livewire.js', $handle);
});
Livewire::setUpdateRoute(function ($handle) {
    return Route::post('/padflashback/livewire/update', $handle);
});

