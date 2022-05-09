<?php

use App\Http\Controllers\Controller;
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

Route::get('/dashboard/', [Controller::class, 'viewDashboard'])->name('viewDashboard');

Route::get('/create-event/', [Controller::class, 'viewCreateEvent'])->name('viewCreateEvent');
Route::post('/create-event/', [Controller::class, 'createEvent'])->name('createEvent');

Route::get('/event/{slug}', [Controller::class, 'viewEvent'])->name('viewEvent');
Route::get('/edit-event/{slug}', [Controller::class, 'viewEditEvent'])->name('viewEditEvent');
Route::post('/edit-event/{slug}', [Controller::class, 'editEvent'])->name('editEvent');

Route::get('/create-ticket/{slug}', [Controller::class, 'viewCreateTicket'])->name('viewCreateTicket');
Route::post('/create-ticket/{slug}', [Controller::class, 'createTicket'])->name('createTicket');

Route::get('/create-session/{slug}', [Controller::class, 'viewCreateSession'])->name('viewCreateSession');
Route::post('/create-session/{slug}', [Controller::class, 'createSession'])->name('createSession');
Route::get('/edit-session/{id}', [Controller::class, 'viewEditSession'])->name('viewEditSession');
Route::post('/edit-session/{id}', [Controller::class, 'editSession'])->name('editSession');

Route::get('/create-channel/{slug}', [Controller::class, 'viewCreateChannel'])->name('viewCreateChannel');
Route::post('/create-channel/{slug}', [Controller::class, 'createChannel'])->name('createChannel');

Route::get('/create-room/{slug}', [Controller::class, 'viewCreateRoom'])->name('viewCreateRoom');
Route::post('/create-room/{slug}', [Controller::class, 'createRoom'])->name('createRoom');

Route::get('/login/{who?}', [Controller::class, 'viewLogin'])->name('viewLogin');
Route::post('/login/{who?}', [Controller::class, 'login'])->name('login');
Route::get('/logout/', [Controller::class, 'logout'])->name('logout');
