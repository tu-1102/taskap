<?php

use App\Http\Controllers\ProfileController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('tasks/index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::post('/task/create', [TaskController::class, 'taskCreate'])->middleware('auth')->name('task.create');
Route::post('/task/get', [TaskController::class, 'taskGet'])->middleware('auth')->name('task.get');
Route::put('/task/update', [TaskController::class, 'taskUpdate'])->middleware('auth')->name('task.update');

Route::delete('/task/delte',[TaskController::class,'taskDelete'])->middleware('auth')->name('task_delete');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
