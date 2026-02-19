<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\backend\admin\Api\ToolController;

Route::get('/tools', [ToolController::class, 'index']);
Route::get('/tools/{slug}', [ToolController::class, 'show']);

Route::get('/blogs', [\App\Http\Controllers\backend\admin\Api\BlogController::class, 'index']);
Route::get('/blogs/{slug}', [\App\Http\Controllers\backend\admin\Api\BlogController::class, 'show']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
