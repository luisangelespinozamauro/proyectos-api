<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\UsersController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::post('/login/{collaborator_number}', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::resource('/projects', ProjectsController::class);
    Route::resource('/users', UsersController::class);

    Route::get('/productFamilies', [ProjectsController::class, 'productFamilies']);
    Route::get('/roles', [UsersController::class, 'roles']);
    Route::get('/manual/{tipo}', [AuthController::class, 'verManual']);

    Route::get('/user', [AuthController::class, 'user']);
});
