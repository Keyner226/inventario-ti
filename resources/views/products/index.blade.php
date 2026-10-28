@extends('layouts.app')

@section('title', 'Productos')
@section('subtitle', 'Inventario de accesorios informáticos con su categoría y proveedor.')

@section('actions')
    <a href="{{ route('products.create') }}" class="btn btn-light fw-semibold">
        <i class="bi bi-plus-lg"></i> Nuevo producto
    </a>
@endsection

@section('content')
<div class="card card-soft">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th style="width: 70px">#</th>
                    <th>Producto</th>
                    <th>Categoría</th>
                    <th>Proveedor</th>
                    <th class="text-end">Precio</th>
                    <th class="text-center">Stock</th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $product)
                    <tr>
                        {{-- Número correlativo que respeta la paginación --}}
                        <td class="text-muted">{{ $products->firstItem() + $loop->index }}</td>
                        <td class="fw-semibold">{{ $product->name }}</td>

                        {{-- Gracias a las relaciones belongsTo mostramos nombres, no números --}}
                        <td><span class="badge rounded-pill text-bg-primary-subtle text-primary-emphasis">{{ $product->category->name }}</span></td>
                        <td class="text-muted">{{ $product->supplier->name }}</td>

                        <td class="text-end fw-semibold">S/ {{ number_format($product->price, 2) }}</td>
                        <td class="text-center">{{ $product->stock }}</td>
                        <td class="text-end text-nowrap">
                            <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-pencil-square"></i> Editar
                            </a>
                            <form method="POST" action="{{ route('products.destroy', $product) }}" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                        onclick="return confirm('¿Eliminar este producto?')">
                                    <i class="bi bi-trash"></i> Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-5">
                            <i class="bi bi-box-seam fs-1 d-block mb-2"></i>
                            No hay productos registrados.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Paginación --}}
<div class="mt-3">{{ $products->links() }}</div>
@endsection