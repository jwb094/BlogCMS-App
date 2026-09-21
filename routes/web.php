<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Public\BlogController;
use App\Http\Controllers\Public\CompanyController;
use App\Http\Controllers\Public\ContactController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\SearchController;

// use App\Http\Controllers\Public\SearchController;



use Illuminate\Support\Facades\Route;

//Public - Frontend
Route::get('/', [HomeController ::class, 'index']);
Route::get('/blogs',[BlogController::class, 'blog']);
Route::get('/blog/{id}',[BlogController::class, 'blogPost']);
Route::get('/category/{slug}',[BlogController::class, 'blogPost']);
Route::get('/tags/{slug}',[BlogController::class, 'blogPost']);
Route::get('/search', [SearchController::class,'search']);
Route::get('/about',function(){
     return view('frontend.company_and_support.about');
});
Route::get('/contact',[CompanyController::class,'contact']);
Route::get('/terms',function(){
     return view('frontend.company_and_support.terms');
});
Route::get('/privacy',function(){
     return view('frontend.company_and_support.privacy');
});

//Admin - Backend
Route::prefix('admin')->group(function () {

    //Profile
    // Route::prefix('profile/')->group(function () {
    //     Route::get('/signin', function () {
    //         return view('backend.post.add');
    //     })->name("admin.profile.signin");
    //     Route::post('/login', function () {})->name("admin.profile.login");
    //     Route::get('/register', function () {
    //         return view('backend.post.edit');
    //     })->name("admin.profile.register");
    //     Route::post('/store', function () {})->name("admin.profile.store");

    //     Route::get('/profile', function () {
    //         return view('backend.post.edit');
    //     })->name("admin.profile.show");
    //     Route::get('/profile/update', function () {})->name("admin.profile.update");
    // });
    Route::prefix('profile/')->group(function () {
        Route::resource('profile', UserController::class)
            ->names('admin.profile')
            ->only(['edit', 'update', 'destroy']);

        Route::get('/profile', [UserController::class, 'profile'])
            ->name('admin.profile');


        Route::get('/change_password', [UserController::class, 'change_password'])
            ->name('admin.profile');
    });
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name("admin.dashboard");


    Route::resource('posts', PostController::class)
        ->names('admin.post');


    Route::resource('comments', CommentController::class)
        ->names('admin.comments')
         ->only(['index', 'edit', 'update']);

    Route::resource('category', CategoryController::class)
        ->names('admin.category');


    Route::resource('tags', TagController::class)
        ->names('admin.tags');

    Route::resource('media', MediaController::class)
        ->names('admin.media');
});
