@extends('layouts.app')

@section('title', 'Categorías')
@section('subtitle', 'Organiza los productos del inventario por tipo.')

@section('actions')
    <a href="{{ route('categories.create') }}" class="btn btn-light fw-semibold">
        <i class="bi bi-plus-lg"></i> Nueva categoría
    </a>
@endsection

@section('content')
<div class="card card-soft">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th style="width: 70px">#</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($categories as $category)
                    <tr>
                        {{-- Número correlativo que respeta la paginación --}}
                        <td class="text-muted">{{ $categories->firstItem() + $loop->index }}</td>
                        <td class="fw-semibold">{{ $category->name }}</td>
                        <td class="text-muted">{{ \Illuminate\Support\Str::limit($category->description, 80) ?: '—' }}</td>
                        <td class="text-end text-nowrap">
                            <a href="{{ route('categories.edit', $category) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-pencil-square"></i> Editar
                            </a>
                            <form method="POST" action="{{ route('categories.destroy', $category) }}" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                        onclick="return confirm('¿Eliminar esta categoría?')">
                                    <i class="bi bi-trash"></i> Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-5">
                            <i class="bi bi-tags fs-1 d-block mb-2"></i>
                            No hay categorías registradas.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Paginación --}}
<div class="mt-3">{{ $categories->links() }}</div>
@endsection