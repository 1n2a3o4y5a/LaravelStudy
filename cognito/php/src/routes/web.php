<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CognitoController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'cognito', 'as' => 'cognito.'], function() {
    Route::get('/signup', function () { return view('cognito.signup'); })->name('signup');
    Route::post('/signup', [CognitoController::class, 'signup']);
    Route::get('/confirm', [CognitoController::class, 'confirmView'])->name('confirm');
    Route::post('/confirm', [CognitoController::class, 'confirm']);
    Route::get('/login', [CognitoController::class, 'loginView'])->name('login');
    Route::post('/login', [CognitoController::class, 'login']);
    Route::get('/callback', [CognitoController::class, 'callback']);
});
