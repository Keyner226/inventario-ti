@extends('layouts.app')

@section('title', 'Movimientos de stock')
@section('subtitle', 'Registra entradas y salidas y consulta el historial')

@section('content')

    <style>
        /* Icono redondeado de las tarjetas de resumen */
        .stat-icon {
            width: 3rem; height: 3rem; border-radius: .9rem;
            display: flex; align-items: center; justify-content: center; font-size: 1.4rem;
        }
    </style>

    {{-- Errores de validación (el layout solo muestra success y error) --}}
    @if ($errors->any())
        <div class="alert alert-danger shadow-sm border-0">
            <i class="bi bi-exclamation-triangle-fill me-1"></i> Revisa los siguientes datos:
            <ul class="mb-0 mt-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Tarjetas de resumen --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-lg-3">
            <div class="card card-soft h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon bg-primary-subtle text-primary"><i class="bi bi-clock-history"></i></div>
                    <div>
                        <div class="text-muted small">Movimientos</div>
                        <div class="h3 fw-bold mb-0">{{ $stats['total'] }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card card-soft h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon bg-success-subtle text-success"><i class="bi bi-box-arrow-in-down"></i></div>
                    <div>
                        <div class="text-muted small">Unidades ingresadas</div>
                        <div class="h3 fw-bold mb-0">{{ $stats['entradas'] }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card card-soft h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon bg-danger-subtle text-danger"><i class="bi bi-box-arrow-up"></i></div>
                    <div>
                        <div class="text-muted small">Unidades retiradas</div>
                        <div class="h3 fw-bold mb-0">{{ $stats['salidas'] }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card card-soft h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon bg-warning-subtle text-warning-emphasis"><i class="bi bi-exclamation-triangle"></i></div>
                    <div>
                        <div class="text-muted small">Productos con stock bajo</div>
                        <div class="h3 fw-bold mb-0">{{ $stats['low'] }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        {{-- Formulario de movimiento --}}
        <div class="col-lg-8">
            <div class="card card-soft h-100">
                <div class="card-body p-4">
                    <h2 class="h5 fw-bold mb-3"><i class="bi bi-arrow-left-right me-1"></i> Registrar movimiento</h2>

                    <form method="POST" action="{{ route('stock-movements.store') }}">
                        @csrf

                        <div class="row g-3">
                            <div class="col-md-8">
                                <label class="form-label">Producto</label>
                                <select name="product_id" class="form-select" required>
                                    <option value="">Seleccionar producto</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}" @selected(old('product_id') == $product->id)>
                                            {{ $product->stock <= $product->{$minField} ? '⚠ ' : '' }}{{ $product->name }} — Stock: {{ $product->stock }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Tipo</label>
                                <select name="type" class="form-select" required>
                                    <option value="entrada" @selected(old('type') === 'entrada')>Entrada</option>
                                    <option value="salida" @selected(old('type') === 'salida')>Salida</option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Cantidad</label>
                                <input type="number" name="quantity" min="1"
                                       class="form-control @error('quantity') is-invalid @enderror"
                                       value="{{ old('quantity') }}" required>
                                @error('quantity')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-8">
                                <label class="form-label">Motivo</label>
                                <input type="text" name="reason" maxlength="255" class="form-control"
                                       value="{{ old('reason') }}" placeholder="Reposición, entrega, etc.">
                            </div>
                        </div>

                        <div class="mt-3">
                            <button type="submit" class="btn btn-brand">
                                <i class="bi bi-check-lg"></i> Registrar movimiento
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Panel de stock bajo --}}
        <div class="col-lg-4">
            <div class="card card-soft h-100">
                <div class="card-body p-4">
                    <h2 class="h5 fw-bold mb-3"><i class="bi bi-exclamation-triangle me-1"></i> Stock bajo</h2>

                    @forelse ($lowStockProducts as $item)
                        <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                            <div>
                                <div class="fw-semibold">{{ $item->name }}</div>
                                <div class="small text-muted">{{ $item->sku }}</div>
                            </div>
                            <span class="badge bg-warning text-dark">{{ $item->stock }} / mín. {{ $item->{$minField} }}</span>
                        </div>
                    @empty
                        <div class="text-center text-muted py-4">
                            <i class="bi bi-check-circle fs-1 text-success"></i>
                            <div class="mt-2">Todo el stock está en orden.</div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    {{-- Historial --}}
    <div class="card card-soft">
        <div class="card-body p-4 pb-3">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                <h2 class="h5 fw-bold mb-0"><i class="bi bi-clock-history me-1"></i> Historial</h2>

                {{-- Filtros por producto y tipo --}}
                <form method="GET" action="{{ route('stock-movements.index') }}" class="d-flex flex-wrap gap-2">
                    <select name="product_id" class="form-select form-select-sm w-auto">
                        <option value="">Todos los productos</option>
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}" @selected(request('product_id') == $product->id)>
                                {{ $product->name }}
                            </option>
                        @endforeach
                    </select>
                    <select name="type" class="form-select form-select-sm w-auto">
                        <option value="">Entradas y salidas</option>
                        <option value="entrada" @selected(request('type') === 'entrada')>Solo entradas</option>
                        <option value="salida" @selected(request('type') === 'salida')>Solo salidas</option>
                    </select>
                    <button type="submit" class="btn btn-sm btn-brand"><i class="bi bi-funnel"></i> Filtrar</button>
                    <a href="{{ route('stock-movements.index') }}" class="btn btn-sm btn-outline-secondary">Limpiar</a>
                </form>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Producto</th>
                        <th>Tipo</th>
                        <th>Cantidad</th>
                        <th>Stock</th>
                        <th>Motivo</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($movements as $movement)
                        <tr>
                            <td>{{ $movement->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <div class="fw-semibold">{{ $movement->product->name }}</div>
                                <div class="small text-muted">{{ $movement->product->sku }}</div>
                            </td>
                            <td>
                                @if ($movement->type === 'entrada')
                                    <span class="badge bg-success"><i class="bi bi-arrow-down-circle"></i> Entrada</span>
                                @else
                                    <span class="badge bg-danger"><i class="bi bi-arrow-up-circle"></i> Salida</span>
                                @endif
                            </td>
                            <td class="fw-bold {{ $movement->type === 'entrada' ? 'text-success' : 'text-danger' }}">
                                {{ $movement->type === 'entrada' ? '+' : '−' }}{{ $movement->quantity }}
                            </td>
                            <td>
                                {{ $movement->stock_before }}
                                <i class="bi bi-arrow-right text-muted"></i>
                                <strong>{{ $movement->stock_after }}</strong>
                            </td>
                            <td>{{ $movement->reason ?? '—' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">No hay movimientos para mostrar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($movements->hasPages())
            <div class="card-footer bg-transparent border-0 p-3">
                {{ $movements->links() }}
            </div>
        @endif
    </div>

@endsection