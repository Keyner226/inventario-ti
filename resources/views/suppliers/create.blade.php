@extends('layouts.app')

@section('title', 'Nuevo proveedor')
@section('subtitle', 'Registra un proveedor y sus datos de contacto.')

@section('content')
<div class="row g-4">
    <div class="col-lg-7">
        <div class="card card-soft">
            <div class="card-body p-4">
                <form method="POST" action="{{ route('suppliers.store') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold">Nombre <span class="text-danger">*</span></label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}"
                               class="form-control @error('name') is-invalid @enderror"
                               maxlength="150" required placeholder="Ej. TechPerú S.A.C.">
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label fw-semibold">Email <span class="text-muted fw-normal">(opcional)</span></label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}"
                                   class="form-control @error('email') is-invalid @enderror"
                                   maxlength="255" placeholder="ventas@empresa.com">
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label fw-semibold">Teléfono <span class="text-muted fw-normal">(opcional)</span></label>
                            <input type="text" id="phone" name="phone" value="{{ old('phone') }}"
                                   class="form-control @error('phone') is-invalid @enderror"
                                   maxlength="30" placeholder="987654321">
                            @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="address" class="form-label fw-semibold">Dirección <span class="text-muted fw-normal">(opcional)</span></label>
                        <input type="text" id="address" name="address" value="{{ old('address') }}"
                               class="form-control @error('address') is-invalid @enderror"
                               maxlength="255" placeholder="Av. Principal 123, Lima">
                        @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <button type="submit" class="btn btn-brand px-4"><i class="bi bi-check2-circle"></i> Guardar</button>
                    <a href="{{ route('suppliers.index') }}" class="btn btn-outline-secondary">Cancelar</a>
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
                    <li>Solo el nombre es obligatorio (máximo 150 caracteres).</li>
                    <li>Si escribes un email, debe tener un formato válido.</li>
                    <li>El teléfono admite hasta 30 caracteres.</li>
                    <li>Un proveedor con productos asociados no se puede eliminar.</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection