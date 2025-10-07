<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Fragancias de Lujo')</title>
    <meta name="description" content="@yield('description', 'Descubre las mejores fragancias de lujo. Perfumes exclusivos para hombre, mujer y unisex.')">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&family=Dancing+Script:wght@400;500;600;700&family=Great+Vibes&family=Allura&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #1a1a1a;
            --secondary-color: #2d2d2d;
            --accent-color: #4a4a4a;
            --light-gray: #f8f9fa;
            --medium-gray: #6c757d;
            --dark-gray: #343a40;
            --white: #ffffff;
            --gold: #d4af37;
            --font-primary: 'Inter', sans-serif;
            --font-display: 'Playfair Display', serif;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: var(--font-primary);
            background-color: var(--white);
            color: var(--primary-color);
            line-height: 1.6;
            font-size: 16px;
        }

        /* Header Styles */
        .navbar-custom {
            background-color: var(--white);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 1rem 0;
            border-bottom: 1px solid #e9ecef;
        }

        .navbar-brand {
            font-family: 'Dancing Script', cursive;
            font-weight: 600;
            font-size: 2.2rem;
            color: var(--primary-color) !important;
            text-decoration: none;
            letter-spacing: 1px;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.1);
        }

        .navbar-brand:hover {
            color: var(--gold) !important;
            transition: color 0.3s ease;
        }

        .navbar-nav .nav-link {
            color: var(--dark-gray) !important;
            font-weight: 500;
            margin: 0 0.5rem;
            transition: color 0.3s ease;
        }

        .navbar-nav .nav-link:hover {
            color: var(--primary-color) !important;
        }

        .btn-search {
            background-color: var(--primary-color);
            border: none;
            color: var(--white);
            padding: 0.5rem 1rem;
            border-radius: 25px;
            transition: all 0.3s ease;
        }

        .btn-search:hover {
            background-color: var(--secondary-color);
            color: var(--white);
        }

        .cart-icon {
            position: relative;
            color: var(--primary-color);
            font-size: 1.2rem;
            text-decoration: none;
        }

        .cart-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background-color: var(--gold);
            color: var(--white);
            border-radius: 50%;
            width: 20px;
            height: 20px;
            font-size: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Main Content */
        .main-content {
            min-height: calc(100vh - 200px);
            padding: 2rem 0;
        }

        /* Product Cards */
        .product-card {
            background: var(--white);
            border: 1px solid #e9ecef;
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.3s ease;
            height: 100%;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }

        .product-image {
            width: 100%;
            height: 250px;
            object-fit: cover;
            background-color: var(--light-gray);
        }

        .product-info {
            padding: 1.5rem;
        }

        .product-title {
            font-weight: 600;
            font-size: 1.1rem;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
            line-height: 1.4;
        }

        .product-category {
            color: var(--medium-gray);
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }

        .product-price {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }

        .btn-primary-custom {
            background-color: var(--primary-color);
            border: none;
            color: var(--white);
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
            width: 100%;
        }

        .btn-primary-custom:hover {
            background-color: var(--secondary-color);
            color: var(--white);
        }

        /* Footer */
        .footer {
            background-color: var(--primary-color);
            color: var(--white);
            padding: 3rem 0 1rem;
            margin-top: 4rem;
        }

        .footer h5 {
            font-family: var(--font-primary);
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .footer a {
            color: #ccc;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer a:hover {
            color: var(--white);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .navbar-brand {
                font-size: 1.4rem;
            }
            
            .product-image {
                height: 200px;
            }
            
            .main-content {
                padding: 1rem 0;
                margin-top: 140px !important; /* Navbar + mobile search */
            }
            
            .product-info {
                padding: 1rem;
            }

            /* Mobile cart icon adjustments */
            .cart-icon {
                font-size: 1.2rem;
            }

            /* Ensure mobile search takes full width */
            .mobile-search .container {
                padding-left: 15px;
                padding-right: 15px;
            }

            .mobile-search .input-group {
                width: 100%;
            }
        }

        @media (min-width: 992px) {
            .main-content {
                margin-top: 100px !important; /* Solo navbar en desktop */
            }
        }

        /* Mobile Search */
        .mobile-search {
            background-color: var(--light-gray);
            border-bottom: 1px solid #e9ecef;
            position: fixed;
            top: 76px; /* Positioned below navbar */
            left: 0;
            right: 0;
            z-index: 1020;
        }

        /* Search Form */
        .search-form {
            width: 100%;
        }

        .search-input {
            border: 1px solid #ddd;
            border-radius: 25px 0 0 25px;
            padding: 0.5rem 1rem;
            border-right: none;
            flex: 1;
        }

        .search-input:focus {
            border-color: var(--primary-color);
            box-shadow: none;
        }

        /* Mobile search input group */
        .mobile-search .search-input {
            border-radius: 25px 0 0 25px;
        }

        .mobile-search .btn-search {
            border-radius: 0 25px 25px 0;
        }

        /* WhatsApp Floating Button */
        .whatsapp-float {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 100;
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            pointer-events: none;
        }

        .whatsapp-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 60px;
            height: 60px;
            background: #25d366;
            color: white;
            border-radius: 50%;
            text-decoration: none;
            font-size: 1.8rem;
            box-shadow: 0 4px 20px rgba(37, 211, 102, 0.4);
            transition: all 0.3s ease;
            animation: pulse 2s infinite;
            pointer-events: auto;
        }

        .whatsapp-btn:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 25px rgba(37, 211, 102, 0.6);
            color: white;
            text-decoration: none;
        }

        .whatsapp-btn:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(37, 211, 102, 0.3);
            color: white;
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 4px 20px rgba(37, 211, 102, 0.4);
            }
            50% {
                box-shadow: 0 4px 20px rgba(37, 211, 102, 0.4), 0 0 0 10px rgba(37, 211, 102, 0.1);
            }
            100% {
                box-shadow: 0 4px 20px rgba(37, 211, 102, 0.4);
            }
        }

        /* Responsive adjustments for WhatsApp button */
        @media (max-width: 768px) {
            .whatsapp-float {
                bottom: 20px;
                right: 20px;
            }
            
            .whatsapp-btn {
                width: 55px;
                height: 55px;
                font-size: 1.6rem;
            }
            
            .whatsapp-text {
                font-size: 0.7rem;
                padding: 4px 8px;
            }
        }

        .whatsapp-text {
            font-size: 0.8rem;
            color: white;
            margin-bottom: 8px;
            font-weight: 600;
            text-align: center;
            font-family: var(--font-primary);
            background: #25d366;
            padding: 6px 12px;
            border-radius: 20px;
            opacity: 0;
            transform: translateY(10px);
            transition: all 0.3s ease;
            white-space: nowrap;
            box-shadow: 0 2px 10px rgba(37, 211, 102, 0.3);
            pointer-events: none;
        }

        .whatsapp-text.show {
            opacity: 1;
            transform: translateY(0);
        }

        /* Alerts */
        .alert-custom {
            border: none;
            border-radius: 8px;
            padding: 1rem 1.5rem;
        }

        .alert-success-custom {
            background-color: #d4edda;
            color: #155724;
        }

        .alert-error-custom {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>

    @stack('styles')
    <style>
        .search-results {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            max-height: 400px;
            overflow-y: auto;
            z-index: 1050;
            margin-top: 5px;
        }

        .search-result-item {
            display: flex;
            align-items: center;
            padding: 10px 15px;
            border-bottom: 1px solid #eee;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .search-result-item:last-child {
            border-bottom: none;
        }

        .search-result-item:hover {
            background-color: #f8f9fa;
        }

        .search-result-image {
            width: 40px;
            height: 40px;
            object-fit: cover;
            border-radius: 4px;
            margin-right: 12px;
        }

        .search-result-placeholder {
            width: 40px;
            height: 40px;
            border-radius: 4px;
            margin-right: 12px;
            background-color: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #adb5bd;
        }

        .search-result-placeholder i {
            font-size: 1.2rem;
        }

        .search-result-info {
            flex-grow: 1;
        }

        .search-result-name {
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 2px;
        }

        .search-result-price {
            color: var(--gold);
            font-weight: 500;
            font-size: 0.9rem;
        }

        .no-results {
            padding: 15px;
            text-align: center;
            color: var(--medium-gray);
        }

        .search-loading {
            padding: 15px;
            text-align: center;
            color: var(--medium-gray);
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-custom fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                Edward Villa Perfumería
            </a>

            <!-- Mobile Cart Icon (visible only on mobile) -->
            <div class="d-lg-none d-flex align-items-center">
                <a class="nav-link cart-icon me-3" href="{{ route('cart.index') }}">
                    <i class="fas fa-shopping-cart"></i>
                    @if($cartCount > 0)
                        <span class="cart-badge">{{ $cartCount }}</span>
                    @endif
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('products.index') }}">Productos</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            Categorías
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('products.index', ['genero' => 'male']) }}">Masculinos</a></li>
                            <li><a class="dropdown-item" href="{{ route('products.index', ['genero' => 'female']) }}">Femeninos</a></li>
                            <li><a class="dropdown-item" href="{{ route('products.index', ['genero' => 'unisex']) }}">Unisex</a></li>
                        </ul>
                    </li>
                </ul>

    <!-- Desktop Search Form -->
    <div class="d-none d-lg-flex search-form me-3 position-relative">
        <input class="form-control search-input" type="search" name="buscar" id="desktop-search" placeholder="Buscar perfumes..." value="{{ request('buscar') }}" autocomplete="off">
        <button class="btn btn-search" type="button" onclick="performSearch('desktop')">
            <i class="fas fa-search"></i>
        </button>
        <div id="desktop-search-results" class="search-results d-none"></div>
    </div>

                <!-- User Menu -->
                <ul class="navbar-nav">
                    <!-- Desktop Cart Icon (visible only on desktop) -->
                    <li class="nav-item d-none d-lg-block">
                        <a class="nav-link cart-icon" href="{{ route('cart.index') }}">
                            <i class="fas fa-shopping-cart"></i>
                            @if($cartCount > 0)
                                <span class="cart-badge">{{ $cartCount }}</span>
                            @endif
                        </a>
                    </li>
                    
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu">
                                @if(!Auth::user()->is_admin)
                                    <li><a class="dropdown-item" href="{{ route('orders.index') }}">Mis Pedidos</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                @endif
                                @if(Auth::user()->is_admin)
                                    <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">Panel Admin</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                @endif
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Cerrar Sesión</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Iniciar Sesión</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Registrarse</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Mobile Search (moved below navbar) -->
    <div class="mobile-search d-lg-none">
        <div class="container py-2">
            <div class="search-form w-100 position-relative">
                <div class="input-group">
                    <input class="form-control search-input" type="search" name="buscar" id="mobile-search" placeholder="Buscar perfumes..." value="{{ request('buscar') }}" autocomplete="off">
                    <button class="btn btn-search" type="button" onclick="performSearch('mobile')">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
                <div id="mobile-search-results" class="search-results d-none"></div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <main class="main-content">
        <div class="container">
            <!-- Alerts -->
            @if(session('success'))
                <div class="alert alert-custom alert-success-custom alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-custom alert-error-custom alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <!-- WhatsApp Floating Button -->
    <div class="whatsapp-float">
        <div class="whatsapp-text">¿Necesitas ayuda con tu compra?</div>
        <a href="https://wa.me/573184812707?text=Hola,%20me%20interesa%20conocer%20más%20sobre%20sus%20productos%20de%20Edward%20Villa%20Perfumería" 
           target="_blank" 
           class="whatsapp-btn"
           title="Contáctanos por WhatsApp">
            <i class="fab fa-whatsapp"></i>
        </a>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-6 mb-4">
                    <h5>Edward Villa Perfumería</h5>
                    <p>Las mejores fragancias de lujo para toda ocasión. Calidad y elegancia en cada gota.</p>
                </div>
                <div class="col-md-6 mb-4">
                    <h5>Contacto</h5>
                    <p><i class="fas fa-envelope me-2"></i> edwardvillaperfumeria@gmail.com</p>
                    <p><i class="fas fa-phone me-2"></i> +57 318 4812707</p>
                    <div class="mt-3">
                        <a href="https://www.instagram.com/edward_villa2/?igsh=MTV6bDRydzhmc29wMw%3D%3D&utm_source=qr#" target="_blank" class="text-decoration-none">
                            <i class="fab fa-instagram me-2"></i>@edward_villa2
                        </a>
                    </div>
                </div>
            </div>
            <hr class="my-4">
            <div class="row">
                <div class="col-12 text-center">
                    <p>&copy; {{ date('Y') }} Edward Villa Perfumería. Todos los derechos reservados.</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- WhatsApp Auto Text Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const whatsappText = document.querySelector('.whatsapp-text');
            
            if (whatsappText) {
                // Función para mostrar el texto
                function showWhatsAppText() {
                    whatsappText.classList.add('show');
                    
                    // Ocultar después de 3 segundos
                    setTimeout(function() {
                        whatsappText.classList.remove('show');
                    }, 3000);
                }
                
                // Mostrar inmediatamente al cargar la página
                setTimeout(showWhatsAppText, 2000);
                
                // Repetir cada 30 segundos
                setInterval(showWhatsAppText, 30000);
            }
        });
    </script>
    
    @stack('scripts')
    <script>
        let searchTimeout;
        const debounceTime = 300;

        function setupSearch(type) {
            const searchInput = document.getElementById(type + '-search');
            const resultsContainer = document.getElementById(type + '-search-results');
            
            if (!searchInput || !resultsContainer) return;

            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                const query = this.value.trim();
                
                if (query.length < 2) {
                    resultsContainer.classList.add('d-none');
                    return;
                }

                resultsContainer.classList.remove('d-none');
                resultsContainer.innerHTML = '<div class="search-loading"><i class="fas fa-spinner fa-spin me-2"></i>Buscando...</div>';

                searchTimeout = setTimeout(() => {
                    fetch(`/api/search?query=${encodeURIComponent(query)}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.length === 0) {
                                resultsContainer.innerHTML = '<div class="no-results">No se encontraron resultados</div>';
                                return;
                            }

                            resultsContainer.innerHTML = data.map(product => `
                                <a href="${product.url}" class="text-decoration-none">
                                    <div class="search-result-item">
                                        ${product.image ? 
                                            `<img src="${product.image.startsWith('http') ? product.image : '/storage/products/' + product.image}" 
                                                  alt="${product.name}" 
                                                  class="search-result-image"
                                                  onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                             <div class="search-result-placeholder" style="display: none;">
                                                 <i class="fas fa-image"></i>
                                             </div>` :
                                            `<div class="search-result-placeholder">
                                                 <i class="fas fa-image"></i>
                                             </div>`
                                        }
                                        <div class="search-result-info">
                                            <div class="search-result-name">${product.name}</div>
                                            <div class="search-result-price">$${product.final_price.toLocaleString('es-CO', {minimumFractionDigits: 2})}</div>
                                        </div>
                                    </div>
                                </a>
                            `).join('');
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            resultsContainer.innerHTML = '<div class="no-results">Error al buscar productos</div>';
                        });
                }, debounceTime);
            });

            // Cerrar resultados al hacer clic fuera
            document.addEventListener('click', function(e) {
                if (!searchInput.contains(e.target) && !resultsContainer.contains(e.target)) {
                    resultsContainer.classList.add('d-none');
                }
            });
        }

        function performSearch(type) {
            const searchInput = document.getElementById(type + '-search');
            if (searchInput.value.trim()) {
                window.location.href = `/productos?buscar=${encodeURIComponent(searchInput.value.trim())}`;
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            setupSearch('desktop');
            setupSearch('mobile');

            // Manejar la tecla Enter en los campos de búsqueda
            ['desktop', 'mobile'].forEach(type => {
                const searchInput = document.getElementById(type + '-search');
                if (searchInput) {
                    searchInput.addEventListener('keypress', function(e) {
                        if (e.key === 'Enter') {
                            e.preventDefault();
                            performSearch(type);
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>
