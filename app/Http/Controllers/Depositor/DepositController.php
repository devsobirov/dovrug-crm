<?php

namespace App\Http\Controllers\Depositor;

use App\Http\Controllers\Controller;
use App\Models\Balance;
use App\Models\Logs\DepositLog;
use Illuminate\Http\Request;
use App\Models\Material;

class DepositController extends Controller
{
    public function income(Request $request)
    {
        $material_id = $request->input('material_id');
        $depositoryId = auth()->user()->depository->id;
        $amount = $request->input('addedAmount');

        $currentBalance = Balance::firstOrCreate([
            'depository_id' => $depositoryId,
            'material_id' => $material_id
        ]);
        $material = $currentBalance->material;
        $newBalance = $currentBalance->balance + $amount;

        $result = $currentBalance->update([
            'balance' => $newBalance,
            'triggered' => $newBalance <= $material->trigger_limit,
            'on_stock' =>  $newBalance > 0
        ]);

        
        //dd($currentBalance);
        if ($result) {
            DepositLog::makeIncomeLog($currentBalance->id,$material_id, $amount);
            $message = ['success' => $material->name . 'ga '. $amount ." ". $material->unit->symbol. " miqdorida muvaffaqiyatli kirim qilindi"];
            $method = 'with';
        } else {
            $message = ['error' => $material->name . 'ga '. $amount ." ". $material->unit->symbol. " miqdorida kirim qilishda xatolik ri'y berdi, qayta urinib ko'ring"];
            $method = 'withErrors';
        }
        
        return redirect()->back()->$method($message);
    }
}
