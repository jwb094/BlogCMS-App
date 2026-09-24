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
use App\Http\Controllers\Public\UserController as PublicUserController;
// use App\Http\Controllers\Public\SearchController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\EmailVerificationController;

//Public - Frontend
Route::get('/', [BlogController::class, 'index'])->name('home');
Route::get('/blogs', [BlogController::class, 'blog'])->name('blog.archive');
Route::get('/blog/{id}', [BlogController::class, 'blogPost'])->name('blog.post');
Route::get('/category/{slug}', [BlogController::class, 'blogPost'])->name('blog.category');
Route::get('/tags/{slug}', [BlogController::class, 'blogPost'])->name('blog.tag');
Route::get('/search', [SearchController::class, 'search'])->name('blog.search');
Route::get('/about', function () {
    return view('frontend.company_and_support.about');
});
Route::get('/contact', [CompanyController::class, 'contact']);
Route::get('/terms', function () {
    return view('frontend.company_and_support.terms');
});
Route::get('/privacy', function () {
    return view('frontend.company_and_support.privacy');
});

Route::get('/login', [PublicUserController::class, 'login'])
        ->name('profile.login');
Route::post('/sign', [PublicUserController::class, 'signin'])
        ->name('profile.signin');
Route::get('/register', [PublicUserController::class, 'register'])
        ->name('profile.register');
Route::post('/store', [PublicUserController::class, 'store'])
        ->name('profile.store');

// //Verification notice
// Route::get('/email/verify', function () {
//     return view('auth.verify-email');
// })->middleware('auth')->name('verification.notice');

// Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
//     $request->fulfill();
//     return redirect()->route('admin.dashboard');
// })->middleware([
//     'auth',
//     'signed',
//     'throttle:6,1',
// ])->name('verification.verify');

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Email Verification
    |--------------------------------------------------------------------------
    */

    // Display verification notice
    Route::get('/email/verify', [
        EmailVerificationController::class,
        'notice',
    ])->name('verification.notice');

    // Process verification link
    Route::get('/email/verify/{id}/{hash}', [
        EmailVerificationController::class,
        'verify',
    ])
        ->middleware([
            'signed',
            'throttle:6,1',
        ])
        ->name('verification.verify');

    // Resend verification email
    Route::post('/email/verification-notification', [
        EmailVerificationController::class,
        'resend',
    ])
        ->middleware('throttle:6,1')
        ->name('verification.send');
});

//resend route
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent.');
})->middleware([
    'auth',
    'throttle:6,1',
])->name('verification.send');

//Admin - Backend
Route::middleware(['auth'])->prefix('admin')->group(function () {

    //Profile

    Route::prefix('profile/')->group(function () {
        Route::resource('profile', UserController::class)
            ->names('admin.profile')
            ->only(['edit', 'update', 'destroy']);

        Route::get('/profile', [UserController::class, 'profile'])
            ->name('admin.profile');

             Route::get('logout', [UserController::class, 'logout'])
            ->name('admin.profile.logout');


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
