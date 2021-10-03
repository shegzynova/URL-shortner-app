<?php

use App\Http\Controllers\ShortUrlController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/encode', [ShortUrlController::class, 'encode']);

Route::post('/decode', [ShortUrlController::class, 'decode']);

Route::get('/statistic/{url_path}', [ShortUrlController::class, 'stat']);
