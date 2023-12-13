<?php

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


Route::middleware(['auth'])->group(function () {

    Route::middleware(['can:viewAny,App\Models\Post'])->get('', [PostController::class, 'index'])->name('posts.index');

    Route::middleware(['can:view,post'])->get('posts/{post}', [PostController::class, 'show'])->name('posts.show');

    Route::middleware(['can:create,App\Models\Post'])->get('posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::middleware(['can:create,App\Models\Post'])->post('posts', [PostController::class, 'store'])->name('posts.store');

    Route::middleware(['can:update,post'])->get('posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::middleware(['can:update,post'])->put('posts/{post}', [PostController::class, 'update'])->name('posts.update');

    Route::middleware(['can:delete,post'])->delete('posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');



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
