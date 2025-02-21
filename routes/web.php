<?php

use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\CustomerController;
use App\Http\Mail\PasswordResetOtp;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\InfoUserController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ResetController;
use App\Http\Controllers\SessionsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', [HomeController::class, 'home']);
    Route::get('/dashboard', fn() => view('dashboard'))->name('dashboard');
    Route::get('/billing', fn() => view('billing'))->name('billing');
    Route::get('/profile', fn() => view('profile'))->name('profile');
    Route::get('/logout', [SessionsController::class, 'destroy']);
    Route::get('/user-profile', [InfoUserController::class, 'create']);
    Route::post('/user-profile', [InfoUserController::class, 'store']);
});

Route::group(['middleware' => 'guest'], function () {
    Route::get('/register', [RegisterController::class, 'create']);
    Route::post('/register', [RegisterController::class, 'store']);
    Route::get('/login', [SessionsController::class, 'create'])->name('login');
    Route::post('/session', [SessionsController::class, 'store']);
    // Route::get('/login/forgot-password', [ResetController::class, 'create']);
    // Route::post('/forgot-password', [ResetController::class, 'sendEmail']);
//     Route::get('/reset-password/{token}', [ResetController::class, 'resetPass'])->name('password.reset');
//     Route::post('/reset-password', [ChangePasswordController::class, 'changePassword'])->name('password.update');
});




Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
Route::post('/send-otp', [RegisterController::class, 'sendOtp']);

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);





Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');



Route::get('/forgot-passwords', [CustomerController::class, 'showForgotPasswordForm'])->name('forgot.password.form');
Route::post('/forgot-passwords', [CustomerController::class, 'sendOtp'])->name('otp.send');
Route::get('/otp-verification', [CustomerController::class, 'showOtpVerificationForm'])->name('otp.verification.form');
Route::post('/otp-verification', [CustomerController::class, 'verifyOtps'])->name('otp.verifys');
Route::get('/reset-passwords', [CustomerController::class, 'showResetPasswordForm'])->name('reset.password.form');
Route::post('/reset-passwords', [CustomerController::class, 'resetPassword'])->name('password.reset');

