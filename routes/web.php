<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TransactionController;

Route::get('/', [AuthController::class, 'showLogin'])->name('home');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/admin/received-projects', [ProjectController::class, 'receivedProjects'])->name('admin.received.projects');
Route::post('/projects/send', [ProjectController::class, 'sendProject'])->name('projects.send');
Route::post('/projects/forward', [ProjectController::class, 'forwardProject'])->name('projects.forward');
Route::get('/projects/received', [ProjectController::class, 'receivedProjects'])->name('received.projects');
Route::get('/projects/sent', [ProjectController::class, 'sentProjects'])->name('sent.projects');
Route::get('/projects/{id}/history', [ProjectController::class, 'history'])->name('projects.history');

Route::middleware('auth')->group(function () {
    
    Route::get('/admin/dashboard', [AuthController::class, 'adminDashboard'])->name('dashboard.dashboard');
    Route::get('/admin/users/{id}/edit', [AuthController::class, 'editUser'])->name('admin.users.edit');
    Route::put('/admin/users/{id}', [AuthController::class, 'updateUser'])->name('admin.users.update');
    Route::delete('/admin/users/{id}', [AuthController::class, 'destroyUser'])->name('admin.users.destroy');    Route::get('/engineer/dashboard', [AuthController::class, 'engineerDashboard'])->name('engineer');
    Route::get('/secretary/dashboard', [AuthController::class, 'secretaryDashboard'])->name('secretary');
    Route::get('/accountant/dashboard', [AuthController::class, 'accountantDashboard'])->name('accountant');
    Route::get('/transactions/create', [TransactionController::class, 'create'])->name('transactions.create');
    Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store');
    Route::get('/transactions/{id}/edit', [TransactionController::class, 'edit'])->name('transactions.edit');
    Route::put('/transactions/{id}', [TransactionController::class, 'update'])->name('transactions.update');
    Route::delete('/accountant/transactions/{id}', [TransactionController::class, 'destroy'])->name('transactions.destroy');
    Route::get('/transactions/create', [TransactionController::class, 'create'])->name('transactions.create');
    Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store');
    Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
    Route::get('/projects/create', [ProjectController::class, 'create'])->name('projects.create');
    Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');
});