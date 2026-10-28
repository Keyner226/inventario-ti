<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Reglas de validación compartidas por store() y update()
    private function rules(): array
    {
        return [
            'category_id' => ['required', 'exists:categories,id'],
            'supplier_id' => ['required', 'exists:suppliers,id'],
            'name'        => ['required', 'string', 'max:150'],
            'price'       => ['required', 'numeric', 'min:0', 'max:99999999.99'],
            'stock'       => ['required', 'integer', 'min:0'],
            'description' => ['nullable', 'string', 'max:2000'],
        ];
    }

    // Lista los productos con su categoría y proveedor (with evita consultas repetidas)
    public function index()
    {
        $products = Product::with(['category', 'supplier'])
            ->orderBy('name')
            ->paginate(10);

        return view('products.index', compact('products'));
    }

    // Muestra el formulario de registro, con las listas para los select
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        $suppliers  = Supplier::orderBy('name')->get();

        return view('products.create', compact('categories', 'suppliers'));
    }

    // Valida y guarda un producto nuevo
    public function store(Request $request)
    {
        $data = $request->validate($this->rules());

        Product::create($data);

        return redirect()->route('products.index')
            ->with('success', 'Producto registrado correctamente.');
    }

    // Muestra el formulario de edición con el producto y las listas
    public function edit(Product $product)
    {
        $categories = Category::orderBy('name')->get();
        $suppliers  = Supplier::orderBy('name')->get();

        return view('products.edit', compact('product', 'categories', 'suppliers'));
    }

    // Valida con las mismas reglas y actualiza el producto
    public function update(Request $request, Product $product)
    {
        $data = $request->validate($this->rules());

        $product->update($data);

        return redirect()->route('products.index')
            ->with('success', 'Producto actualizado correctamente.');
    }

    // Elimina el producto
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Producto eliminado correctamente.');
    }
}