<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Crea la tabla "suppliers" (proveedores que suministran los productos).
     */
    public function up(): void
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();                                   // Identificador único (clave primaria)
            $table->string('name', 150);                    // Nombre del proveedor (obligatorio)
            $table->string('email')->nullable();            // Correo de contacto (opcional)
            $table->string('phone', 30)->nullable();        // Teléfono (opcional)
            $table->string('address')->nullable();          // Dirección (opcional)
            $table->timestamps();                           // created_at y updated_at
        });
    }

    /**
     * Elimina la tabla si se revierte la migración.
     */
    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};