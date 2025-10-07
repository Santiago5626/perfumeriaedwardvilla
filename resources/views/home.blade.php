 @extends('layouts.app')

@section('title', 'Edward Villa Perfumería - Fragancias de Lujo')
@section('description', 'Descubre las mejores fragancias de lujo en Edward Villa Perfumería. Perfumes exclusivos para hombre, mujer y unisex de las marcas más prestigiosas.')

@section('content')
<!-- Hero Section -->
<section class="hero-section mb-5">
    <div class="hero-video">
        <video autoplay muted loop playsinline class="background-video">
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
                                @if($offer->product->image)
                                    <img src="{{ str_starts_with($offer->product->image, 'http') ? $offer->product->image : asset('storage/products/' . $offer->product->image) }}" 
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
                                    <span class="original-price">${{ number_format($offer->product->price, 2) }}</span>
                                    <span class="final-price">${{ number_format($offer->final_price, 2) }}</span>
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

        .offer-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            height: 100%;
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
        }

        .offer-title {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: var(--primary-color);
        }

        .offer-prices {
            margin-bottom: 1rem;
        }

        .original-price {
            text-decoration: line-through;
            color: var(--medium-gray);
            margin-right: 1rem;
        }

        .final-price {
            color: var(--primary-color);
            font-weight: bold;
            font-size: 1.2rem;
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

<!-- Featured Products -->
<section class="featured-section mb-5">
    <div class="text-center mb-4">
        <h2 class="section-title">Productos Destacados</h2>
        <p class="section-subtitle">Nuestras fragancias más populares</p>
    </div>
    
    <div class="row g-4">
        @foreach($featuredProducts as $product)
            <div class="col-6 col-md-3">
                <div class="product-card">
                    <a href="{{ route('products.show', $product) }}" class="text-decoration-none">
                        @if($product->image)
                            <img src="{{ str_starts_with($product->image, 'http') ? $product->image : asset('storage/products/' . $product->image) }}" 
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
                                    <span class="current-price">${{ number_format($product->price, 2) }}</span>
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
</section>

<!-- Features Section -->
<section class="features-section mb-5">
    <div class="row g-4 justify-content-center">
        <div class="col-md-6 col-12">
            <div class="feature-item text-center">
                <div class="feature-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h4>Envío Seguro</h4>
                <p>Protegemos tu compra en cada envío</p>
            </div>
        </div>
        
        <div class="col-md-6 col-12">
            <div class="feature-item text-center">
                <div class="feature-icon">
                    <i class="fas fa-headset"></i>
                </div>
                <h4>Soporte 24/7</h4>
                <p>Atención al cliente siempre</p>
            </div>
        </div>
    </div>
</section>

<!-- Newsletter Section -->
<section class="newsletter-section">
    <div class="newsletter-card text-center">
        <h3>Mantente al día con nuestras novedades</h3>
        <p>Suscríbete y recibe ofertas exclusivas y lanzamientos antes que nadie</p>
        
        <form id="newsletter-form" class="newsletter-form">
            @csrf
            <div class="input-group">
                <input type="email" name="email" class="form-control" placeholder="Tu correo electrónico" required>
                <button class="btn btn-primary-custom" type="submit">
                    Suscribirse
                </button>
            </div>
            <div id="newsletter-message" class="mt-3" style="display: none;"></div>
        </form>

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
        width: 100%;
        height: 100%;
        object-fit: cover;
        position: absolute;
        bottom: 0;
        left: 0;
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
    
    /* Section Titles */
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
    
    
    /* Features Section */
    .features-section {
        background-color: var(--light-gray);
        padding: 3rem 0;
        border-radius: 15px;
    }
    
    .feature-item {
        padding: 2rem 1rem;
    }
    
    .feature-icon {
        width: 80px;
        height: 80px;
        background-color: var(--primary-color);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        color: white;
        font-size: 2rem;
    }
    
    .feature-item h4 {
        font-size: 1.2rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: var(--primary-color);
    }
    
    .feature-item p {
        color: var(--medium-gray);
        font-size: 0.95rem;
    }
    
    /* Newsletter Section */
    .newsletter-section {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        padding: 3rem;
        border-radius: 15px;
        color: white;
    }
    
    .newsletter-card h3 {
        font-size: 2rem;
        margin-bottom: 1rem;
    }
    
    .newsletter-card p {
        font-size: 1.1rem;
        margin-bottom: 2rem;
        opacity: 0.9;
    }
    
    .newsletter-form {
        max-width: 500px;
        margin: 0 auto;
    }
    
    .newsletter-form .form-control {
        border: none;
        padding: 1rem;
        border-radius: 25px 0 0 25px;
    }
    
    .newsletter-form .btn {
        border-radius: 0 25px 25px 0;
        padding: 1rem 2rem;
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

    /* Responsive Design */
    @media (max-width: 768px) {
        .hero-title {
            font-size: 2.5rem;
        }
        
        .hero-subtitle {
            font-size: 1.1rem;
        }
        
        .section-title {
            font-size: 2rem;
        }
        
        .category-image {
            height: 150px;
            font-size: 3rem;
        }
        
        .category-info {
            padding: 1.5rem;
        }
        
        .hero-section {
            height: 50vh;
        }
    }
    
    @media (max-width: 576px) {
        .hero-title {
            font-size: 2rem;
        }
        
        .section-title {
            font-size: 1.8rem;
        }
        
        .newsletter-form .form-control,
        .newsletter-form .btn {
            border-radius: 25px;
            margin-bottom: 1rem;
        }
        
        .newsletter-form .input-group {
            flex-direction: column;
        }
    }
</style>
@endpush
@endsection
