<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProjectController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Web interface routes for Project Approval System.
|--------------------------------------------------------------------------
*/

// Public welcome page
Route::get('/', function () {
    return view('welcome');
});

// Authentication Routes
Route::controller(AuthController::class)->group(function () {
    Route::get('/register', 'showRegister')->name('register');
    Route::post('/register', 'register');
    Route::get('/login', 'showLogin')->name('login');
    Route::post('/login', 'login');
    Route::post('/logout', 'logout')->name('logout');
});

// Authenticated Users
Route::middleware(['auth'])->group(function () {

    // User Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    // Project Routes (for regular users)
    Route::prefix('projects')->name('projects.')->group(function () {
        Route::get('/create', [ProjectController::class, 'create'])->name('create');
        Route::post('/', [ProjectController::class, 'store'])->name('store');
    });

    // Admin Routes (only accessible by admins)
    Route::patch('/admin/projects/{id}/status', [ProjectController::class, 'changeStatus'])->name('projects.changeStatus');
    Route::get('/admin/projects', [ProjectController::class, 'adminProjects'])->name('admin.projects')->middleware('auth');
});
