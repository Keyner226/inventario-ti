<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $totalProducts   = Product::count();
        $totalCategories = Category::count();
        $totalSuppliers  = Supplier::count();

        // Stock bajo: stock <= min_stock de cada producto (regla del taller)
        $lowStockCount = Product::whereColumn('stock', '<=', 'min_stock')->count();

        $lowStockProducts = Product::with('category')
            ->whereColumn('stock', '<=', 'min_stock')
            ->orderBy('stock')
            ->take(5)
            ->get();

        $categoriesData = Category::withCount('products')->orderBy('name')->get();

        return view('dashboard', compact(
            'totalProducts',
            'totalCategories',
            'totalSuppliers',
            'lowStockCount',
            'lowStockProducts',
            'categoriesData'
        ));
    }
}