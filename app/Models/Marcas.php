<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marcas extends Model
{
    public $timestamps = false;
    use HasFactory;

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function celulares()
    {
        return $this->hasMany(Celulares::class);
    }
}
