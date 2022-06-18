<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\EventController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\ChannelController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\User;
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

Route::get('/', [Controller::class, 'dashboard']);
Route::get('/logout/', [User::class, 'destroy'])->name('logout');
Route::resource('organizer', User::class);
Route::resource('event', EventController::class);
Route::resource('ticket', TicketController::class);
Route::resource('session', SessionController::class);
Route::resource('channel', ChannelController::class);
Route::resource('room', RoomController::class);
