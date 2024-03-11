<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\diegopenavicente\BookController;
use App\Http\Controllers\diegopenavicente\ExperienceController;
use App\Http\Controllers\diegopenavicente\SkillController;
use App\Http\Controllers\diegopenavicente\ProjectController;
use App\Http\Controllers\diegopenavicente\WebContentController;
use App\Models\User;
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

Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::get('terms-of-service', [AuthController::class, 'showTermsOfService'])->name('terms-of-service');
Route::get('recover-password', [AuthController::class, 'showRecoverPasswordForm'])->name('recover-password');
Route::post('recover-password', [AuthController::class, 'recoverPassword']);


Route::middleware(['auth'])->group(function () {

    Route::post('logout',[AuthController::class, 'logout'])->name('logout');

    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::resource('home', HomeController::class);
    Route::resource('user-profile', UserProfileControllers::class);

    Route::middleware('role:' . User::ROLE_ADMIN)->group(function () {
        Route::resource('users', UserController::class);
        Route::resource('books', BookController::class);
        Route::resource('experiences', ExperienceController::class);
        Route::resource('skills', SkillController::class);
        Route::resource('projects', ProjectController::class);
        Route::resource('webcontents', WebContentController::class);
        Route::get('/search-skills',[SkillController::class,'SearchByTitle']);
        
    });

    Route::middleware('role:' . User::ROLE_CLIENT)->group(function () {
        Route::resource('user-profile', UserProfileController::class)->only(['show', 'edit', 'update']);
    });
});

