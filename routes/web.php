<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CommentController;

Route::get('/', function(){return view('welcome');});
Route::get('/comments', [CommentController::class, 'index']);
