<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    // Lista los proveedores ordenados por nombre, de 10 en 10
    public function index()
    {
        $suppliers = Supplier::orderBy('name')->paginate(10);
        return view('suppliers.index', compact('suppliers'));
    }

    // Muestra el formulario para registrar un proveedor
    public function create()
    {
        return view('suppliers.create');
    }

    // Valida y guarda un proveedor nuevo
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'    => ['required', 'string', 'max:150'],
            'email'   => ['nullable', 'email', 'max:255'],
            'phone'   => ['nullable', 'string', 'max:30'],
            'address' => ['nullable', 'string', 'max:255'],
        ]);

        Supplier::create($data);

        return redirect()->route('suppliers.index')
            ->with('success', 'Proveedor registrado correctamente.');
    }

    // Muestra el formulario con los datos del proveedor seleccionado
    public function edit(Supplier $supplier)
    {
        return view('suppliers.edit', compact('supplier'));
    }

    // Valida y actualiza el proveedor
    public function update(Request $request, Supplier $supplier)
    {
        $data = $request->validate([
            'name'    => ['required', 'string', 'max:150'],
            'email'   => ['nullable', 'email', 'max:255'],
            'phone'   => ['nullable', 'string', 'max:30'],
            'address' => ['nullable', 'string', 'max:255'],
        ]);

        $supplier->update($data);

        return redirect()->route('suppliers.index')
            ->with('success', 'Proveedor actualizado correctamente.');
    }

    // Elimina el proveedor, salvo que tenga productos asociados
    public function destroy(Supplier $supplier)
    {
        if ($supplier->products()->exists()) {
            return redirect()->route('suppliers.index')
                ->with('error', 'No se puede eliminar: el proveedor tiene productos asociados.');
        }

        $supplier->delete();

        return redirect()->route('suppliers.index')
            ->with('success', 'Proveedor eliminado correctamente.');
    }
}