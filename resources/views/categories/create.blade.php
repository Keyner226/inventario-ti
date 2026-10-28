@extends('layouts.app')

@section('title', 'Nueva categoría')
@section('subtitle', 'Registra una categoría para clasificar tus productos.')

@section('content')
<div class="row g-4">
    <div class="col-lg-7">
        <div class="card card-soft">
            <div class="card-body p-4">
                <form method="POST" action="{{ route('categories.store') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold">Nombre <span class="text-danger">*</span></label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}"
                               class="form-control @error('name') is-invalid @enderror"
                               maxlength="100" required placeholder="Ej. Teclados">
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="description" class="form-label fw-semibold">Descripción <span class="text-muted fw-normal">(opcional)</span></label>
                        <textarea id="description" name="description" rows="4"
                                  class="form-control @error('description') is-invalid @enderror"
                                  placeholder="Ej. Teclados mecánicos y de membrana">{{ old('description') }}</textarea>
                        @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <button type="submit" class="btn btn-brand px-4"><i class="bi bi-check2-circle"></i> Guardar</button>
                    <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                </form>
            </div>
        </div>
    </div>

    {{-- Panel lateral con reglas del formulario --}}
    <div class="col-lg-5">
        <div class="card card-soft">
            <div class="card-body p-4">
                <h2 class="h6 fw-bold text-primary"><i class="bi bi-info-circle"></i> Reglas del formulario</h2>
                <ul class="text-muted small mb-0">
                    <li>El nombre es obligatorio y puede tener hasta 100 caracteres.</li>
                    <li>No pueden existir dos categorías con el mismo nombre.</li>
                    <li>La descripción es opcional (máximo 1000 caracteres).</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection