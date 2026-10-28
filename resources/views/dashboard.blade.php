@extends('layouts.app')

@section('title', 'Dashboard')
@section('subtitle', 'Bienvenido, ' . auth()->user()->name . '. Aquí tienes el resumen del inventario.')

@section('content')

{{-- Tarjetas de indicadores --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-lg-3">
        <div class="card card-soft h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="fs-1 text-primary"><i class="bi bi-box-seam"></i></div>
                <div>
                    <div class="text-muted small fw-semibold">Total productos</div>
                    <div class="h3 fw-bold mb-0 text-primary">{{ $totalProducts }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card card-soft h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="fs-1 text-success"><i class="bi bi-tags"></i></div>
                <div>
                    <div class="text-muted small fw-semibold">Categorías</div>
                    <div class="h3 fw-bold mb-0 text-success">{{ $totalCategories }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card card-soft h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="fs-1" style="color:#7c3aed"><i class="bi bi-truck"></i></div>
                <div>
                    <div class="text-muted small fw-semibold">Proveedores</div>
                    <div class="h3 fw-bold mb-0" style="color:#7c3aed">{{ $totalSuppliers }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card card-soft h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="fs-1 text-danger"><i class="bi bi-exclamation-triangle"></i></div>
                <div>
                    <div class="text-muted small fw-semibold">Stock bajo</div>
                    <div class="h3 fw-bold mb-0 text-danger">{{ $lowStockCount }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">

    {{-- Productos por categoría --}}
    <div class="col-lg-6">
        <div class="card card-soft h-100">
            <div class="card-body">
                <h2 class="h5 fw-bold mb-3"><i class="bi bi-pie-chart me-1"></i> Productos por categoría</h2>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Categoría</th>
                                <th class="text-end">Productos</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($categoriesData as $category)
                                <tr>
                                    <td>{{ $category->name }}</td>
                                    <td class="text-end fw-semibold">{{ $category->products_count }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="2" class="text-center text-muted py-4">No hay categorías.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Productos con stock bajo --}}
    <div class="col-lg-6">
        <div class="card card-soft h-100">
            <div class="card-body">
                <h2 class="h5 fw-bold mb-3 text-danger"><i class="bi bi-exclamation-octagon me-1"></i> Productos con stock bajo</h2>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Categoría</th>
                                <th class="text-center">Stock</th>
                                <th class="text-center">Mínimo</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($lowStockProducts as $product)
                                <tr>
                                    <td class="fw-semibold">{{ $product->name }}</td>
                                    <td class="text-muted">{{ $product->category->name }}</td>
                                    <td class="text-center fw-bold text-danger">{{ $product->stock }}</td>
                                    <td class="text-center">{{ $product->min_stock }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-success py-4">
                                        <i class="bi bi-check-circle-fill"></i> Todo el stock está al día.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection