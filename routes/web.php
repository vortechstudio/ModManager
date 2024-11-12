<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/start', \App\Livewire\Core\Start::class)->name('start');
Route::get('/', \App\Livewire\Home::class)->name('home');
Route::get('/core/configuration', \App\Livewire\Core\Configuration::class)->name('configuration');
Route::get('/create-mod', \App\Livewire\CreateMod::class)->name('create-mod');
Route::get('/mod', \App\Livewire\Mods\ModSelector::class)->name('mod-selector');
Route::get('/mod/edit/{modDirectory}', \App\Livewire\Mods\EditMod::class)->name('edit-mod');
