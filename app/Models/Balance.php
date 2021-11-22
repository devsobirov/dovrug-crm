<?php

namespace App\Models;

use App\Traits\HasCompositePrimaryKeys;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Balance extends Model
{
    use HasFactory; //, HasCompositePrimaryKeys;

    protected $guarded = [];

    //protected $primaryKey = ['material_id','depository_id'];
    
    protected $with = ['material:id,name,trigger_limit,price','material.unit', 'depository'];

    /**
     * BelongsTo Relationship
     * 
     * @return Material|Eloquent
     */
    public function material()
    {
        return $this->belongsTo(Material::class, 'material_id', 'id');
    }

    /**
     * BelongsTo Relationship
     * 
     * @return Depository|Eloquent
     */
    public function depository()
    {
        return $this->belongsTo(Depository::class);
    }


    /**
     * Gets existing model or creates it by foreign keys
     * 
     * @param Depository::id|int $depositoryId 
     * @param Material::id|int $materialId
     * @return Balace|Eloquent
     */
    public function getFirstOrCreate(int $depositoryId, int $materialId)
    {
        $model = $this->where([
            ['depository_id', $depositoryId],
            ['material_id', $materialId]
        ])->first();

        if (!$model) {
            $model = $this->create([
                'depository_id' => $depositoryId,
                'material_id' => $materialId,
                'balance' => 0
            ]);
        }

        //dd($model);
        return $model;
    }

}
