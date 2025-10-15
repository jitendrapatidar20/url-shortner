<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\AuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ShortUrlController;
use App\Http\Controllers\Admin\InvitationController;
use App\Http\Controllers\RedirectController;

// Admin Route
Route::get('/', [AuthController::class, 'index'])->name('login');
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/post-login', [AuthController::class, 'postLogin'])->name('login_post'); 

Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard'); ; 
Route::get('/logout', [AdminController::class, 'logout'])->name('admin_logout');



Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {

    Route::get('/short-urls', [ShortUrlController::class, 'index'])->name('short_urls.index');
    Route::get('/short-urls/create', [ShortUrlController::class, 'create'])->name('short_urls.create');
    Route::post('/short-urls', [ShortUrlController::class, 'store'])->name('short_urls.store');

    Route::get('/invitations', [InvitationController::class, 'index'])->name('invitations.index');
    Route::get('/invitations/create', [InvitationController::class, 'create'])->name('invitations.create');
    Route::post('/invitations', [InvitationController::class, 'store'])->name('invitations.store');
    Route::post('invitations/{invitation}/approve', [InvitationController::class, 'approve'])->name('invitations.approve');

    Route::resource('companies', \App\Http\Controllers\Admin\CompanyController::class);
    Route::get('companies-list', [\App\Http\Controllers\Admin\CompanyController::class, 'list'])->name('companies.list');
});

Route::get('/r/{code}', [RedirectController::class,'resolve'])->name('shorturl.resolve');


