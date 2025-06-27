<?php

use App\Http\Controllers\ClusterController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StaticPageController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RolesAndPermissionsController;
use App\Models\Cluster;
use Illuminate\Support\Facades\Route;

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/', [StaticPageController::class, 'home'])->name('static.home');

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
Route::resource('clusters', ClusterController::class)
    ->only(['index', 'show', 'create', 'store', 'edit', 'update', 'destroy',]);
Route::post('/clusters/{cluster_id}/unit/{unit_id}', [ClusterController::class, 'store']);
Route::get('/cluster/{cluster_id}/units', [ClusterController::class, 'getUnitsByCluster']);
Route::get('/unit/{unit_id}/clusters', [ClusterController::class, 'getClustersByUnit']);


Route::get('/unit', [\App\Http\Controllers\UnitController::class, 'index'])
    ->name('unit');
Route::resource('units', UnitController::class)
    ->only(['index', 'show', 'create', 'store', 'edit', 'update', 'destroy',]);


Route::get('/course', [\App\Http\Controllers\CourseController::class, 'index'])
    ->name('course');
Route::resource('courses', CourseController::class)
    ->only(['index', 'show', 'create', 'store', 'edit', 'update', 'destroy', 'search']);
Route::match(['get', 'post'], '/course/search', [\App\Http\Controllers\CourseController::class, 'search'])
    ->name('courses.search');//Make this to handle both GET and POST methods


Route::get('/package', [\App\Http\Controllers\PackageController::class, 'index'])
    ->name('package');
Route::resource('packages', PackageController::class)
    ->only(['index', 'show', 'create', 'store', 'edit', 'update', 'destroy', 'search']);
Route::match(['get', 'post'], '/package/search', [\App\Http\Controllers\PackageController::class, 'search'])
    ->name('packages.search');//Make this to handle both GET and POST methods


Route::get('/roles-permissions', [RolesAndPermissionsController::class, 'index'])->name('roles-permissions.index');
Route::post('/roles-permissions/store', [RolesAndPermissionsController::class, 'assignRole'])->name('roles-permissions.assignRole');
Route::delete('/roles-permissions/destroy', [RolesAndPermissionsController::class, 'removeRole'])->name('roles-permissions.removeRole');

Route::resource('users', UserController::class);
Route::resource('lessons', LessonController::class);

// Route::redirect('/api/v1/doc', '/docs/api');


require __DIR__.'/auth.php';
