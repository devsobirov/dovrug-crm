<?php

namespace App\Http\Controllers\Director;

use App\Http\Controllers\Controller;
use App\Models\Depository;
use App\Models\Logs\DepositLog;
use App\Models\Material;
use App\Models\Unit;
use Doctrine\DBAL\Query\QueryBuilder;
use Illuminate\Http\Request;

class DirectorController extends Controller
{
    public function index()
    {
        return view('crm.director.dashboard');
    }

    public function materials()
    {
        $id = request()->has('depository_id') ? request()->input('depository_id') : 1;
        $depositories = Depository::select(['id','name'])->get();
        $materials = \DB::table('balances')
            ->leftJoin('materials', 'materials.id', '=', 'balances.material_id')
            ->join('units', 'units.id', '=', 'materials.unit_id')
            ->select([
                'balances.*',
                'materials.id as m_id', 'materials.name as m_name', 'materials.trigger_limit as limit',
                \DB::raw('ROUND(balances.balance / materials.trigger_limit, 2) AS percente'),
                'units.id as u_id', 'units.symbol as symbol',
            ]);

            

        if (request('code_name')) {
            $codeOrName = request()->input('code_name');
            $materials = $materials
                ->where('code', $codeOrName)
                ->orWhere('materials.name','like', "%$codeOrName%");
        } else if (request('status')) {
            $status = request()->input('status');
            if ($status == 'triggered') {
                $materials = $materials->where('triggered', 1)->where('on_stock', 1);
            }
            if ($status == 'none_stock'){
                $materials = $materials->where('on_stock', 0);
            }
            if ($status == 'sufficiently') {
                $materials = $materials->where('triggered', 0)->where('on_stock', 1);
            }
        }

        $materials = $materials->where('depository_id', $id)
            ->orderBy('percente')
            ->paginate()->withQueryString();
        return view('crm.director.materials', compact('materials', 'depositories'));   
    }

    public function transfers()
    {
        $transfers = DepositLog::orderByDesc('id')->paginate(10);
        return view('crm.director.transfers', compact('transfers'));
    }

    public function transfer($material_id)
    {
        $transfer = DepositLog::where('material_id', $material_id)
            ->orderByDesc('id')
            ->paginate(10);

        return $transfer;
    }

    protected function getBaseQueryForBalance($id)
    {
        return \DB::table('balances')
        ->where('depository_id', $id)
        ->join('materials', 'materials.id', '=', 'balances.material_id')
        ->join('units', 'units.id', '=', 'materials.unit_id')
        ->select([
            'balances.*',
            'materials.id as m_id', 'materials.name as m_name', 'materials.trigger_limit as limit',
            \DB::raw('ROUND(balances.balance / materials.trigger_limit, 2) AS foiz'),
            'units.id as u_id', 'units.symbol as symbol',
        ]);
    }

}
