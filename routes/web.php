<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\ClassSubjectController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [AuthController::class, 'login']);
Route::post('login', [AuthController::class, 'authLogin']);
Route::get('logout', [AuthController::class, 'logout']);
Route::get('forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('forgot-password', [AuthController::class, 'postForgotPassword']);
Route::get('reset/{token}', [AuthController::class, 'reset']);
Route::post('reset/{token}', [AuthController::class, 'resetPassword']);

Route::group(['middleware' => 'admin'], function () {
    Route::get('admin/dashboard', [DashboardController::class, 'dashboard']);
    // Admin
    Route::get('admin/admin/list', [AdminController::class, 'list']);
    Route::get('admin/admin/add', [AdminController::class, 'add']);    
    Route::post('admin/admin/add', [AdminController::class, 'insert']);
    Route::get('admin/admin/edit/{id}', [AdminController::class, 'edit']);
    Route::post('admin/admin/edit/{id}', [AdminController::class, 'update']); 
    Route::get('admin/admin/delete/{id}', [AdminController::class, 'delete']);
    // Class
    Route::get('admin/class/list', [ClassController::class, 'list']);  
    Route::get('admin/class/add', [ClassController::class, 'add']);    
    Route::post('admin/class/add', [ClassController::class, 'insert']);
    Route::get('admin/class/edit/{id}', [ClassController::class, 'edit']);
    Route::post('admin/class/edit/{id}', [ClassController::class, 'update']); 
    Route::get('admin/class/delete/{id}', [ClassController::class, 'delete']);  
    // Subject
    Route::get('admin/subject/list', [SubjectController::class, 'list']);  
    Route::get('admin/subject/add', [SubjectController::class, 'add']);    
    Route::post('admin/subject/add', [SubjectController::class, 'insert']);
    Route::get('admin/subject/edit/{id}', [SubjectController::class, 'edit']);
    Route::post('admin/subject/edit/{id}', [SubjectController::class, 'update']); 
    Route::get('admin/subject/delete/{id}', [SubjectController::class, 'delete']);
    // assign-subject
    Route::get('admin/assign-subject/list', [ClassSubjectController::class, 'list']);  
    Route::get('admin/assign-subject/add', [ClassSubjectController::class, 'add']);    
    Route::post('admin/assign-subject/add', [ClassSubjectController::class, 'insert']);
    Route::get('admin/assign-subject/edit/{id}', [ClassSubjectController::class, 'edit']);
    Route::post('admin/assign-subject/edit/{id}', [ClassSubjectController::class, 'update']);
    Route::get('admin/assign-subject/edit-single/{id}', [ClassSubjectController::class, 'edit_single']);
    Route::post('admin/assign-subject/edit-single/{id}', [ClassSubjectController::class, 'update_single']); 
    Route::get('admin/assign-subject/delete/{id}', [ClassSubjectController::class, 'delete']);  
    
    // Change Password
    Route::get('admin/change-password', [UserController::class, 'change_password']);
    Route::post('admin/change-password', [UserController::class, 'update_change_password']);
});

Route::group(['middleware' => 'teacher'], function () {
    Route::get('teacher/dashboard', [DashboardController::class, 'dashboard']);
    // Change Password
    Route::get('teacher/change-password', [UserController::class, 'change_password']);
    Route::post('teacher/change-password', [UserController::class, 'update_change_password']);
});

Route::group(['middleware' => 'student'], function () {
    Route::get('student/dashboard', [DashboardController::class, 'dashboard']);
    // Change Password
    Route::get('student/change-password', [UserController::class, 'change_password']);
    Route::post('student/change-password', [UserController::class, 'update_change_password']);
});

Route::group(['middleware' => 'parent'], function () {
    Route::get('parent/dashboard', [DashboardController::class, 'dashboard']);
    // Change Password
    Route::get('parent/change-password', [UserController::class, 'change_password']);
    Route::post('parent/change-password', [UserController::class, 'update_change_password']);
});