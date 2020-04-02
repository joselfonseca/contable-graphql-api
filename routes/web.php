<?php

use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/{view}', 'SpaController@index')->where('view', '.*')->name('home');

