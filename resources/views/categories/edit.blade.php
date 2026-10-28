@extends('layouts.app')

@section('title', 'Editar categoría')
@section('subtitle', 'Modifica los datos de la categoría seleccionada.')

@section('content')
<div class="row g-4">
    <div class="col-lg-7">
        <div class="card card-soft">
            <div class="card-body p-4">
                <form method="POST" action="{{ route('categories.update', $category) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold">Nombre <span class="text-danger">*</span></label>
                        <input type="text" id="name" name="name" value="{{ old('name', $category->name) }}"
                               class="form-control @error('name') is-invalid @enderror"
                               maxlength="100" required>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="description" class="form-label fw-semibold">Descripción <span class="text-muted fw-normal">(opcional)</span></label>
                        <textarea id="description" name="description" rows="4"
                                  class="form-control @error('description') is-invalid @enderror">{{ old('description', $category->description) }}</textarea>
                        @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <button type="submit" class="btn btn-brand px-4"><i class="bi bi-check2-circle"></i> Actualizar</button>
                    <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                </form>
            </div>
        </div>
    </div>

    {{-- Panel lateral con datos del registro --}}
    <div class="col-lg-5">
        <div class="card card-soft">
            <div class="card-body p-4">
                <h2 class="h6 fw-bold text-primary"><i class="bi bi-clock-history"></i> Detalles del registro</h2>
                <ul class="text-muted small mb-0">
                    <li>Identificador: <strong>#{{ $category->id }}</strong></li>
                    <li>Creada: {{ $category->created_at->format('d/m/Y H:i') }}</li>
                    <li>Última actualización: {{ $category->updated_at->format('d/m/Y H:i') }}</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection