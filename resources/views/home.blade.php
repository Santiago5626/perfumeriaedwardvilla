 @extends('layouts.app')

@section('title', 'Edward Villa Perfumería - Fragancias de Lujo')
@section('description', 'Descubre las mejores fragancias de lujo en Edward Villa Perfumería. Perfumes exclusivos para hombre, mujer y unisex de las marcas más prestigiosas.')

@section('content')
<!-- Hero Section -->
<section class="hero-section mb-2">
    <div class="hero-video">
        {{-- preload="none" para no bloquear la carga inicial; JavaScript lo activa en cuanto la pagina esta lista --}}
        <video id="hero-video" muted loop playsinline preload="none" class="background-video">
            <source src="{{ asset('videos/background.mp4') }}" type="video/mp4">
        </video>
    </div>
    <div class="hero-content text-center">
        <img src="{{ asset('images/logo.png') }}" alt="Edward Villa Perfumería" class="hero-logo">
    </div>
</section>

<!-- Offers Slider Section -->
@if($activeOffers->count() > 0)
<section class="offers-section mb-5">
    <div class="container">
        <div class="text-center mb-4">
            <h2 class="section-title">Ofertas Especiales</h2>
            <p class="section-subtitle">Descubre nuestras increíbles promociones</p>
        </div>
        
        <div class="swiper offers-slider">
            <div class="swiper-wrapper">
                @foreach($activeOffers as $offer)
                    <div class="swiper-slide">
                        <div class="offer-card">
                            <div class="offer-image">
                                @if($offer->product->image_url)
                                    <img src="{{ $offer->product->image_url }}" 
                                         alt="{{ $offer->product->name }}" 
                                         class="product-image">
                                @else
                                    <div class="product-image d-flex align-items-center justify-content-center bg-light">
                                        <i class="fas fa-image text-muted" style="font-size: 2rem;"></i>
                                    </div>
                                @endif
                                <div class="offer-badge">
                                    -{{ $offer->discount_percentage }}%
                                </div>
                            </div>
                            <div class="offer-info">
                                <h3 class="offer-title">{{ $offer->product->name }}</h3>
                                <div class="offer-prices">
                                    <span class="final-price">${{ number_format($offer->final_price, 2) }}</span>
                                    <span class="original-price">${{ number_format($offer->product->price, 2) }}</span>
                                </div>
                                <a href="{{ route('products.show', $offer->product) }}" class="btn btn-primary-custom">
                                    Ver Detalles
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Navegación -->
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
            
            <!-- Paginación -->
            <div class="swiper-pagination"></div>
        </div>
    </div>
</section>
@endif

@if($activeOffers->count() > 0)
    @push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css" />
    <style>
        .offers-section {
            padding: 2rem 0;
            position: relative;
        }

        .offers-slider {
            padding: 2rem;
        }

        .swiper-slide {
            height: auto;
            display: flex;
        }

        .offer-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            width: 100%;
            display: flex;
            flex-direction: column;
        }

        .offer-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.15);
        }

        .offer-image {
            position: relative;
            height: 250px;
            overflow: hidden;
        }

        .offer-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .offer-badge {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: var(--gold);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 25px;
            font-weight: bold;
        }

        .offer-info {
            padding: 1.5rem;
            text-align: center;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .offer-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 0.75rem;
            color: var(--primary-color);
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            min-height: 2.6rem;
        }

        .offer-prices {
            margin-bottom: 1rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.25rem;
        }

        .final-price {
            color: var(--gold);
            font-weight: 800;
            font-size: 1.8rem;
            line-height: 1;
        }

        .original-price {
            text-decoration: line-through;
            color: var(--medium-gray);
            font-size: 0.9rem;
        }

        /* Estilos para los controles del Swiper */
        .swiper-button-next,
        .swiper-button-prev {
            color: var(--primary-color);
            background: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .swiper-button-next:after,
        .swiper-button-prev:after {
            font-size: 1.2rem;
        }

        .swiper-pagination-bullet {
            background: var(--primary-color);
            opacity: 0.5;
        }

        .swiper-pagination-bullet-active {
            opacity: 1;
        }

        /* Ajustes responsivos */
        @media (max-width: 768px) {
            .offers-slider {
                padding: 1rem;
            }

            .swiper-button-next,
            .swiper-button-prev {
                display: none;
            }
        }
    </style>
    @endpush

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            new Swiper('.offers-slider', {
                slidesPerView: 1,
                spaceBetween: 30,
                centeredSlides: true,
                autoplay: {
                    delay: 3000,
                    disableOnInteraction: false,
                },
                loop: true,
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                breakpoints: {
                    640: {
                        slidesPerView: 2,
                        centeredSlides: false,
                    },
                    768: {
                        slidesPerView: 3,
                        centeredSlides: false,
                    },
                    1024: {
                        slidesPerView: 3,
                        centeredSlides: false,
                    },
                },
                effect: 'slide',
                speed: 800,
            });
        });
    </script>
    @endpush
@endif

