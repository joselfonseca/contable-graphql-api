<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/{view}', 'SpaController@index')->where('view', '.*')->middleware('auth')->name('home');
