<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\UploadedFilesController;

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
    return Inertia::render('Home');
})->name('home');

Route::controller(UploadedFilesController::class)->prefix('uploaded-files')->group(function(){
    Route::get('/{id}/download', 'download')->name('uploaded-files.download');
    Route::get('/{id}/preview', 'preview')->name('uploaded-files.preview');
});
Route::resource('uploaded-files', UploadedFilesController::class)->parameters(['uploaded_files' => 'id']);
