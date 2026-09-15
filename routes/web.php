<?php

use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\CommentController;

use App\Http\Controllers\Public\BlogController;
use App\Http\Controllers\Public\ContactController;
use App\Http\Controllers\Public\SearchCController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\UserController;

use Illuminate\Support\Facades\Route;

//Public - Frontend
Route::get('/', function () {
    return view('frontend.index');
});
Route::get('/blogs', function () {
    return view('frontend.blog');
});
Route::get('/blog/{id}', function () {
    return view('frontend.blogPost');
});
Route::get('/category/{slug}', function () {
    return view('frontend.post.show');
});
Route::get('/tags/{slug}', function () {
    return view('frontend.tag');
});
Route::get('/search', function () {
    return view('frontend.search');
});
Route::get('/about', function () {
    return view('frontend.about');
});
Route::get('/contact', function () {
    return view('frontend.contact');
});

//Admin - Backend
Route::prefix('admin')->group(function () {

    //Profile
    Route::prefix('profile/')->group(function () {
        Route::get('/signin', function () {
            return view('backend.post.add');
        })->name("admin.profile.signin");
        Route::post('/login', function () {})->name("admin.profile.login");
        Route::get('/register', function () {
            return view('backend.post.edit');
        })->name("admin.profile.register");
        Route::post('/store', function () {})->name("admin.profile.store");

        Route::get('/profile', function () {
            return view('backend.post.edit');
        })->name("admin.profile.show");
        Route::get('/profile/update', function () {})->name("admin.profile.update");
    });

    Route::get('/dashboard', function () {
        return view('backend.index');
    })->name("admin.dashboard");


    Route::resource('posts', PostController::class)
    ->names('backend.posts');


    Route::resource('comments', CommentController::class)
    ->names('backend.comments');

    Route::resource('category', CategoryController::class)
    ->names('backend.category');


    Route::resource('tags', TagController::class)
    ->names('backend.tags');

    Route::resource('media', MediaController::class)
    ->names('backend.media');
    // ->names('backend.password');

    // Route::resource('category', CategoryController::class)
    // ->names('backend.password');


    // Route::resource('tags', TagController::class)
    // ->names('backend.password');

    // Route::resource('media', MediaController::class)
    // ->names('backend.password');
    // ->names('backend.password');

    // Route::resource('category', CategoryController::class)
    // ->names('backend.password');


    // Route::resource('tags', TagController::class)
    // ->names('backend.password');

    // Route::resource('media', MediaController::class)
    // ->names('backend.password');
    // ->names('backend.password');

    // Route::resource('category', CategoryController::class)
    // ->names('backend.password');


    // Route::resource('tags', TagController::class)
    // ->names('backend.password');

    // Route::resource('media', MediaController::class)
    // ->names('backend.password');

    // Route::prefix('posts/')->group(function () {
    //     Route::get('/index', function () {return view('backend.index');})->name("admin.post.index");
    //     Route::get('/add', function () {return view('backend.post.add');})->name("admin.post.add");
    //     Route::get('/store', function () {})->name("admin.post.store");
    //     Route::get('/edit', function () {return view('backend.post.edit');})->name("admin.post.edit");
    //     Route::post('/update/{id}', function () {})->name("admin.tags.update");
    //     Route::get('/delete', function () {})->name("admin.post.delete");
    // });
    // //Catgeory
    // Route::prefix('categories/')->group(function () {
    //     Route::get('/index', function () {return view('backend.category.index');})->name("admin.category.index");
    //     Route::get('/add', function () {return view('backend.category.edit');})->name("admin.category.add");
    //     Route::get('/store', function () {return view('backend.category.edit');})->name("admin.category.store");
    //     Route::get('/edit', function () {return view('backend.category.edit');})->name("admin.category.edit");
    //     Route::get('/delete', function () {})->name("admin.category.delete");
    // });

    // //Tags
    // Route::prefix('tags/')->group(function () {

    //     Route::get('index', function () {return view('backend.tags.index');})->name("admin.tags.index");

    //     Route::get('add', function () {return view('backend.tags.edit');})->name("admin.tags.add");
    //     Route::get('store', function () {return view('backend.tags.edit');})->name("admin.tags.store");

    //     Route::get('edit', function () {return view('backend.tags.edit');})->name("admin.tags.edit");
    //     Route::post('update/{id}', function () {})->name("admin.tags.update");
    //     Route::get('delete', function () {})->name("admin.tags.delete");
    // });

    //     Route::prefix('media/')->group(function () {

    //     Route::get('index', function () {return view('backend.media.index');})->name("admin.media.index");

    //     Route::get('show', function () {return view('backend.media.show');})->name("admin.media.add");

    //     Route::get('delete', function () {})->name("admin.media.delete");
    // });
});
