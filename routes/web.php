<?php

use App\Http\Controllers\ExcelImportController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Auth::routes();

Route::get('/home', [ExcelImportController::class, 'index'])->name('home');
Route::get('/uploaded-files/{id}', [ExcelImportController::class, 'viewUploadedFile'])->name('uploaded-file.view');
Route::get('/upload-form', [ExcelImportController::class, 'uploadForm'])->name('upload.form');
Route::post('/import', [ExcelImportController::class, 'import'])->name('import.excel');

