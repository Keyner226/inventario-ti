<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Crea la tabla "categories" (categorías de productos).
     */
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();                                   // Identificador único (clave primaria)
            $table->string('name', 100)->unique();          // Nombre de la categoría, máx. 100 y sin repetirse
            $table->text('description')->nullable();        // Descripción opcional
            $table->timestamps();                           // created_at y updated_at
        });
    }

    /**
     * Elimina la tabla si se revierte la migración.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};