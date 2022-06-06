<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Celulares extends Model
{
    public $timestamps = false;
    use HasFactory;

    public function marca()
    {
        return $this->belongsTo(Marcas::class);
    }
}
