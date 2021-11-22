<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Material extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $casts = [];

    protected $with = ['unit:id,symbol,name'];

    public function unit()
    {
        return $this->belongsTo(Unit::class)->withDefault();
    }
    
    public function balances()
    {
        return $this->hasMany(Balance::class, 'material_id', 'id');
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['code'] ?? false, fn ($query, $code) =>
            $query->where('code', $code)
        );

        if (empty($filters['code'])) {
            
            $query->when($filters['search'] ?? false, fn ($query, $search) =>
                $query->where('name', 'like', "%$search%")
            );

            $query->when($filters['unit_id'] ?? false, fn ($query, $unit) => 
                $query->where('unit_id', $unit)
            );
        }

        // $query->when( $filters['trashed'] == false, fn ($query) => 
        //     $query->whereNotNull('deleted_at')
        // );

        if (isset($filters['trashed']) && $filters['trashed'] == 'trashed') {
            $query->whereNotNull('deleted_at');
        }
    }
}
