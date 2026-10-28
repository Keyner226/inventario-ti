<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // SKU único (nullable solo para que los productos que ya existen no den error)
            $table->string('sku', 50)->nullable()->unique()->after('supplier_id');
            // Stock mínimo para marcar "Stock bajo"
            $table->unsignedInteger('min_stock')->default(5)->after('stock');
        });

        // Asigna un SKU a los productos que ya existen: SKU-0001, SKU-0002...
        DB::table('products')->whereNull('sku')->orderBy('id')->get()->each(function ($product) {
            DB::table('products')
                ->where('id', $product->id)
                ->update(['sku' => 'SKU-' . str_pad($product->id, 4, '0', STR_PAD_LEFT)]);
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropUnique(['sku']);
            $table->dropColumn(['sku', 'min_stock']);
        });
    }
};