<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Crea la tabla "products" (productos del inventario).
     * Cada producto pertenece a una categoría y a un proveedor.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();                                                   // Identificador único (clave primaria)

            // Clave foránea hacia categories: no deja borrar una categoría que tenga productos
            $table->foreignId('category_id')->constrained()->restrictOnDelete();

            // Clave foránea hacia suppliers: no deja borrar un proveedor que tenga productos
            $table->foreignId('supplier_id')->constrained()->restrictOnDelete();

            $table->string('name', 150);                                    // Nombre del producto (obligatorio)
            $table->decimal('price', 10, 2);                                // Precio con 2 decimales
            $table->unsignedInteger('stock')->default(0);                   // Stock (entero positivo, 0 por defecto)
            $table->text('description')->nullable();                        // Descripción opcional
            $table->timestamps();                                           // created_at y updated_at
        });
    }

    /**
     * Elimina la tabla si se revierte la migración.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};