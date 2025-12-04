@extends('layouts.app')

@section('title', $product->name . ' - Edward Villa Perfumería')
@section('description', 'Compra ' . $product->name . ' - ' . Str::limit($product->description, 150) . ' Envío gratis en Edward Villa Perfumería.')

@section('content')
<!-- Breadcrumb -->
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('products.index') }}" class="text-decoration-none">Productos</a></li>
        <li class="breadcrumb-item"><a href="{{ route('products.index', ['categoria' => $product->category->slug]) }}" class="text-decoration-none">{{ $product->category->name }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
    </ol>
</nav>

<div class="row">
    <!-- Product Image -->
    <div class="col-lg-6 mb-4">
        <div class="product-image-container">
            @if($product->image)
                <img src="{{ str_starts_with($product->image, 'http') ? $product->image : asset('storage/products/' . $product->image) }}"
                     alt="{{ $product->name }}"
                     class="product-detail-image img-fluid rounded shadow-sm">
            @else
                <div class="product-detail-image bg-light rounded shadow-sm d-flex align-items-center justify-content-center">
                    <i class="fas fa-image text-muted" style="font-size: 5rem;"></i>
                </div>
            @endif
        </div>
    </div>

    <!-- Product Details -->
    <div class="col-lg-6">
        <div class="product-details">
            <!-- Category Badge -->
            <div class="mb-3">
                <span class="badge bg-secondary fs-6 px-3 py-2">{{ $product->category->name }}</span>
                <span class="badge bg-dark fs-6 px-3 py-2 ms-2">
                    {{ $product->gender == 'male' ? 'Masculino' : ($product->gender == 'female' ? 'Femenino' : 'Unisex') }}
                </span>
            </div>

            <!-- Product Name -->
            <h1 class="product-detail-title mb-3">{{ $product->name }}</h1>

            <!-- Price and Size -->
            <div class="price-section mb-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="price-info">
                        @if($product->hasActiveOffer())
                            <div class="d-flex align-items-center gap-2">
                                <span class="product-detail-price">${{ number_format($product->final_price, 2) }}</span>
                                <span class="discount-badge">-{{ $product->discount_percentage }}%</span>
                            </div>
                            <div class="original-price">${{ number_format($product->price, 2) }}</div>
                        @else
                            <span class="product-detail-price">${{ number_format($product->price, 2) }}</span>
                        @endif
                    </div>
                    <span class="product-size">{{ $product->size }}ml</span>
                </div>
            </div>

            <!-- Stock Status -->
            <div class="stock-status mb-4">
                @if($product->stock > 0)
                    <div class="alert alert-success d-flex align-items-center" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        <div>
                            <strong>Disponible</strong> - {{ $product->stock }} unidades en stock
                        </div>
                    </div>
                @else
                    <div class="alert alert-danger d-flex align-items-center" role="alert">
                        <i class="fas fa-times-circle me-2"></i>
                        <div>
                            <strong>Agotado</strong> - Producto no disponible
                        </div>
                    </div>
                @endif
            </div>

            <!-- Add to Cart -->
            @if($product->stock > 0)
                <div class="add-to-cart-section mb-4">
                    <form action="{{ route('cart.add') }}" method="POST" class="add-to-cart-form">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        
                        <div class="row g-3">
                            <div class="col-4">
                                <label for="quantity" class="form-label">Cantidad</label>
                                <select name="quantity" id="quantity" class="form-select">
                                    @for($i = 1; $i <= min(10, $product->stock); $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-8 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary-custom btn-lg w-100">
                                    <i class="fas fa-shopping-cart me-2"></i>Agregar al Carrito
                                </button>
                            </div>
                        </div>
                    </form>
                    
                    @guest
                        <div class="text-center mt-3">
                            <small class="text-muted">
                                <i class="fas fa-info-circle me-1"></i>
                                Para finalizar tu compra necesitarás <a href="{{ route('login') }}" class="text-decoration-none">iniciar sesión</a>
                            </small>
                        </div>
                    @endguest
                </div>
            @endif

            <!-- Product Features -->
            <div class="product-features mb-4">
                <div class="row g-3 justify-content-center">
                    <div class="col-6">
                        <div class="feature-item text-center p-3 bg-light rounded">
                            <i class="fas fa-shield-alt text-primary mb-2" style="font-size: 1.5rem;"></i>
                            <div class="small">Envío Seguro</div>
                            <div class="small text-muted">Protegemos tu compra</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="feature-item text-center p-3 bg-light rounded">
                            <i class="fas fa-headset text-primary mb-2" style="font-size: 1.5rem;"></i>
                            <div class="small">Soporte</div>
                            <div class="small text-muted">24/7</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Product Description -->
<div class="row mt-5">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0">
                <h3 class="mb-0">Descripción del Producto</h3>
            </div>
            <div class="card-body">
                <p class="product-description">{{ $product->description }}</p>
                
                <!-- Product Specifications -->
                <div class="row mt-4">
                    <div class="col-md-6">
                        <h5 class="mb-3">Especificaciones</h5>
                        <table class="table table-borderless">
                            <tr>
                                <td class="fw-semibold">Tamaño:</td>
                                <td>{{ $product->size }}ml</td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">Género:</td>
                                <td>{{ $product->gender == 'male' ? 'Masculino' : ($product->gender == 'female' ? 'Femenino' : 'Unisex') }}</td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">Categoría:</td>
                                <td>{{ $product->category->name }}</td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">Stock:</td>
                                <td>{{ $product->stock }} unidades</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h5 class="mb-3">Información de Envío</h5>
                        <ul class="list-unstyled">
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Envío seguro y protegido</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Entrega en 2-3 días hábiles</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Empaque discreto y seguro</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Seguimiento en línea</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Related Products -->
@if($relatedProducts->count() > 0)
<div class="row mt-5">
    <div class="col-12">
        <h3 class="mb-4">Productos Relacionados</h3>
        <div class="row g-4">
            @foreach($relatedProducts as $relatedProduct)
                <div class="col-6 col-md-3">
                    <div class="product-card">
                        <a href="{{ route('products.show', $relatedProduct) }}" class="text-decoration-none">
                            @if($relatedProduct->image)
                                <img src="{{ str_starts_with($relatedProduct->image, 'http') ? $relatedProduct->image : asset('storage/products/' . $relatedProduct->image) }}"
                                     alt="{{ $relatedProduct->name }}"
                                     class="product-image">
                            @else
                                <div class="product-image d-flex align-items-center justify-content-center bg-light">
                                    <i class="fas fa-image text-muted" style="font-size: 2rem;"></i>
                                </div>
                            @endif
                            
                            <div class="product-info">
                                <div class="product-category">{{ $relatedProduct->category->name }}</div>
                                <h4 class="product-title">{{ $relatedProduct->name }}</h4>
                                <div class="product-price">${{ number_format($relatedProduct->price, 2) }}</div>
                            </div>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endif

@push('styles')
<style>
    .product-detail-image {
        width: 100%;
        height: 500px;
        object-fit: cover;
    }
    
    .product-detail-title {
        font-family: var(--font-display);
        font-size: 2.5rem;
        font-weight: 600;
        color: var(--primary-color);
        line-height: 1.2;
    }
    
    .product-detail-price {
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--primary-color);
    }
    
    .product-size {
        font-size: 1.2rem;
        color: var(--medium-gray);
        font-weight: 500;
    }
    
    .product-description {
        font-size: 1.1rem;
        line-height: 1.7;
        color: var(--dark-gray);
    }
    
    .feature-item {
        transition: transform 0.2s ease;
    }
    
    .feature-item:hover {
        transform: translateY(-2px);
    }
    
    .breadcrumb-item a {
        color: var(--medium-gray);
    }
    
    .breadcrumb-item a:hover {
        color: var(--primary-color);
    }
    
    /* Discount Styles */
    .discount-badge {
        background: var(--gold);
        color: white;
        padding: 0.3rem 0.8rem;
        border-radius: 15px;
        font-size: 1rem;
        font-weight: 600;
    }
    
    .original-price {
        font-size: 1.2rem;
        color: var(--medium-gray);
        text-decoration: line-through;
        margin-top: 0.5rem;
    }
    
    @media (max-width: 768px) {
        .product-detail-title {
            font-size: 1.8rem;
        }
        
        .product-detail-price {
            font-size: 2rem;
        }
        
        .product-detail-image {
            height: 300px;
        }
    }
    
    @media (max-width: 576px) {
        .product-detail-title {
            font-size: 1.5rem;
        }
        
        .product-detail-price {
            font-size: 1.8rem;
        }
        
        .product-detail-image {
            height: 250px;
        }
    }
</style>
@endpush

@endsection
