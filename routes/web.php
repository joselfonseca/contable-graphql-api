<?php

use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/{view}', 'SpaController@index')->name('home');

