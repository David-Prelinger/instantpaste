<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChestController;


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

Route::get('/', [ChestController::class, 'show']);
Route::post('/', [ChestController::class, 'update']);
Route::get('/files/{fileName}', [ChestController::class, 'getFile'])
    ->where(['fileName' => '.*'])->name('storage.file');
Route::get('/thumbnails/{fileName}', [ChestController::class, 'getThumbnail'])
    ->where(['fileName' => '.*']);
Route::delete('/delete', [ChestController::class, 'delete']);
