<?php

use Illuminate\Support\Facades\Route;

//Public - Frontend
Route::get('/', function () {return view('frontend.index');});
Route::get('/blogs', function () {return view('frontend.blog');});
Route::get('/blog/{id}', function () {return view('frontend.blogPost');});
Route::get('/category/{slug}', function () {return view('frontend.post.show');});
Route::get('/tags/{slug}', function () {return view('frontend.tag');});
Route::get('/search', function () {return view('frontend.search');});
Route::get('/about', function () {return view('frontend.about');});
Route::get('/contact', function () {return view('frontend.contact');});

//Admin - Backend
Route::prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('backend.index');
    })->name("admin.dashboard");
    Route::prefix('admin/posts/')->group(function () {
        
        Route::get('/index', function () {return view('backend.index');})->name("admin.post.index");

        Route::get('/add', function () {return view('backend.post.add');})->name("admin.post.add");

        Route::get('/edit', function () {return view('backend.post.edit');})->name("admin.post.edit");

        Route::get('/delete', function () {})->name("admin.post.delete");
    });
    //Catgeory
    Route::prefix('admin/categories/')->group(function () {
        
        Route::get('/index', function () {return view('backend.category.index');})->name("admin.category.index");

        
        Route::get('/add', function () {return view('backend.category.edit');})->name("admin.category.add");

        Route::get('/edit', function () {return view('backend.category.edit');})->name("admin.category.edit");

        Route::get('/delete', function () {})->name("admin.category.delete");
    });

    //Tags
    Route::prefix('admin/tags/')->group(function () {
        
        Route::get('/index', function () {return view('backend.tags.index');})->name("admin.tags.index");

        Route::get('/add', function () {return view('backend.tags.edit');})->name("admin.tags.add");

        Route::get('/edit', function () {return view('backend.tags.edit');})->name("admin.tags.edit");

        Route::get('/delete', function () {})->name("admin.category.delete");
    });
});
