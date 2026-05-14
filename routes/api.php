<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\BrandsController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\PermissionsController;
use Illuminate\Support\Facades\Route;

Route::post('/login/{collaborator_number}', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::resource('/projects', ProjectsController::class);
    Route::resource('/users', UsersController::class);
    Route::resource('/brands', BrandsController::class);
    Route::resource('/roles', RolesController::class);
    Route::resource('/permisos', PermissionsController::class);

    Route::get('/productFamilies', [ProjectsController::class, 'productFamilies']);
    Route::get('/user', [AuthController::class, 'user']);
});
