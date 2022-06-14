<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Gastos extends Model
{
    public $timestamps = false;
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeFilter($query, array $params)
    {
        $query->when($params['search'] ?? null, function ($query, $search) {
            $query->join('users', 'users.id', '=', 'gastos.user_id')
                ->where('users.first_name', 'LIKE', "%{$search}%")
                ->orWhere('users.last_name', 'LIKE', "%{$search}%");
        });
    }
}
