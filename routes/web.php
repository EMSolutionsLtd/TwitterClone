<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TweetController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', [TweetController::class, 'index'])->name('tweets.index');
Route::post('/tweets', [TweetController::class, 'store'])->name('tweets.store');
Route::delete('/tweets/{id}', [TweetController::class, 'destroy'])->name('tweets.destroy');


require __DIR__.'/auth.php';
