<?php

namespace App\Models\Logs;

use App\Models\Balance;
use App\Models\Depository;
use App\Models\Material;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepositLog extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $with = ['material','depository:id,name','user:id,name'];

    static public function makeIncomeLog($balance_id,$material_id, $amount)
    {
        $balance = Balance::where('id',$balance_id)->first();
        $material = Material::find($material_id);

        //TODO optimize calling relations
        //dd($balance, $balance->material);
        self::create([
            'material_id' => $material->id,
            'depository_id' => auth()->user()->depository_id,
            'user_id' => auth()->id(),
            'description' => null,
            'price' => $material->price,
            'amount' => $amount,
            'type' => 1
        ]);

    }

    public function getTypeAlias(int $type = 1)
    {
        if ($type === 1) {
            return 'кирим';
        }

        return 'чиқим';
    }

    public function total_price()
    {
        return $this->amount * $this->price;
    }

    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    public function depository()
    {
        return $this->belongsTo(Depository::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
