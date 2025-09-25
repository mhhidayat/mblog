<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Livewire\BlogIndex;
use App\Livewire\BlogPost;
use App\Livewire\AboutPage;
use App\Livewire\ServicesPage;
use App\Livewire\ContactPage;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\PostForm;

Route::get('/', BlogIndex::class)->name('blog.index');
Route::get('/post/{slug}', BlogPost::class)->name('blog.post');

Route::get('/about', AboutPage::class)->name('about');
Route::get('/services', ServicesPage::class)->name('services');
Route::get('/contact', ContactPage::class)->name('contact');

Route::middleware('guest')->group(function () {
    Route::get('/login', Login::class)->name('login');
    Route::get('/register', Register::class)->name('register');
});

Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout');

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', Dashboard::class)->name('dashboard');
    Route::get('/posts/create', PostForm::class)->name('posts.create');
    Route::get('/posts/{post}/edit', PostForm::class)->name('posts.edit');
});
