@extends('layouts.app')

@section('title', 'Editar Categoría - Panel de Administración')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="d-flex align-items-center mb-4">
                <a href="{{ route('admin.categorias.index') }}" class="btn btn-outline-secondary me-3">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <h1 class="admin-title mb-0">Editar Categoría</h1>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('admin.categorias.update', $category) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="name" class="form-label">Nombre de la Categoría</label>
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name', $category->name) }}" 
                                   required>
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                            <div class="form-text">
                                Slug actual: <code>{{ $category->slug }}</code>
                                <br>
                                El slug se actualizará automáticamente al cambiar el nombre.
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="description" class="form-label">Descripción <span class="text-muted">(Opcional)</span></label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" 
                                      name="description" 
                                      rows="3">{{ old('description', $category->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Category Stats -->
                        <div class="mb-4">
                            <h6 class="fw-bold mb-3">Estadísticas de la Categoría</h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="border rounded p-3 text-center">
                                        <div class="text-muted mb-1">Productos</div>
                                        <div class="fs-4 fw-bold text-primary">{{ $category->products()->count() }}</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="border rounded p-3 text-center">
                                        <div class="text-muted mb-1">Última Actualización</div>
                                        <div class="fs-6 fw-bold">{{ $category->updated_at->format('d/m/Y H:i') }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <div>
                                @if($category->products()->count() === 0)
                                    <form action="{{ route('admin.categorias.destroy', $category) }}" 
                                          method="POST" 
                                          class="d-inline"
                                          onsubmit="return confirm('¿Estás seguro de que quieres eliminar esta categoría?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger">
                                            <i class="fas fa-trash me-2"></i>Eliminar Categoría
                                        </button>
                                    </form>
                                @endif
                            </div>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.categorias.index') }}" class="btn btn-outline-secondary">
                                    Cancelar
                                </a>
                                <button type="submit" class="btn btn-primary-custom">
                                    <i class="fas fa-save me-2"></i>Guardar Cambios
                                </button>
                            </div>
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
