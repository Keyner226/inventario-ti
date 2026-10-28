<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class StockMovementController extends Controller
{
    // Muestra formulario, tarjetas, stock bajo e historial con filtros
    public function index(Request $request)
    {
        // Columna del stock mínimo en la tabla products
        $minField = 'min_stock';

        $query = StockMovement::with('product')->latest()->orderByDesc('id');

        // Filtro por producto
        if ($request->filled('product_id')) {
            $query->where('product_id', $request->input('product_id'));
        }

        // Filtro por tipo (solo valores válidos)
        if (in_array($request->input('type'), ['entrada', 'salida'], true)) {
            $query->where('type', $request->input('type'));
        }

        $movements = $query->paginate(10)->withQueryString();
        $products = Product::orderBy('name')->get();

        // Datos de las tarjetas (stock bajo: stock <= stock mínimo)
        $stats = [
            'total'    => StockMovement::count(),
            'entradas' => StockMovement::where('type', 'entrada')->sum('quantity'),
            'salidas'  => StockMovement::where('type', 'salida')->sum('quantity'),
            'low'      => Product::whereColumn('stock', '<=', $minField)->count(),
        ];

        // Los 5 productos con menos stock que necesitan reposición
        $lowStockProducts = Product::whereColumn('stock', '<=', $minField)
            ->orderBy('stock')
            ->take(5)
            ->get();

        return view('stock_movements.index', compact(
            'movements', 'products', 'stats', 'lowStockProducts', 'minField'
        ));
    }

    // Registra una entrada o salida
    public function store(Request $request)
    {
        $data = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'type'       => ['required', 'in:entrada,salida'],
            'quantity'   => ['required', 'integer', 'min:1'],
            'reason'     => ['nullable', 'string', 'max:255'],
        ]);

        DB::transaction(function () use ($data) {
            // Bloquea el producto mientras se calcula el nuevo stock
            $product = Product::whereKey($data['product_id'])
                ->lockForUpdate()
                ->firstOrFail();

            $before   = $product->stock;
            $quantity = (int) $data['quantity'];

            // No permitir sacar más de lo que hay
            if ($data['type'] === 'salida' && $quantity > $before) {
                throw ValidationException::withMessages([
                    'quantity' => 'No hay stock suficiente para esta salida.',
                ]);
            }

            $after = $data['type'] === 'entrada'
                ? $before + $quantity
                : $before - $quantity;

            StockMovement::create([
                'product_id'   => $product->id,
                'type'         => $data['type'],
                'quantity'     => $quantity,
                'stock_before' => $before,
                'stock_after'  => $after,
                'reason'       => $data['reason'] ?? null,
            ]);

            $product->update(['stock' => $after]);
        });

        return redirect()
            ->route('stock-movements.index')
            ->with('success', 'Movimiento registrado correctamente.');
    }
}