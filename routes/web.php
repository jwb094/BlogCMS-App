<?php

use Illuminate\Support\Facades\Route;

//Public - Frontend
    Route::get('/', function () {
            return view('frontend.index');
        });

        Route::get('/blogs', function () {
            return view('frontend.blog');
        });
          Route::get('/post/{id}', function () {
            return view('frontend.post');
        });
          Route::get('/post/{id}', function () {
            return view('frontend.post');
        });

//Admin - Backend
Route::prefix('admin')->group(function () {
    Route::prefix('admin/posts/')->group(function () {
        Route::get('post/add', function () {
                return view('frontend.post');
        });
           Route::get('post/edit', function () {
                return view('frontend.post');
        });
           Route::get('post/delete', function () {
                return view('frontend.post');
        });
    });
  

});