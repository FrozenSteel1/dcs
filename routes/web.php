<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/




Route::middleware(['auth:sanctum', 'verified'])->get('/', function () {
    return view('main');
})->name('main');
Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
Route::middleware(['auth:sanctum', 'verified'])->get('/divisions', function () {
    return view('divisionsTable');
})->name('divisions');
Route::middleware(['auth:sanctum', 'verified'])->get('/workers', function () {
    return view('workersTable');
})->name('workers');


