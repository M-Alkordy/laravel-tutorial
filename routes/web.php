<?php

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

Route::get('/', [TaskController::class, 'index']);


Route::get('posts', [PostController::class, 'index'])->name('posts.index');
Route::get('posts/create', [PostController::class, 'create'])->name('posts.create');
Route::post('posts', [PostController::class, 'store'])->name('posts.store');
Route::get('posts/{post}', [PostController::class, 'show'])->name('posts.show');
Route::get('posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
Route::put('posts/{post}', [PostController::class, 'update'])->name('posts.update');
Route::delete('posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');



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
