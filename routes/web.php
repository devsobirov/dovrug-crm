<?php

use App\Http\Controllers\Administrator\AdministratorController;
use App\Http\Controllers\Director\DirectorController;
use App\Http\Controllers\Depositor\DepositorController;
use Illuminate\Support\Facades\Route;
use App\Roles\UserRoles;
use App\Http\Controllers\DashboardController;

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

$subdomain = config('app.domain_prefix');
$mainDomain = config('app.app_domain');

/**
 * Backend Routes
 */
Route::domain("$subdomain.$mainDomain")->group(function () {
    Route::group(['middleware' => ['user-role']], function () {
        Route::get('/dashboard', [DashboardController::class, 'handle'])->name('dashboard');
    });

    $directorGroup = [['middleware' => ['user-role:'.UserRoles::ROLE_DIRECTOR]], 'prefix' => 'director'];
    $adminGroup = [['middleware' => ['user-role:'.UserRoles::ROLE_ADMINISTRATOR]],'prefix' => 'administrator'];
    $depositorGroup = [['middleware' => ['user-role:'.UserRoles::ROLE_ADMINISTRATOR]],'prefix' => 'administrator'];

    Route::group($directorGroup, function () {
        Route::get('/', [ DirectorController::class, 'index'])->name('director');
    });

    Route::group($adminGroup, function () {
        Route::get('/', [AdministratorController::class, 'index'])->name('administrator');
    });

    Route::group($depositorGroup, function () {
        Route::get('/', [DepositorController::class, 'index'])->name('depositor');
    });
});


/**
 * Frontend Routes List
 */

Route::middleware('main-domain')->group(function () {

    Route::get('/', function () {return view('welcome');});
    Route::get('/dashboard', function () {return redirect()->route('dashboard');});

    require __DIR__.'/auth.php';
});


Route::get('/test', function () {
    return redirect()->route('dashboard');
});



