<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\levelcontroller;
use App\Http\Controllers\kategoricontroller;
use App\Http\Controllers\usercontroller;
use App\Http\Controllers\WelcomeController;


Route::get('/', [WelcomeController::class, 'index']);