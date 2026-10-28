@extends('layouts.app')

@section('title', 'Editar producto')
@section('subtitle', 'Modifica los datos del producto seleccionado.')

@section('content')
<div class="row g-4">
    <div class="col-lg-8">
        <div class="card card-soft">
            <div class="card-body p-4">
                <form method="POST" action="{{ route('products.update', $product) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold">Nombre <span class="text-danger">*</span></label>
                        <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}"
                               class="form-control @error('name') is-invalid @enderror"
                               maxlength="150" required>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="category_id" class="form-label fw-semibold">Categoría <span class="text-danger">*</span></label>
                            <select id="category_id" name="category_id" required
                                    class="form-select @error('category_id') is-invalid @enderror">
                                <option value="">Seleccione...</option>
                                @foreach ($categories as $category)
                                    {{-- Marca la categoría actual del producto, o la que el usuario eligió si hubo error --}}
                                    <option value="{{ $category->id }}" @selected(old('category_id', $product->category_id) == $category->id)>{{ $category->name }}</option>
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
                                    <option value="{{ $supplier->id }}" @selected(old('supplier_id', $product->supplier_id) == $supplier->id)>{{ $supplier->name }}</option>
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
                                <input type="number" id="price" name="price" step="0.01" min="0" value="{{ old('price', $product->price) }}"
                                       class="form-control @error('price') is-invalid @enderror" required>
                                @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="stock" class="form-label fw-semibold">Stock <span class="text-danger">*</span></label>
                            <input type="number" id="stock" name="stock" min="0" value="{{ old('stock', $product->stock) }}"
                                   class="form-control @error('stock') is-invalid @enderror" required>
                            @error('stock') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="description" class="form-label fw-semibold">Descripción <span class="text-muted fw-normal">(opcional)</span></label>
                        <textarea id="description" name="description" rows="3"
                                  class="form-control @error('description') is-invalid @enderror">{{ old('description', $product->description) }}</textarea>
                        @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <button type="submit" class="btn btn-brand px-4"><i class="bi bi-check2-circle"></i> Actualizar</button>
                    <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                </form>
            </div>
        </div>
    </div>

    {{-- Panel lateral con datos del registro --}}
    <div class="col-lg-4">
        <div class="card card-soft">
            <div class="card-body p-4">
                <h2 class="h6 fw-bold text-primary"><i class="bi bi-clock-history"></i> Detalles del registro</h2>
                <ul class="text-muted small mb-0">
                    <li>Identificador: <strong>#{{ $product->id }}</strong></li>
                    <li>Creado: {{ $product->created_at->format('d/m/Y H:i') }}</li>
                    <li>Última actualización: {{ $product->updated_at->format('d/m/Y H:i') }}</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection