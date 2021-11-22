<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Unit;

class UnitController extends Controller
{
    public function index()
    {
        $units = Unit::select(['id','symbol','name'])->orderByDesc('id')->paginate(10);
        return view('crm.administrator.units', compact('units'));
    }

    public function store(Request $request)
    {
        $unit = Unit::create($this->validateUnitData($request));

        if ($unit) {
            return redirect()->back()->with(['success' => "Yangi o'lcham '{$unit->symbol}' muvaffaqiyatli yaratildi!"]);
        }
        return redirect()->back()->withErrors(['Nomalum xatolik roy berdi']);
    }

    public function update(Request $request, Unit $unit)
    {
        $result = $unit->update($this->validateUnitData($request));
        if ($result) {
            return redirect()->back()->with(['success' => "Yangi o'lcham '{$unit->symbol}' muvaffaqiyatli tahrirlandi!"]);
        }
        return redirect()->back()->withErrors(['Nomalum xatolik roy berdi']);
    }

    public function destroy(Unit $unit)
    {
        $result = $unit->delete();
        if ($result) {
            return redirect()->back()->with(['success' => "Muvaffaqiyatli o'chirildi!"]);
        }
        return redirect()->back()->withErrors(["No'malum xatolik roy berdi"]);
    }

    private function validateUnitData($request)
    {
        return $request->validate([
            'symbol' => 'required|string|max:20',
            'name' => 'nullable|string|max:255',
        ]);
    }
}
