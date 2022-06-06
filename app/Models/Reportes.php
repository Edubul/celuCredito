<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reportes extends Model
{
    public $timestamps = false;
    use HasFactory;

    protected $fillable = [
        'user_id',
        'motivo',
        'cantidad',
        'fecha',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
