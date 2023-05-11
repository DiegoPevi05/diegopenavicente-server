<?php

use Illuminate\Support\Facades\Route;

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


Route::post('/loginSend', [App\Http\Controllers\UserController::class, 'login'])->name('home.loginSend');
Route::post('/registerSend', [App\Http\Controllers\UserController::class, 'register'])->name('home.registerSend');
Route::post('/logout', [App\Http\Controllers\UserController::class, 'logout'])->name('home.logout');

Route::get('/login', [App\Http\Controllers\UserController::class, 'showLoginForm'])->name('login');
Route::get('/register', [App\Http\Controllers\UserController::class, 'showRegistrationForm'])->name('register');


Route::middleware(['auth'])->group(function () {

    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/webcontent', [App\Http\Controllers\WebContentController::class, 'index'])->name('webcontent');
    Route::put('webcontent/{id}/update', [App\Http\Controllers\WebContentController::class, 'update'])->name('contentweb.updatecontent');

    Route::get('/experiences', [App\Http\Controllers\ExperienceController::class, 'index'])->name('experiences');
    Route::put('experiences/{id}/update', [App\Http\Controllers\ExperienceController::class, 'update'])->name('experiences.updateExperience');
    Route::post('experiences/create', [App\Http\Controllers\ExperienceController::class, 'store'])->name('experiences.storeExperience');
    Route::delete('experiences/{id}/delete', [App\Http\Controllers\ExperienceController::class, 'destroy'])->name('experiences.deleteExperience');

    Route::get('/projects', [App\Http\Controllers\ProjectController::class, 'index'])->name('projects');
    Route::put('projects/{id}/update', [App\Http\Controllers\ProjectController::class, 'update'])->name('projects.updateProject');
    Route::post('projects/create', [App\Http\Controllers\ProjectController::class, 'store'])->name('projects.storeProject');
    Route::delete('projects/{id}/delete', [App\Http\Controllers\ProjectController::class, 'destroy'])->name('projects.deleteProject');

    Route::get('/skills', [App\Http\Controllers\SkillController::class, 'index'])->name('skills');
    Route::put('skills/{id}/update', [App\Http\Controllers\SkillController::class, 'update'])->name('skills.updateSkill');
    Route::post('skills/create', [App\Http\Controllers\SkillController::class, 'store'])->name('skills.storeSkill');
    Route::delete('skills/{id}/delete', [App\Http\Controllers\SkillController::class, 'destroy'])->name('skills.deleteSkill');

    Route::get('/books', [App\Http\Controllers\BookController::class, 'index'])->name('books');
    Route::put('books/{id}/update', [App\Http\Controllers\BookController::class, 'update'])->name('books.updateBook');
    Route::post('books/create', [App\Http\Controllers\BookController::class, 'store'])->name('books.storeBook');
    Route::delete('books/{id}/delete', [App\Http\Controllers\BookController::class, 'destroy'])->name('books.deleteBook');

});

