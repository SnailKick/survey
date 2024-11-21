<?php

use App\Http\Controllers\SurveyController;
use App\Http\Controllers\AdminSurveyController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\HomeController; 
use App\Http\Controllers\RoleController;

Route::post('/users/{userId}/assign-admin-role', [RoleController::class, 'assignAdminRole'])->name('assignAdminRole');
// Маршруты для аутентификации
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

Route::post('/logout', [LogoutController::class, 'logout'])->name('logout')->middleware('auth');

// Маршруты для анкет
Route::get('/surveys', [SurveyController::class, 'index'])->name('surveys.index');
Route::get('/surveys/{survey}', [SurveyController::class, 'show'])->name('surveys.show');
Route::post('/surveys/{survey}/submit', [SurveyController::class, 'submit'])->name('surveys.submit');

// Защищенные маршруты для аутентифицированных пользователей
Route::middleware(['auth'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    // Другие маршруты, которые должны быть защищены
});

// Защищенные маршруты для администраторов
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/surveys', [AdminSurveyController::class, 'index'])->name('admin.surveys.index');
    Route::get('/surveys/create', [AdminSurveyController::class, 'create'])->name('admin.surveys.create');
    Route::post('/surveys', [AdminSurveyController::class, 'store'])->name('admin.surveys.store');
    Route::get('/surveys/{survey}/edit', [AdminSurveyController::class, 'edit'])->name('admin.surveys.edit');
    Route::put('/surveys/{survey}', [AdminSurveyController::class, 'update'])->name('admin.surveys.update');
    Route::delete('/surveys/{survey}', [AdminSurveyController::class, 'destroy'])->name('admin.surveys.destroy');
});