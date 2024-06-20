<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\TaskController;
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

// Route::get('/', [TaskController::class, 'index']);

Route::group(['middleware' => ['auth']], function () {

    Route::group(['middleware' => ['role:admin']], function () {
        Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
        Route::post('/admin/roles', [AdminController::class, 'createRole'])->name('admin.createRole');
        Route::post('/admin/users/{user}/assign-role', [AdminController::class, 'assignRole'])->name('admin.assignRole');
        Route::delete('/admin/roles/{role}', [AdminController::class, 'deleteRole'])->name('admin.deleteRole');
        Route::post('/admin/roles/{role}/assign-permission', [AdminController::class, 'assignPermissionToRole'])->name('admin.assignPermissionToRole');
        Route::post('/admin/roles/{role}/remove-permission', [AdminController::class, 'removePermissionFromRole'])->name('admin.removePermissionFromRole');
        Route::delete('/admin/users/{user}', [AdminController::class, 'deleteUser'])->name('admin.deleteUser');
        Route::resource('posts', PostController::class)->except(['index', 'show']);
    });
    Route::group(['middleware' => ['permission:manage posts']], function () {
        Route::resource('posts', PostController::class)->except(['index', 'show']);
    });


    Route::get('/', [PostController::class, 'index'])->name('posts.index');
    Route::get('posts/{post}', [PostController::class, 'show'])->name('posts.show');

    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
});



Route::middleware(['guest'])->group(function () {

    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
    Route::get('register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [AuthController::class, 'register']);
});



// Route::resource('posts', PostController::class);




// Route::prefix('posts')->group(function () {
//     Route::get('/', [PostController::class, 'index'])->name('posts.index');
//     Route::get('/create', [PostController::class, 'create'])->name('posts.create');
//     Route::post('/', [PostController::class, 'store'])->name('posts.store');
//     Route::get('/{post}', [PostController::class, 'show'])->name('posts.show');
//     Route::get('/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
//     Route::put('/{post}', [PostController::class, 'update'])->name('posts.update');
//     Route::delete('/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
// });
