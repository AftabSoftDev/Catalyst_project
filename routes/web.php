<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CommonController;

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

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [CommonController::class, 'getUserData'])->name('dashboard');
    Route::view('/file-upload', 'file-upload')->name('file');
    Route::view('/filter-from', 'filter-from')->name('filter-form');
    Route::get('/search-filter', [CommonController::class, 'filter'])->name('filter');
    Route::post('file-uploading', [CommonController::class, 'fileUpload'])->name('file-uploads');
    Route::get('/file-records', [CommonController::class, 'fileRecords'])->name('file-records-show');
});

Route::middleware('auth')->group(function () {
  
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';