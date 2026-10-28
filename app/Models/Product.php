<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Campos que se pueden guardar de forma masiva con create() y update()
    protected $fillable = [
        'category_id',
        'supplier_id',
        'name',
        'price',
        'stock',
        'description',
    ];

    // Relación: cada producto pertenece a una categoría (lado "muchos" del 1 a N)
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relación: cada producto pertenece a un proveedor (lado "muchos" del 1 a N)
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function stockMovements()
{
    return $this->hasMany(StockMovement::class);
}
}