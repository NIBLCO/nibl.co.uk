<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'Pages@index');
Route::get('/about', 'Pages@about');
Route::get('/faq', 'Pages@faq');
Route::get('/bots/{botName?}', 'Search@bots');
Route::get('/search', 'Search@search');
