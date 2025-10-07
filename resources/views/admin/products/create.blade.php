@extends('layouts.app')

@section('title', 'Crear Producto - Edward Villa Perfumería')

@section('content')
<div class="admin-container">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="admin-title">Crear Nuevo Producto</h1>
            <p class="text-muted mb-0">Agrega un nuevo producto al catálogo</p>
        </div>
        <a href="{{ route('admin.productos.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Volver a Productos
        </a>
    </div>

    <!-- Product Form -->
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.productos.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="row">
                    <!-- Product Name -->
                    <div class="col-md-8 mb-3">
                        <label for="name" class="form-label">Nombre del Producto *</label>
                        <input type="text" 
                               class="form-control @error('name') is-invalid @enderror" 
                               id="name" 
                               name="name" 
                               value="{{ old('name') }}" 
                               required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Category -->
                    <div class="col-md-4 mb-3">
                        <label for="category_id" class="form-label">Categoría *</label>
                        <select class="form-select @error('category_id') is-invalid @enderror" 
                                id="category_id" 
                                name="category_id" 
                                required>
                            <option value="">Seleccionar categoría</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="col-12 mb-3">
                        <label for="description" class="form-label">Descripción *</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" 
                                  name="description" 
                                  rows="4" 
                                  required>{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Price -->
                    <div class="col-md-4 mb-3">
                        <label for="price" class="form-label">Precio *</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" 
                                   class="form-control @error('price') is-invalid @enderror" 
                                   id="price" 
                                   name="price" 
                                   value="{{ old('price') }}" 
                                   step="0.01" 
                                   min="0" 
                                   required>
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Size -->
                    <div class="col-md-4 mb-3">
                        <label for="size" class="form-label">Tamaño (ml) *</label>
                        <input type="number" 
                               class="form-control @error('size') is-invalid @enderror" 
                               id="size" 
                               name="size" 
                               value="{{ old('size') }}" 
                               min="1" 
                               required>
                        @error('size')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Stock -->
                    <div class="col-md-4 mb-3">
                        <label for="stock" class="form-label">Stock *</label>
                        <input type="number" 
                               class="form-control @error('stock') is-invalid @enderror" 
                               id="stock" 
                               name="stock" 
                               value="{{ old('stock') }}" 
                               min="0" 
                               required>
                        @error('stock')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Gender -->
                    <div class="col-md-6 mb-3">
                        <label for="gender" class="form-label">Género *</label>
                        <select class="form-select @error('gender') is-invalid @enderror" 
                                id="gender" 
                                name="gender" 
                                required>
                            <option value="">Seleccionar género</option>
                            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Masculino</option>
                            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Femenino</option>
                            <option value="unisex" {{ old('gender') == 'unisex' ? 'selected' : '' }}>Unisex</option>
                        </select>
                        @error('gender')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Active Status -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Estado</label>
                        <div class="form-check">
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   id="active" 
                                   name="active" 
                                   value="1" 
                                   {{ old('active', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="active">
                                Producto activo
                            </label>
                        </div>
                    </div>

                    <!-- Image -->
                    <div class="col-12 mb-3">
                        <label for="image" class="form-label">Imagen del Producto *</label>
                        <input type="file" 
                               class="form-control @error('image') is-invalid @enderror" 
                               id="image" 
                               name="image" 
                               accept="image/*" 
                               required>
                        <div class="form-text">Formatos permitidos: JPG, PNG, GIF. Tamaño máximo: 2MB</div>
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Image Preview -->
                    <div class="col-12 mb-3">
                        <div id="imagePreview" class="d-none">
                            <label class="form-label">Vista previa:</label>
                            <div class="border rounded p-3 bg-light">
                                <img id="previewImg" src="" alt="Vista previa" class="img-fluid" style="max-height: 200px;">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.productos.index') }}" class="btn btn-outline-secondary">
                        Cancelar
                    </a>
                    <button type="submit" class="btn btn-primary-custom">
                        <i class="fas fa-save me-2"></i>Crear Producto
                    </button>
                </div>
            </form>
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
        font-weight: 600;
        color: var(--primary-color);
    }
    
    .form-control:focus,
    .form-select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(26, 26, 26, 0.25);
    }
    
    @media (max-width: 768px) {
        .admin-title {
            font-size: 2rem;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    // Image preview
    document.getElementById('image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const preview = document.getElementById('imagePreview');
        const previewImg = document.getElementById('previewImg');
        
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                preview.classList.remove('d-none');
            };
            reader.readAsDataURL(file);
        } else {
            preview.classList.add('d-none');
        }
    });
</script>
@endpush
@endsection
