<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TransactionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// ==========================================
// 1. Authentication & Guest Routes
// مسارات المصادقة والزوار (خارج حماية تسجيل الدخول)
// ==========================================
Route::controller(AuthController::class)->group(function () {
    Route::get('/', 'showLogin')->name('home');
    
    // Registration Routes
    Route::get('/register', 'showRegister')->name('register');
    Route::post('/register', 'register')->name('register.post');
    
    // Login & Logout Routes
    Route::get('/login', 'showLogin')->name('login');
    Route::post('/login', 'login')->name('login.post');
    Route::post('/logout', 'logout')->name('logout');
});

// ==========================================
// 2. Custom Project Operations (Public / Non-Resource)
// مسارات العمليات المخصصة للمشاريع (مثل الإرسال وإعادة التوجيه والسجل)
// ==========================================
Route::controller(ProjectController::class)->group(function () {
    Route::get('/admin/received-projects', 'receivedProjects')->name('admin.received.projects');
    
    // Actions
    Route::post('/projects/send', 'sendProject')->name('projects.send');
    Route::post('/projects/forward', 'forwardProject')->name('projects.forward');
    
    // Views/Lists
    Route::get('/projects/received', 'receivedProjects')->name('received.projects');
    Route::get('/projects/sent', 'sentProjects')->name('sent.projects');
    Route::get('/projects/{id}/history', 'history')->name('projects.history');
});

// ==========================================
// 3. Authenticated Routes (Requires User Login)
// المسارات المحمية (لا يمكن الوصول إليها إلا بعد تسجيل الدخول)
// ==========================================
Route::middleware('auth')->group(function () {

    // ------------------------------------------
    // Dashboards for Different Roles
    // لوحات التحكم الخاصة بصلاحيات النظام المختلفة
    // ------------------------------------------
    Route::controller(AuthController::class)->group(function () {
        Route::get('/admin/dashboard', 'adminDashboard')->name('dashboard.dashboard');
        Route::get('/engineer/dashboard', 'engineerDashboard')->name('engineer');
        Route::get('/secretary/dashboard', 'secretaryDashboard')->name('secretary');
        Route::get('/accountant/dashboard', 'accountantDashboard')->name('accountant');
    });

    // ------------------------------------------
    // User Management (Admin Only)
    // إدارة مستخدمي النظام (تعديل، تحديث، حذف)
    // ------------------------------------------
    Route::prefix('admin')->name('admin.')->group(function () {
        // Generates: edit, update, destroy
        Route::resource('users', AuthController::class)
            ->only(['edit', 'update', 'destroy'])
            ->parameters(['users' => 'id']); // Forces the parameter to be {id}
    });

    // ------------------------------------------
    // Standard Project Management
    // إدارة المشاريع الأساسية
    // ------------------------------------------
    // Generates: index, create, store
    Route::resource('projects', ProjectController::class)
        ->only(['index', 'create', 'store']);

    // ------------------------------------------
    // Financial Transactions Management
    // إدارة المعاملات المالية
    // ------------------------------------------
    
    // Exception: Delete route requires specific prefix (/accountant)
    // استثناء: مسار الحذف يمتلك بادئة مختلفة مخصصة لقسم الحسابات
    Route::delete('/accountant/transactions/{id}', [TransactionController::class, 'destroy'])
        ->name('transactions.destroy');
    
    // Standard Resource routes for transactions
    // المسارات القياسية لإنشاء وتعديل المعاملات
    // Generates: create, store, edit, update
    Route::resource('transactions', TransactionController::class)
        ->only(['create', 'store', 'edit', 'update'])
        ->parameters(['transactions' => 'id']); // Forces the parameter to be {id}
});
