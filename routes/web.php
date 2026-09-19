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

    //Profile
    Route::prefix('profile/')->group(function () {
            Route::get('/signin', function () {return view('backend.post.sign');})->name("admin.profile.signin");
            Route::post('/login', function () {})->name("backend.profile.login")->name("admin.profile.login");
            Route::get('/register', function () {return view('backend.post.edit');})->name("admin.profile.register");
            Route::post('/store', function () {})->name("backend.profile.store")->name("admin.profile.store");
            Route::get('/profile', function () {return view('backend.profile.edit');})->name("admin.profile");
            Route::get('/profile/update', function () {})->name("admin.profile.update");
    });

    Route::get('/dashboard', function () {return view('backend.dashboard.index');})->name("admin.dashboard");



    Route::prefix('posts/')->group(function () {
        Route::get('/index', function () {return view('backend.posts.index');})->name("admin.post.index");
        Route::get('/add', function () {return view('backend.posts.add');})->name("admin.post.add");
        Route::get('/store', function () {})->name("backend.posts.store");
        Route::get('/edit', function () {return view('backend.posts.edit');})->name("admin.post.edit");
        Route::post('/update/{id}', function () {})->name("backend.posts.update");
        Route::get('/delete', function () {})->name("backend.posts.delete");
    });
    //Catgeory
    Route::prefix('category/')->group(function () {
        Route::get('/index', function () {return view('backend.category.index');})->name("admin.category.index");
        Route::get('/add', function () {return view('backend.category.edit');})->name("admin.category.add");
        Route::get('/store', function () {return view('backend.category.edit');})->name("admin.category.store");
        Route::get('/edit', function () {return view('backend.category.edit');})->name("admin.category.edit");
        Route::get('/delete', function () {})->name("backend.category.delete");
    });

    //Tags
    Route::prefix('tags/')->group(function () {
        
        Route::get('index', function () {return view('backend.tags.index');})->name("admin.tags.index");
        Route::get('add', function () {return view('backend.tags.edit');})->name("admin.tags.add");
        Route::get('store', function () {return view('backend.tags.edit');})->name("admin.tags.store");
        Route::get('edit', function () {return view('backend.tags.edit');})->name("admin.tags.edit");
        Route::post('update/{id}', function () {})->name("backend.tags.update");
        Route::get('delete', function () {})->name("backend.tags.delete");
    });

    Route::prefix('media/')->group(function () {
        Route::get('index', function () {return view('backend.media.index');})->name("admin.media.index");
        Route::get('show', function () {return view('backend.media.show');})->name("admin.media.add");
        Route::get('delete', function () {})->name("backend.media.delete");
    });
});
