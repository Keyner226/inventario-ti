<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // Campos que se pueden guardar de forma masiva con create() y update()
    protected $fillable = ['name', 'description'];

    // Relación: una categoría tiene muchos productos (1 a N)
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}