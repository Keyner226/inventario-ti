@extends('layouts.app')

@section('title', 'Proveedores')
@section('subtitle', 'Empresas y personas que suministran tus productos.')

@section('actions')
    <a href="{{ route('suppliers.create') }}" class="btn btn-light fw-semibold">
        <i class="bi bi-plus-lg"></i> Nuevo proveedor
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
                    <th>Email</th>
                    <th>Teléfono</th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($suppliers as $supplier)
                    <tr>
                        {{-- Número correlativo que respeta la paginación --}}
                        <td class="text-muted">{{ $suppliers->firstItem() + $loop->index }}</td>
                        <td class="fw-semibold">{{ $supplier->name }}</td>
                        <td class="text-muted">{{ $supplier->email ?: '—' }}</td>
                        <td class="text-muted">{{ $supplier->phone ?: '—' }}</td>
                        <td class="text-end text-nowrap">
                            <a href="{{ route('suppliers.edit', $supplier) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-pencil-square"></i> Editar
                            </a>
                            <form method="POST" action="{{ route('suppliers.destroy', $supplier) }}" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                        onclick="return confirm('¿Eliminar este proveedor?')">
                                    <i class="bi bi-trash"></i> Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-5">
                            <i class="bi bi-truck fs-1 d-block mb-2"></i>
                            No hay proveedores registrados.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Paginación --}}
<div class="mt-3">{{ $suppliers->links() }}</div>
@endsection