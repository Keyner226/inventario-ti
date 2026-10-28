<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    // Lista las categorías ordenadas por nombre, de 10 en 10
    public function index()
    {
        $categories = Category::orderBy('name')->paginate(10);
        return view('categories.index', compact('categories'));
    }

    // Muestra el formulario para registrar una categoría
    public function create()
    {
        return view('categories.create');
    }

    // Valida y guarda una categoría nueva
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => ['required', 'string', 'max:100', 'unique:categories,name'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        Category::create($data);

        return redirect()->route('categories.index')
            ->with('success', 'Categoría registrada correctamente.');
    }

    // Muestra el formulario con los datos de la categoría seleccionada
    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    // Valida y actualiza la categoría (ignora su propio nombre en la regla unique)
    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'name'        => ['required', 'string', 'max:100', Rule::unique('categories', 'name')->ignore($category->id)],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        $category->update($data);

        return redirect()->route('categories.index')
            ->with('success', 'Categoría actualizada correctamente.');
    }

    // Elimina la categoría, salvo que tenga productos asociados
    public function destroy(Category $category)
    {
        if ($category->products()->exists()) {
            return redirect()->route('categories.index')
                ->with('error', 'No se puede eliminar: la categoría tiene productos asociados.');
        }

        $category->delete();

        return redirect()->route('categories.index')
            ->with('success', 'Categoría eliminada correctamente.');
    }
}