<!-- Productos Destacados -->
<section class="featured-section mb-5">
    <div class="container">
        <div class="text-center mb-4">
            <h2 class="section-title">Productos Destacados</h2>
            <p class="section-subtitle">Nuestras fragancias más populares</p>
        </div>
        
        <div class="row g-3 g-md-4">
            @foreach($featuredProducts as $product)
                <div class="col-6 col-md-3">
                    <div class="product-card">
                        <a href="{{ route('products.show', $product) }}" class="text-decoration-none">
                            @if($product->image_url)
                                <img src="{{ $product->image_url }}" 
                                     alt="{{ $product->name }}" 
                                     class="product-image">
                            @else
                                <div class="product-image d-flex align-items-center justify-content-center bg-light">
                                    <i class="fas fa-image text-muted" style="font-size: 2rem;"></i>
                                </div>
                            @endif
                            
                            <div class="product-info">
                                <div class="product-category">{{ $product->category->name }}</div>
                                <h3 class="product-title">{{ $product->name }}</h3>
                                <div class="product-price">
                                    @if($product->hasActiveOffer())
                                        <span class="current-price" style="color: var(--gold);">${{ number_format($product->final_price, 2) }}</span>
                                        <span class="original-price">${{ number_format($product->price, 2) }}</span>
                                    @else
                                        <span class="current-price">${{ number_format($product->price, 2) }}</span>
                                    @endif
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="text-center mt-4">
            <a href="{{ route('products.index') }}" class="btn btn-outline-dark btn-lg">
                Ver Todos los Productos
            </a>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="features-section mb-4">
    <div class="container">
        <div class="row g-2 justify-content-center">
            <div class="col-6">
                <div class="feature-item-mini d-flex align-items-center gap-3">
                    <div class="feature-icon-mini">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <div class="text-start">
                        <h6 class="mb-0">Envío Seguro</h6>
                        <small>Protegemos tu compra</small>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="feature-item-mini d-flex align-items-center gap-3">
                    <div class="feature-icon-mini">
                        <i class="fas fa-headset"></i>
                    </div>
                    <div class="text-start">
                        <h6 class="mb-0">Soporte 24/7</h6>
                        <small>Atención al cliente</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Newsletter Section -->
<section class="newsletter-section">
    <div class="newsletter-card">
        <div class="newsletter-inner">
            <div class="newsletter-text">
                <h4 class="newsletter-titulo">Novedades y Ofertas Exclusivas</h4>
                <p class="newsletter-subtitulo">Recibe promociones antes que nadie</p>
            </div>
            <form id="newsletter-form" class="newsletter-form-inline">
                @csrf
                <div class="newsletter-input-group">
                    <input type="email" name="email" class="newsletter-input" placeholder="Tu correo electronico" required>
                    <button class="newsletter-btn" type="submit">
                        <i class="fas fa-paper-plane"></i>
                        <span>Suscribirse</span>
                    </button>
                </div>
                <div id="newsletter-message" class="mt-2" style="display: none;"></div>
            </form>
        </div>
    </div>

        @push('scripts')
        <script>
            document.getElementById('newsletter-form').addEventListener('submit', function(e) {
                e.preventDefault();
                
                const form = this;
                const messageDiv = document.getElementById('newsletter-message');
                const submitButton = form.querySelector('button[type="submit"]');
                const originalButtonText = submitButton.innerHTML;
                
                // Deshabilitar el botón y mostrar estado de carga
                submitButton.disabled = true;
                submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Procesando...';
                
                fetch('{{ route("newsletter.subscribe") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        email: form.querySelector('input[name="email"]').value
                    })
                })
                .then(response => response.json())
                .then(data => {
                    messageDiv.style.display = 'block';
                    messageDiv.className = 'mt-3 alert ' + (data.success ? 'alert-success' : 'alert-danger');
                    messageDiv.textContent = data.message;
                    
                    if (data.success) {
                        form.reset();
                    }
                })
                .catch(error => {
                    messageDiv.style.display = 'block';
                    messageDiv.className = 'mt-3 alert alert-danger';
                    messageDiv.textContent = 'Error al procesar la suscripción. Por favor, inténtalo de nuevo.';
                })
                .finally(() => {
                    // Restaurar el botón
                    submitButton.disabled = false;
                    submitButton.innerHTML = originalButtonText;
                    
                    // Ocultar el mensaje después de 5 segundos
                    setTimeout(() => {
                        messageDiv.style.display = 'none';
                    }, 5000);
                });
            });
        </script>
        @endpush
    </div>
</section>

