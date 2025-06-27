<?php
/**
 * FILE TITLE GOES HERE
 *
 * DESCRIPTION OF THE PURPOSE AND USE OF THE CODE
 * MAY BE MORE THAN ONE LINE LONG
 * KEEP LINE LENGTH TO NO MORE THAN 96 CHARACTERS
 *
 * Filename:        api_v1.php
 * Location:        FILE_LOCATION
 * Project:         classtracker-2025-s1
 * Date Created:    14/04/2025
 *
 * Author:          Yui_Migaki
 *
 */

use App\Http\Controllers\Api\v1\AuthApiController;
use App\Http\Controllers\Api\v1\ClusterApiController;
use App\Http\Controllers\Api\v1\LessonApiController;
use App\Http\Controllers\Api\v1\PackageApiController;
use App\Http\Controllers\Api\v1\CourseApiController;
use App\Http\Controllers\Api\v1\RolesAndPermissionsApiController;
use App\Http\Controllers\Api\v1\UnitApiController;
use App\Http\Controllers\Api\v1\UserApiController;
use Illuminate\Support\Facades\Route;

//Route::post('/register', [AuthApiController::class, 'register']);
Route::post('/login', [AuthApiController::class, 'login']);
//Route::get('/profile', [AuthApiController::class, 'profile']);
//Route::post('/logout', [AuthApiController::class, 'logout']);

Route::apiResource('courses', CourseApiController::class)
    ->names([
        'index' => 'api.v1.courses.index',
        'show' => 'api.v1.courses.show',
        'store' => 'api.v1.courses.store',
        'update' => 'api.v1.courses.update',
        'destroy' => 'api.v1.courses.destroy',
    ]);

Route::apiResource('clusters', ClusterApiController::class)
    ->names([
        'index' => 'api.v1.clusters.index',
        'show' => 'api.v1.clusters.show',
        'store' => 'api.v1.clusters.store',
        'update' => 'api.v1.clusters.update',
        'destroy' => 'api.v1.clusters.destroy',
    ]);

Route::apiResource('units', UnitApiController::class)
    ->names([
        'index' => 'api.v1.units.index',
        'show' => 'api.v1.units.show',
        'store' => 'api.v1.units.store',
        'update' => 'api.v1.units.update',
    ]);

Route::apiResource('packages', PackageApiController::class)
    ->names([
        'index' => 'api.v1.packages.index',
        'show' => 'api.v1.packages.show',
        'store' => 'api.v1.packages.store',
        'update' => 'api.v1.packages.update',
        'destroy' => 'api.v1.packages.destroy',
    ]);

Route::apiResource('lessons', LessonApiController::class)
    ->names([
        'index' => 'api.v1.lessons.index',
        'show' => 'api.v1.lessons.show',
        'store' => 'api.v1.lessons.store',
        'update' => 'api.v1.lessons.update',
        'destroy' => 'api.v1.lessons.destroy',
    ]);

Route::prefix('roles-permissions')->group(function () {
    Route::get('/', [RolesAndPermissionsApiController::class, 'index']);
    Route::post('/assign', [RolesAndPermissionsApiController::class, 'assignRole']);
    Route::delete('/remove', [RolesAndPermissionsApiController::class, 'removeRole']);
    Route::get('/user/{user}', [RolesAndPermissionsApiController::class, 'getUserRoles']);
});

Route::name('api.v1.')->group(function () {
    Route::apiResource('users', UserApiController::class)
        ->names([
            'index' => 'users.index',
            'store' => 'users.store',
            'show' => 'users.show',
            'update' => 'users.update',
            'destroy' => 'users.destroy',
        ]);
});
