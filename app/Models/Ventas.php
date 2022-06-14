<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ventas extends Model
{
    public $timestamps = false;
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function scopeFilter($query, array $params)
    {
        switch (($params['opcion'] ?? null)) {
            case 'imei':
                $query->when($params['search'] ?? null, function ($query) use ($params) {
                    $query->where('imei', 'like', '%' . $params['search'] . '%');
                });
                break;

            case 'cc_cliente':
                $query->when($params['search'] ?? null, function ($query) use ($params) {
                    $query->where('cc_cliente', 'like', '%' . $params['search'] . '%');
                });
                break;

            case 'num_celular':
                $query->when($params['search'] ?? null, function ($query) use ($params) {
                    $query->where('numero_celular_cliente', 'like', '%' . $params['search'] . '%');
                });
                break;

            default:
                $query->when($params['search'] ?? null, function ($query, $search) {
                    $query->where(function ($query) use ($search) {
                        $query->where('nombre_cliente', 'LIKE', "%{$search}%");
                    });
                });
                break;
        }
    }
}