@push('styles')
<style>
    /* Hero Section */
    .hero-section {
        height: 60vh;
        background: white;
        position: relative;
        border-radius: 15px;
        overflow: hidden;
    }

    .hero-video {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 1;
    }

    .background-video {
        object-fit: cover;
        position: absolute;
        top: -20px;
        left: -20px;
        width: calc(100% + 40px);
        height: calc(100% + 40px);
    }
    
    .hero-content {
        position: relative;
        z-index: 2;
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem;
    }
    
    .hero-logo {
        max-width: 80%;
        max-height: 80%;
        object-fit: contain;
    }

    /* Tarjetas de Producto en Home */
    .product-card {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 16px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
        border: 1px solid rgba(0,0,0,0.05);
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 30px rgba(0,0,0,0.14);
    }

    .product-card .product-image {
        width: 100%;
        height: 220px;
        object-fit: cover;
        display: block;
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        transition: transform 0.3s ease;
    }

    .product-card:hover .product-image {
        transform: scale(1.04);
    }

    .product-card .product-info {
        padding: 1rem;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .product-card .product-category {
        color: var(--medium-gray);
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 0.25rem;
    }

    .product-card .product-title {
        font-size: 0.95rem;
        color: var(--primary-color);
        margin-bottom: 0.4rem;
        line-height: 1.3;
        font-weight: 600;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .product-card .current-price {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--primary-color);
    }

    /* Titulos de Secciones */
    .section-title {
        font-family: var(--font-display);
        font-size: 2.5rem;
        font-weight: 600;
        color: var(--primary-color);
        margin-bottom: 0.5rem;
    }
    
    .section-subtitle {
        font-size: 1.1rem;
        color: var(--medium-gray);
        margin-bottom: 2rem;
    }
    
    
    /* Features Section Compacta */
    .features-section {
        background-color: var(--light-gray);
        padding: 1rem 0;
        border-radius: 12px;
    }

    .feature-item-mini {
        padding: 0.75rem 1rem;
        background: white;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        height: 100%;
    }

    .feature-icon-mini {
        width: 44px;
        height: 44px;
        min-width: 44px;
        background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--gold);
        font-size: 1.1rem;
    }

    .feature-item-mini h6 {
        font-size: 0.9rem;
        font-weight: 600;
        color: var(--primary-color);
    }

    .feature-item-mini small {
        color: var(--medium-gray);
        font-size: 0.75rem;
    }

    /* Newsletter Compacto */
    .newsletter-section {
        border-radius: 15px;
        overflow: hidden;
    }

    .newsletter-card {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        padding: 1.5rem;
        color: white;
        border-radius: 15px;
    }

    .newsletter-inner {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        flex-wrap: wrap;
    }

    .newsletter-text {
        flex: 1;
        min-width: 160px;
    }

    .newsletter-titulo {
        font-size: 1.1rem;
        font-weight: 700;
        margin-bottom: 0.2rem;
        line-height: 1.3;
    }

    .newsletter-subtitulo {
        font-size: 0.82rem;
        opacity: 0.85;
        margin: 0;
    }

    .newsletter-form-inline {
        flex: 2;
        min-width: 220px;
    }

    .newsletter-input-group {
        display: flex;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }

    .newsletter-input {
        flex: 1;
        padding: 0.65rem 1rem;
        border: none;
        font-size: 0.9rem;
        outline: none;
        background: white;
        color: #333;
    }

    .newsletter-input::placeholder {
        color: #aaa;
        font-size: 0.85rem;
    }

    .newsletter-btn {
        padding: 0.65rem 1.1rem;
        background: var(--gold);
        border: none;
        color: white;
        font-weight: 600;
        font-size: 0.85rem;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 0.4rem;
        transition: background 0.2s ease;
        white-space: nowrap;
    }

    .newsletter-btn:hover {
        background: #c9a227;
    }
    
    /* Product Pricing */
    .product-price {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        gap: 0.25rem;
    }
    
    .current-price {
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--primary-color);
    }
    
    .original-price {
        font-size: 0.9rem;
        color: var(--medium-gray);
        text-decoration: line-through;
    }
    
    .discount-badge {
        background: var(--gold);
        color: white;
        padding: 0.2rem 0.5rem;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    /* Responsive Movil */
    @media (max-width: 768px) {
        .section-title {
            font-size: 2rem;
        }
        
        .hero-section {
            height: 45vh;
        }

        .featured-section {
            padding: 0;
        }

        /* Tarjetas de producto mas compactas en movil */
        .product-card .product-image {
            height: 180px;
        }

        .product-info {
            padding: 0.75rem;
        }

        .product-title {
            font-size: 0.85rem;
        }

        .current-price {
            font-size: 1rem;
        }
    }
    
    @media (max-width: 576px) {
        .section-title {
            font-size: 1.6rem;
        }

        .section-subtitle {
            font-size: 0.95rem;
        }

        .hero-section {
            height: 40vh;
        }
        
        .newsletter-form .form-control,
        .newsletter-form .btn {
            border-radius: 25px;
            margin-bottom: 1rem;
        }
        
        .newsletter-form .input-group {
            flex-direction: column;
        }

        .newsletter-section {
            padding: 2rem 1rem;
        }

        /* Tarjetas aun mas compactas en pantallas muy pequenas */
        .product-card .product-image {
            height: 150px;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    // Reproducir el video de fondo DESPUES de que la pagina cargue para no bloquear el renderizado inicial
    window.addEventListener('load', function () {
        const video = document.getElementById('hero-video');
        if (video) {
            video.load();
            video.play().catch(function () {
                // El navegador puede bloquear autoplay sin interaccion; no es critico
            });
        }
    });
</script>
@endpush
@endsection
