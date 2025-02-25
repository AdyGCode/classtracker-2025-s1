<?php

use App\Http\Controllers\ClusterController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RolesAndPermissionsController;
use App\Http\Controllers\SessionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/cluster', [\App\Http\Controllers\ClusterController::class, 'index'])
    ->name('cluster');
Route::get('create', [\App\Http\Controllers\ClusterController::class, 'create'])
    ->name('create');
Route::get('clusters/{id}', [\App\Http\Controllers\ClusterController::class, 'show'])
    ->name('show');
Route::get('edit', [\App\Http\Controllers\ClusterController::class, 'edit'])
    ->name('edit');
Route::get('update', [\App\Http\Controllers\ClusterController::class, 'update'])
    ->name('update');
Route::get('destroy', [\App\Http\Controllers\ClusterController::class, 'destroy'])
    ->name('destroy');

//Route::resource('clusters', ClusterController::class)
//    ->only(['index', 'show', 'create', 'store', 'edit', 'update', 'destroy', 'search']);

Route::resource('clusters', ClusterController::class)
    ->only(['index', 'show', 'create', 'store', 'edit', 'update', 'destroy',]);



Route::get('/unit', [\App\Http\Controllers\UnitController::class, 'index'])
    ->name('unit');
Route::get('create', [\App\Http\Controllers\UnitController::class, 'create'])
    ->name('create');
Route::get('show', [\App\Http\Controllers\UnitController::class, 'show'])
    ->name('show');
Route::get('edit', [\App\Http\Controllers\UnitController::class, 'edit'])
    ->name('edit');
Route::get('update', [\App\Http\Controllers\UnitController::class, 'update'])
    ->name('update');
Route::get('destroy', [\App\Http\Controllers\UnitController::class, 'destroy'])
    ->name('destroy');

//Route::resource('units', UnitController::class)
//    ->only(['index', 'show', 'create', 'store', 'edit', 'update', 'destroy', 'search']);

Route::resource('units', UnitController::class)
    ->only(['index', 'show', 'create', 'store', 'edit', 'update', 'destroy',]);



Route::get('/course', [\App\Http\Controllers\CourseController::class, 'index'])
    ->name('course');
Route::get('create', [\App\Http\Controllers\CourseController::class, 'create'])
    ->name('create');
Route::get('show', [\App\Http\Controllers\CourseController::class, 'show'])
    ->name('show');
Route::get('edit', [\App\Http\Controllers\CourseController::class, 'edit'])
    ->name('edit');
Route::get('update', [\App\Http\Controllers\CourseController::class, 'update'])
    ->name('update');
Route::get('destroy', [\App\Http\Controllers\CourseController::class, 'destroy'])
    ->name('destroy');


Route::resource('courses', CourseController::class)
    ->only(['index', 'show', 'create', 'store', 'edit', 'update', 'destroy',]);





Route::get('/package', [\App\Http\Controllers\PackageController::class, 'index'])
    ->name('package');
Route::get('create', [\App\Http\Controllers\PackageController::class, 'create'])
    ->name('create');
Route::get('show', [\App\Http\Controllers\PackageController::class, 'show'])
    ->name('show');
Route::get('edit', [\App\Http\Controllers\PackageController::class, 'edit'])
    ->name('edit');
Route::get('update', [\App\Http\Controllers\PackageController::class, 'update'])
    ->name('update');
Route::get('destroy', [\App\Http\Controllers\PackageController::class, 'destroy'])
    ->name('destroy');


Route::resource('packages', PackageController::class)
    ->only(['index', 'show', 'create', 'store', 'edit', 'update', 'destroy',]);


Route::get('/roles-permissions', [RolesAndPermissionsController::class, 'index'])->name('roles-permissions.index');
Route::post('/roles-permissions/store', [RolesAndPermissionsController::class, 'assignRole'])->name('roles-permissions.assignRole');
Route::delete('/roles-permissions/destroy', [RolesAndPermissionsController::class, 'removeRole'])->name('roles-permissions.removeRole');

Route::resource('users', UserController::class);
Route::resource('sessions', SessionController::class);

require __DIR__.'/auth.php';
