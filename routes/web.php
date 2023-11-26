<?php

use App\Admin\Controllers\PinjamRuangController;
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

Route::get('/', [PinjamRuangController::class, 'createForUser'])->name('index');
Route::post('/pinjam-ruang', [PinjamRuangController::class, 'userPinjamRuang'])->name('userPinjamRuang');
