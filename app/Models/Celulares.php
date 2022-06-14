<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;

class Celulares extends Model
{
    public $timestamps = false;
    use HasFactory;

    public function marca()
    {
        return $this->belongsTo(Marcas::class);
    }

    public function scopeFilter($query, array $params)
    {
        switch (($params['opcion'] ?? null)) {
            case 'modelo':
                $query->when($params['search'] ?? null, function ($query) use ($params) {
                    $query->where('modelo', 'LIKE', '%' . $params['search'] . '%');
                });
                break;

            case 'marca':
                // dd($query->get());
                $query->when(Request::get('opcion') ?? null, function ($query, $marca) {
                    $query->whereExists(function ($query) use ($marca) {
                        $query->from('marcas')
                            ->whereColumn('marcas.id', 'celulares.marca_id')
                            ->where('marcas.name', 'LIKE', '%' . Request::get('search') . '%');
                    });
                });
                break;
        }
    }
}
