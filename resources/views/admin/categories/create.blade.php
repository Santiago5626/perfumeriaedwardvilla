@extends('layouts.app')

@section('title', 'Crear Nueva Categoría - Panel de Administración')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="d-flex align-items-center mb-4">
                <a href="{{ route('admin.categorias.index') }}" class="btn btn-outline-secondary me-3">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <h1 class="admin-title mb-0">Crear Nueva Categoría</h1>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('admin.categorias.store') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label for="name" class="form-label">Nombre de la Categoría</label>
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name') }}" 
                                   required 
                                   autofocus>
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                            <div class="form-text">
                                El slug se generará automáticamente a partir del nombre.
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="description" class="form-label">Descripción <span class="text-muted">(Opcional)</span></label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" 
                                      name="description" 
                                      rows="3">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.categorias.index') }}" class="btn btn-outline-secondary">
                                Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary-custom">
                                <i class="fas fa-save me-2"></i>Guardar Categoría
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .admin-title {
        font-family: var(--font-display);
        font-size: 2.5rem;
        font-weight: 600;
        color: var(--primary-color);
    }

    .form-label {
        font-weight: 500;
        color: var(--dark-gray);
    }
</style>
@endpush
@endsection
