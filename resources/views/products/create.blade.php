@extends('layouts.app')

@section('title', 'Nuevo producto')
@section('subtitle', 'Registra un producto eligiendo su categoría y proveedor.')

@section('content')

{{-- Aviso si todavía no hay categorías o proveedores para elegir --}}
@if ($categories->isEmpty() || $suppliers->isEmpty())
    <div class="alert alert-warning border-0 shadow-sm">
        <i class="bi bi-exclamation-triangle-fill me-1"></i>
        Para registrar un producto necesitas al menos una
        <a href="{{ route('categories.create') }}" class="alert-link">categoría</a> y un
        <a href="{{ route('suppliers.create') }}" class="alert-link">proveedor</a>.
    </div>
@endif

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card card-soft">
            <div class="card-body p-4">
                <form method="POST" action="{{ route('products.store') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold">Nombre <span class="text-danger">*</span></label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}"
                               class="form-control @error('name') is-invalid @enderror"
                               maxlength="150" required placeholder="Ej. Teclado mecánico RGB">
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="category_id" class="form-label fw-semibold">Categoría <span class="text-danger">*</span></label>
                            <select id="category_id" name="category_id" required
                                    class="form-select @error('category_id') is-invalid @enderror">
                                <option value="">Seleccione...</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="supplier_id" class="form-label fw-semibold">Proveedor <span class="text-danger">*</span></label>
                            <select id="supplier_id" name="supplier_id" required
                                    class="form-select @error('supplier_id') is-invalid @enderror">
                                <option value="">Seleccione...</option>
                                @foreach ($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}" @selected(old('supplier_id') == $supplier->id)>{{ $supplier->name }}</option>
                                @endforeach
                            </select>
                            @error('supplier_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="price" class="form-label fw-semibold">Precio <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">S/</span>
                                <input type="number" id="price" name="price" step="0.01" min="0" value="{{ old('price') }}"
                                       class="form-control @error('price') is-invalid @enderror" required placeholder="0.00">
                                @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="stock" class="form-label fw-semibold">Stock <span class="text-danger">*</span></label>
                            <input type="number" id="stock" name="stock" min="0" value="{{ old('stock', 0) }}"
                                   class="form-control @error('stock') is-invalid @enderror" required>
                            @error('stock') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="description" class="form-label fw-semibold">Descripción <span class="text-muted fw-normal">(opcional)</span></label>
                        <textarea id="description" name="description" rows="3"
                                  class="form-control @error('description') is-invalid @enderror"
                                  placeholder="Detalles del producto">{{ old('description') }}</textarea>
                        @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <button type="submit" class="btn btn-brand px-4"><i class="bi bi-check2-circle"></i> Guardar</button>
                    <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                </form>
            </div>
        </div>
    </div>

    {{-- Panel lateral con reglas del formulario --}}
    <div class="col-lg-4">
        <div class="card card-soft">
            <div class="card-body p-4">
                <h2 class="h6 fw-bold text-primary"><i class="bi bi-info-circle"></i> Reglas del formulario</h2>
                <ul class="text-muted small mb-0">
                    <li>Nombre, categoría, proveedor, precio y stock son obligatorios.</li>
                    <li>El precio no puede ser negativo y admite 2 decimales.</li>
                    <li>El stock debe ser un número entero, mínimo 0.</li>
                    <li>La descripción es opcional (máximo 2000 caracteres).</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection