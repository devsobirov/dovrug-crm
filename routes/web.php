<?php

use App\Http\Controllers\Administrator\AdministratorController;
use App\Http\Controllers\Director\DirectorController;
use App\Http\Controllers\Depositor\DepositorController;
use Illuminate\Support\Facades\Route;
use App\Roles\UserRoles;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Depositor\DepositController;
use App\Models\Material;

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

    $directorGroup = ['middleware' => ['user-role:'.UserRoles::ROLE_DIRECTOR], 'prefix' => 'director'];
    $adminGroup = ['middleware' => ['user-role:'.UserRoles::ROLE_ADMINISTRATOR],'prefix' => 'administrator'];
    $depositorGroup = ['middleware' => ['user-role:'.UserRoles::ROLE_DEPOSITOR],'prefix' => 'depositor'];

    Route::group($directorGroup, function () {
        Route::get('/', [ DirectorController::class, 'index'])->name('director');
        Route::get('/transfers', [ DirectorController::class, 'transfers'])->name('director.transfers');
        Route::get('/materials', [ DirectorController::class, 'materials'])->name('director.materials');
        Route::resource('/users', \App\Http\Controllers\Director\UserController::class)
            ->names('director.users');
    });

    Route::group($adminGroup, function () {
        Route::get('/', [AdministratorController::class, 'index'])->name('administrator');
        Route::resource('units', \App\Http\Controllers\Administrator\UnitController::class)
            ->only(['index', 'store', 'update', 'destroy'])
            ->names('units');
        Route::resource('materials', \App\Http\Controllers\Administrator\MaterialController::class)
            ->only(['index', 'store', 'update', 'destroy'])
            ->names('materials');
        Route::get('materials/filter', [\App\Http\Controllers\Administrator\MaterialController::class, 'filter'])
            ->name('materials.filter');
    });

    Route::group($depositorGroup, function () {
        Route::get('/', [DepositorController::class, 'index'])->name('depositor');
        Route::get('/history', [DepositorController::class, 'history'])->name('depositor.history');
        Route::get('/filter', [DepositorController::class, 'filter'])->name('depositor.filter');
        Route::post('/income', [DepositController::class, 'income'])->name('depositor.income');
    });
});


/**
 * Frontend Routes List
 */

Route::middleware('main-domain')->group(function () {

    Route::get('/', function () {return view('welcome');});
    Route::get('/dashboard', function () {return redirect()->route('dashboard');});

});

require __DIR__ . '/auth.php';

Route::get('/test', function () {
    $materials = \DB::table('materials')
        ->join('units', 'units.id', '=', 'materials.unit_id')
        ->join('balances', 'balances.material_id', '=', 'materials.id')
        ->join('depositories', 'depositories.id','=','balances.depository_id')
        ->select([
            'materials.id as id', 'materials.name as name', 'trigger_limit', 'price',
            'units.id as u_id', 'units.symbol as m_symbol',
            'balances.id as b_id','balances.balance as balance', 'balances.depository_id as depository',
            'depositories.id as d_id','depositories.name as sklad_name'
        ])
        ->orderByDesc('id')
        //->groupBy('id')
        ->paginate(10);

        $m = Material::select(['*'])
            ->with('balances:id,balance,material_id,depository_id')
            ->withSum('balances as total_balance', 'balance')
            ->take(10)
            ->get();

        $b = App\Models\Balance::where('depository_id', '<>', null)
            ->with('material')
            ->get();

        $s = \DB::table('balances')
            ->where('depository_id', '<>', null)
            ->join('materials', 'materials.id', '=', 'balances.material_id')
            ->select([
                'balances.*',
                'materials.id as m_id', 'materials.name as m_name', 'materials.trigger_limit as limit',
                \DB::raw('ROUND(balances.balance / materials.trigger_limit, 2) AS foiz')
            ])
            ->orderBy('foiz')
            ->get();

        dd($s);
//        return response()->json($materials);
});



