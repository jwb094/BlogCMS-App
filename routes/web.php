<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Public\BlogController;
use App\Http\Controllers\Public\CompanyController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\SearchController;
// use App\Http\Controllers\Public\SearchController;
use App\Http\Controllers\Public\UserController as PublicUserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Public - Frontend
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/blogs', [BlogController::class, 'blog'])->name('blog.archive');
Route::get('/blog/{id}', [BlogController::class, 'blogPost'])->name('blog.post');
Route::get('/categories', [BlogController::class, 'categories'])->name('blog.categories');
Route::get('/category/{slug}', [BlogController::class, 'category'])->name('blog.category');
Route::get('/tag/{slug}', [BlogController::class, 'tag'])->name('blog.tag');
Route::get('/search', [SearchController::class, 'search'])->name('blog.search');
Route::view('/about', 'frontend.company_and_support.about')->name('pages.about');
Route::get('/contact', [CompanyController::class, 'contact'])->name('pages.contact');
Route::view('/terms', 'frontend.company_and_support.terms_and_conditions')->name('pages.terms');
Route::view('/privacy', 'frontend.company_and_support.privacy-policy')->name('pages.privacy');

Route::get('/login', [PublicUserController::class, 'login'])
    ->name('login');
Route::post('/sign', [PublicUserController::class, 'signin'])
    ->name('profile.signin');
Route::get('/user_reset_password', [PublicUserController::class, 'user_reset_password'])
    ->name('profile.reset_password');
Route::post('/reset_password', [PublicUserController::class, 'reset_password'])
    ->name('profile.reset');
Route::get('/register', [PublicUserController::class, 'register'])
    ->name('profile.register');
Route::post('/store', [PublicUserController::class, 'store'])
    ->name('profile.store');

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

// resend route
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent.');
})->middleware([
    'auth',
    'throttle:6,1',
])->name('verification.send');

// Admin - Backend
Route::middleware(['auth'])->prefix('admin')->group(function () {

    // Profile

    Route::resource('profile', UserController::class)
        ->names('admin.profile');
    Route::prefix('profile')->group(function () {

        Route::post('logout', [UserController::class, 'logout'])
            ->name('admin.profile.logout');

        Route::get('/{userId}/password_change', [UserController::class, 'password_change'])
            ->name('admin.profile.password_change');

        Route::post('/password_update', [UserController::class, 'password_update'])
            ->name('admin.profile.password_update');
    });
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('admin.dashboard');

    Route::get('posts/bin', [PostController::class, 'bin'])
        ->name('admin.post.bin');
    Route::patch('posts/{postId}/restore', [PostController::class, 'restore'])
        ->name('admin.post.restore');
    Route::resource('posts', PostController::class)
        ->names('admin.post');
    Route::delete('posts/{post}/permanent', [PostController::class, 'forceDestroy'])
        ->name('admin.post.force-destroy');

    Route::resource('comments', CommentController::class)
        ->names('admin.comments')
        ->only(['index', 'edit', 'update', 'destroy']);

    Route::resource('category', CategoryController::class)
        ->names('admin.category');

    Route::resource('tags', TagController::class)
        ->names('admin.tags');

    Route::resource('media', MediaController::class)
        ->names('admin.media')
        ->only(['index', 'show']);
});
