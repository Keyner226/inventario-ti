@extends('layouts.app')

@section('title', 'Editar proveedor')
@section('subtitle', 'Modifica los datos del proveedor seleccionado.')

@section('content')
<div class="row g-4">
    <div class="col-lg-7">
        <div class="card card-soft">
            <div class="card-body p-4">
                <form method="POST" action="{{ route('suppliers.update', $supplier) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold">Nombre <span class="text-danger">*</span></label>
                        <input type="text" id="name" name="name" value="{{ old('name', $supplier->name) }}"
                               class="form-control @error('name') is-invalid @enderror"
                               maxlength="150" required>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label fw-semibold">Email <span class="text-muted fw-normal">(opcional)</span></label>
                            <input type="email" id="email" name="email" value="{{ old('email', $supplier->email) }}"
                                   class="form-control @error('email') is-invalid @enderror"
                                   maxlength="255">
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label fw-semibold">Teléfono <span class="text-muted fw-normal">(opcional)</span></label>
                            <input type="text" id="phone" name="phone" value="{{ old('phone', $supplier->phone) }}"
                                   class="form-control @error('phone') is-invalid @enderror"
                                   maxlength="30">
                            @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="address" class="form-label fw-semibold">Dirección <span class="text-muted fw-normal">(opcional)</span></label>
                        <input type="text" id="address" name="address" value="{{ old('address', $supplier->address) }}"
                               class="form-control @error('address') is-invalid @enderror"
                               maxlength="255">
                        @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <button type="submit" class="btn btn-brand px-4"><i class="bi bi-check2-circle"></i> Actualizar</button>
                    <a href="{{ route('suppliers.index') }}" class="btn btn-outline-secondary">Cancelar</a>
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
                    <li>Identificador: <strong>#{{ $supplier->id }}</strong></li>
                    <li>Creado: {{ $supplier->created_at->format('d/m/Y H:i') }}</li>
                    <li>Última actualización: {{ $supplier->updated_at->format('d/m/Y H:i') }}</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection