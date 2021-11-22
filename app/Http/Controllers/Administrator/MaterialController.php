<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\Material;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MaterialController extends Controller
{

    public function index()
    {
        $materials = Material::select(['id','name','price','code','unit_id','trigger_limit', 'deleted_at'])
            ->with('unit:id,symbol,name')
            ->paginate(15);
        $units = DB::table('units')->select('id', 'symbol', 'name')->get();

        if (request()->expectsJson())
        {
            return $materials;
        }
        return view('crm.administrator.test-mat', compact('materials', 'units'));
    }

    public function filter()
    {
        $materials = Material::select(['id','name','price','code','unit_id','trigger_limit','deleted_at'])
            ->filter(request()->only(['code','search', 'unit_id','trashed']))
            ->withTrashed()
            ->with('unit:id,symbol,name')
            ->paginate()
            ->withQueryString();

        return response()->json($materials, 200);
    }

    public function store(Request $request)
    {
        $data = $this->getValidData($request);

        $code = $request->input('code');
        if (!$code) {
            for ($i = 0; $i < 13; $i++) {
                $code .= rand(0,9);
            }
            $data['code'] = trim($code);
        }

        $material = Material::create($data);

        if ($material) {
            return  redirect()->back()->with(['success' => " '{$material->name}' muvaffaqiyatli yaratildi!"]);
        }
        return  redirect()->back()->withErrors(["No'malum xatolik ro'y berdi, qayta urinib ko'ring"]);
    }

    public function update(Request $request,Material $material)
    {
        $data = $this->getValidData($request);

        $updated = $material->update($data);

        if ($updated) {
            return  redirect()->back()->with(['success' => " '{$material->name}' muvaffaqiyatli tahrirlandi!"]);
        }
        return  redirect()->back()->withErrors(["No'malum xatolik ro'y berdi, qayta urinib ko'ring"]);
    }

    public function destroy(Material $material)
    {
        $result = $material->delete();
        if ($result) {
            return redirect()->back()->with(['success' => "Muvaffaqiyatli o'chirildi!"]);
        }
        return redirect()->back()->withErrors(["No'malum xatolik roy berdi"]);
    }

    protected function getValidData($request)
    {
        $nameRule = 'required|string|max:255';
        if ($request->method() !== 'PATCH') {
            $nameRule .= '|unique:materials';
        }
        return $request->validate([
            'name' => $nameRule,
            'unit_id' => 'required|string|max:255',
            'trigger_limit' => 'required|numeric',
            'description' => 'nullable|string|max:255',
            'code' => 'nullable|numeric|digits:13',
            'price' => 'required|numeric|min:1'
        ]);
    }
}
