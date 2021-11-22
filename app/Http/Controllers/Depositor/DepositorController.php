<?php

namespace App\Http\Controllers\Depositor;

use App\Http\Controllers\Controller;
use App\Models\Depository;
use App\Models\Logs\DepositLog;
use Illuminate\Http\Request;
use App\Models\Material;
use App\Models\Unit;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class DepositorController extends Controller
{
    public function index()
    {
        $depository = $this->setDepository();
        $materials = (new LengthAwarePaginator(new Collection([]),0,1));
        $depositLogs = DepositLog::where('depository_id', $depository->id)
            ->latest()->take(5)->get();

        $units = DB::table('units')->select('id', 'symbol', 'name')->get();
        return view('crm.depositor.dashboard', compact('materials','depositLogs', 'units', 'depository'));
    }

    public function history()
    {
        $depository = $this->setDepository();
        $depositLogs = DepositLog::where('depository_id', $depository->id)
            ->latest()->paginate(3);
        return view('crm.depositor.history', compact('depositLogs','depository'));
    }

    public function filter()
    {
        $materials = Material::select(['id','name','price','code','unit_id','trigger_limit'])
            ->filter(request()->only(['code','search', 'unit_id']))
            ->paginate()
            ->withQueryString();

        return response()->json($materials, 200);
    }

    protected function setDepository() 
    {
        return auth()->user()->depository()->exists() ? 
        auth()->user()->depository :
        Depository::find(1);
    }
}
