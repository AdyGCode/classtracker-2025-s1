<?php

use App\Http\Controllers\Api\RolesAndPermissionsApiController;
use App\Http\Controllers\Api\UserApiController;
use Illuminate\Support\Facades\Route;

Route::apiResource('users', UserApiController::class);

Route::prefix('roles-permissions')->group(function () {
    Route::get('/', [RolesAndPermissionsApiController::class, 'index']);
    Route::post('/assign', [RolesAndPermissionsApiController::class, 'assignRole']);
    Route::delete('/remove', [RolesAndPermissionsApiController::class, 'removeRole']);
    Route::get('/user/{user}', [RolesAndPermissionsApiController::class, 'getUserRoles']);
});

