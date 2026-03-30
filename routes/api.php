<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProjectsController;
use Illuminate\Support\Facades\Route;

Route::post('/login/{collaborator_number}', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::resource('/projects', ProjectsController::class);
    Route::get('/productFamilies', [ProjectsController::class, 'productFamilies']);

    Route::get('/user', [AuthController::class, 'user']);
});
