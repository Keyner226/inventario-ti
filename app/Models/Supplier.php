<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    // Campos que se pueden guardar de forma masiva con create() y update()
    protected $fillable = ['name', 'email', 'phone', 'address'];

    // Relación: un proveedor suministra muchos productos (1 a N)
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}