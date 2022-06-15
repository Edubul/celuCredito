<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function organizations()
    {
        return $this->hasMany(Organization::class);
    }

    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    public function celulares()
    {
        return $this->hasMany(Celulares::class);
    }

    public function gastos()
    {
        return $this->hasMany(Gastos::class);
    }

    public function ventas()
    {
        return $this->hasMany(Ventas::class);
    }

    public function marcas()
    {
        return $this->hasMany(Marcas::class);
    }
}
