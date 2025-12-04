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

        /* Navbar Minimal */
        .navbar-minimal {
            background-color: #fff;
            border-bottom: 1px solid #e0e0e0;
            padding: 0.75rem 0;
            z-index: 1030;
        }

        .navbar-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 2rem;
        }

        .navbar-left {
            display: flex;
            align-items: center;
            gap: 2rem;
        }

        .navbar-logo {
            font-size: 1.1rem;
            font-weight: 600;
            color: #000;
            text-decoration: none;
            white-space: nowrap;
        }

        .navbar-logo:hover {
            color: #000;
        }

        .navbar-links {
            display: none;
            align-items: center;
            gap: 1.5rem;
        }

        @media (min-width: 992px) {
            .navbar-links {
                display: flex;
            }
        }

        .nav-link-minimal {
            font-size: 0.95rem;
            font-weight: 400;
            color: #333;
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .nav-link-minimal:hover {
            color: #000;
        }

        /* Dropdown Minimal */
        .dropdown-minimal {
            position: relative;
        }

        .dropdown-toggle-minimal::after {
            content: '';
            margin-left: 0.3rem;
        }

        .dropdown-menu-minimal {
            position: absolute;
            top: calc(100% + 0.5rem);
            left: 0;
            background: #fff;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 0.5rem 0;
            min-width: 150px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s ease;
            z-index: 1040;
        }

        .dropdown-minimal:hover .dropdown-menu-minimal {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .dropdown-item-minimal {
            display: block;
            padding: 0.5rem 1rem;
            color: #333;
            text-decoration: none;
            font-size: 0.9rem;
            transition: background-color 0.2s ease;
        }

        .dropdown-item-minimal:hover {
            background-color: #f5f5f5;
            color: #000;
        }

        .dropdown-item-minimal:first-child {
            border-radius: 8px 8px 0 0;
        }

        .dropdown-item-minimal:last-child {
            border-radius: 0 0 8px 8px;
        }

        .dropdown-divider-minimal {
            height: 1px;
            background-color: #e0e0e0;
            margin: 0.5rem 0;
        }

        /* Navbar Search */
        .navbar-search {
            flex: 1;
            max-width: 400px;
        }

        .search-wrapper {
            position: relative;
            width: 100%;
        }

        .search-icon-minimal {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
            font-size: 0.9rem;
            pointer-events: none;
            z-index: 1;
        }

        .search-input-minimal {
            width: 100%;
            padding: 0.625rem 1rem 0.625rem 2.5rem;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            font-size: 0.9rem;
            background: #fafafa;
            transition: all 0.3s ease;
        }

        .search-input-minimal:focus {
            outline: none;
            border-color: #000;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(0,0,0,0.05);
        }

        /* Navbar Right */
        .navbar-right {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .cart-icon-minimal {
            position: relative;
            color: #000;
            font-size: 1.1rem;
            text-decoration: none;
            padding: 0.5rem;
        }

        .cart-icon-minimal:hover {
            color: #000;
        }

        .cart-badge-minimal {
            position: absolute;
            top: 0;
            right: 0;
            background-color: #000;
            color: #fff;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            font-size: 0.7rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }

        .btn-auth-minimal {
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
            font-weight: 500;
            text-decoration: none;
            border-radius: 6px;
            transition: all 0.2s ease;
            white-space: nowrap;
        }

        .btn-login-minimal {
            color: #000;
            background: transparent;
        }

        .btn-login-minimal:hover {
            background: #f5f5f5;
            color: #000;
        }

        .btn-register-minimal {
            background: #000;
            color: #fff;
        }

        .btn-register-minimal:hover {
            background: #222;
            color: #fff;
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        }

        .btn-user-minimal {
            padding: 0.5rem 1rem;
            border: 1px solid #e0e0e0;
            background: #fff;
            border-radius: 6px;
            font-size: 0.9rem;
            color: #000;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-user-minimal:hover {
            background: #f5f5f5;
            border-color: #ccc;
        }

        .user-dropdown .dropdown-menu-minimal {
            right: 0;
            left: auto;
        }

        /* Mobile Menu */
        .mobile-menu-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 1.2rem;
            color: #000;
            padding: 0.5rem;
            cursor: pointer;
        }

        @media (max-width: 991px) {
            .mobile-menu-toggle {
                display: block;
            }
        }

        .mobile-menu {
            position: fixed;
            top: 0;
            right: -100%;
            width: 280px;
            height: 100vh;
            background: #fff;
            z-index: 1050;
            transition: right 0.3s ease;
            box-shadow: -4px 0 12px rgba(0,0,0,0.1);
        }

        .mobile-menu.active {
            right: 0;
        }

        .mobile-menu-content {
            height: 100%;
            overflow-y: auto;
            padding: 1.5rem;
        }

        .mobile-menu-close {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: none;
            border: none;
            font-size: 1.5rem;
            color: #000;
            cursor: pointer;
            padding: 0.5rem;
        }

        .mobile-menu-links {
            margin-top: 3rem;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .mobile-menu-link {
            padding: 0.75rem 1rem;
            color: #000;
            text-decoration: none;
            font-size: 1rem;
            border-radius: 8px;
            transition: background-color 0.2s ease;
            display: block;
            border: none;
            background: none;
            text-align: left;
        }

        .mobile-menu-link:hover {
            background: #f5f5f5;
            color: #000;
        }

        .mobile-menu-dropdown {
            display: flex;
            flex-direction: column;
        }

        .mobile-dropdown-toggle {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .mobile-dropdown-content {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
            padding-left: 1rem;
        }

        .mobile-menu-dropdown.active .mobile-dropdown-content {
            max-height: 200px;
        }

        .mobile-dropdown-link {
            padding: 0.5rem 1rem;
            color: #666;
            text-decoration: none;
            font-size: 0.9rem;
            display: block;
            border-radius: 6px;
        }

        .mobile-dropdown-link:hover {
            background: #f5f5f5;
            color: #000;
        }

        /* Mobile Search */
        .mobile-search-minimal {
            background: #fafafa;
            border-bottom: 1px solid #e0e0e0;
            position: fixed;
            top: 60px;
            left: 0;
            right: 0;
            z-index: 1020;
        }

        @media (max-width: 991px) {
            .navbar-search {
                display: none !important;
            }
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
    <nav class="navbar-minimal fixed-top">
        <div class="container">
            <div class="navbar-content">
                <!-- Left: Logo & Links -->
                <div class="navbar-left">
                    <a class="navbar-logo" href="{{ route('home') }}">Edward Villa</a>
                    <div class="navbar-links">
                        <a href="{{ route('home') }}" class="nav-link-minimal">Inicio</a>
                        <a href="{{ route('products.index') }}" class="nav-link-minimal">Productos</a>
                        <div class="dropdown-minimal">
                            <a href="#" class="nav-link-minimal dropdown-toggle-minimal">
                                Categorías
                            </a>
                            <div class="dropdown-menu-minimal">
                                <a href="{{ route('products.index', ['genero' => 'male']) }}" class="dropdown-item-minimal">Masculinos</a>
                                <a href="{{ route('products.index', ['genero' => 'female']) }}" class="dropdown-item-minimal">Femeninos</a>
                                <a href="{{ route('products.index', ['genero' => 'unisex']) }}" class="dropdown-item-minimal">Unisex</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Center: Search (Desktop) -->
                <div class="navbar-search d-none d-lg-block">
                    <div class="search-wrapper position-relative">
                        <i class="fas fa-search search-icon-minimal"></i>
                        <input type="search" 
                               name="buscar" 
                               id="desktop-search-minimal" 
                               class="search-input-minimal" 
                               placeholder="Buscar perfumes..."
                               autocomplete="off">
                        <div id="desktop-search-results-minimal" class="search-results d-none"></div>
                    </div>
                </div>

                <!-- Right: Cart & Auth -->
                <div class="navbar-right">
                    <!-- Cart Icon -->
                    <a href="{{ route('cart.index') }}" class="cart-icon-minimal">
                        <i class="fas fa-shopping-cart"></i>
                        @if($cartCount > 0)
                            <span class="cart-badge-minimal">{{ $cartCount }}</span>
                        @endif
                    </a>

                    <!-- Auth Buttons -->
                    @auth
                        <div class="dropdown-minimal user-dropdown">
                            <button class="btn-user-minimal">
                                <i class="fas fa-user-circle me-1"></i>
                                {{ Auth::user()->name }}
                            </button>
                            <div class="dropdown-menu-minimal">
                                @if(!Auth::user()->is_admin)
                                    <a href="{{ route('orders.index') }}" class="dropdown-item-minimal">Mis Pedidos</a>
                                    <div class="dropdown-divider-minimal"></div>
                                @endif
                                @if(Auth::user()->is_admin)
                                    <a href="{{ route('admin.dashboard') }}" class="dropdown-item-minimal">Panel Admin</a>
                                    <div class="dropdown-divider-minimal"></div>
                                @endif
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item-minimal">Cerrar Sesión</button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="btn-auth-minimal btn-register-minimal">Iniciar Sesión</a>
                    @endauth

                    <!-- Mobile Menu Toggle -->
                    <button class="mobile-menu-toggle d-lg-none" id="mobile-menu-btn">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Mobile Search -->
    <div class="mobile-search-minimal d-lg-none">
        <div class="container py-2">
            <div class="search-wrapper position-relative">
                <i class="fas fa-search search-icon-minimal"></i>
                <input type="search" 
                       name="buscar" 
                       id="mobile-search-minimal" 
                       class="search-input-minimal" 
                       placeholder="Buscar perfumes..."
                       autocomplete="off">
                <div id="mobile-search-results-minimal" class="search-results d-none"></div>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div class="mobile-menu d-lg-none" id="mobile-menu">
        <div class="mobile-menu-content">
            <button class="mobile-menu-close" id="mobile-menu-close">
                <i class="fas fa-times"></i>
            </button>
            <div class="mobile-menu-links">
                <a href="{{ route('home') }}" class="mobile-menu-link">Inicio</a>
                <a href="{{ route('products.index') }}" class="mobile-menu-link">Productos</a>
                <div class="mobile-menu-dropdown">
                    <button class="mobile-menu-link mobile-dropdown-toggle">
                        Categorías
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="mobile-dropdown-content">
                        <a href="{{ route('products.index', ['genero' => 'male']) }}" class="mobile-dropdown-link">Masculinos</a>
                        <a href="{{ route('products.index', ['genero' => 'female']) }}" class="mobile-dropdown-link">Femeninos</a>
                        <a href="{{ route('products.index', ['genero' => 'unisex']) }}" class="mobile-dropdown-link">Unisex</a>
                    </div>
                </div>
                @auth
                    @if(!Auth::user()->is_admin)
                        <a href="{{ route('orders.index') }}" class="mobile-menu-link">Mis Pedidos</a>
                    @endif
                    @if(Auth::user()->is_admin)
                        <a href="{{ route('admin.dashboard') }}" class="mobile-menu-link">Panel Admin</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="mobile-menu-link text-start w-100">Cerrar Sesión</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="mobile-menu-link">Iniciar Sesión</a>
                @endauth
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
        // Mobile Menu Logic
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuBtn = document.getElementById('mobile-menu-btn');
            const mobileMenuClose = document.getElementById('mobile-menu-close');
            const mobileMenu = document.getElementById('mobile-menu');
            const mobileDropdownToggle = document.querySelector('.mobile-dropdown-toggle');
            const mobileMenuDropdown = document.querySelector('.mobile-menu-dropdown');

            if (mobileMenuBtn) {
                mobileMenuBtn.addEventListener('click', () => {
                    mobileMenu.classList.add('active');
                    document.body.style.overflow = 'hidden';
                });
            }

            if (mobileMenuClose) {
                mobileMenuClose.addEventListener('click', () => {
                    mobileMenu.classList.remove('active');
                    document.body.style.overflow = '';
                });
            }

            // Close menu when clicking outside
            document.addEventListener('click', (e) => {
                if (mobileMenu.classList.contains('active') && 
                    !mobileMenu.contains(e.target) && 
                    !mobileMenuBtn.contains(e.target)) {
                    mobileMenu.classList.remove('active');
                    document.body.style.overflow = '';
                }
            });

            if (mobileDropdownToggle) {
                mobileDropdownToggle.addEventListener('click', () => {
                    mobileMenuDropdown.classList.toggle('active');
                    const icon = mobileDropdownToggle.querySelector('i');
                    if (mobileMenuDropdown.classList.contains('active')) {
                        icon.classList.replace('fa-chevron-down', 'fa-chevron-up');
                    } else {
                        icon.classList.replace('fa-chevron-up', 'fa-chevron-down');
                    }
                });
            }
        });

        // Search Logic
        let searchTimeout;
        const debounceTime = 300;

        function setupSearch(type) {
            const searchInput = document.getElementById(type + '-search-minimal');
            const resultsContainer = document.getElementById(type + '-search-results-minimal');
            
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
            const searchInput = document.getElementById(type + '-search-minimal');
            if (searchInput.value.trim()) {
                window.location.href = `/productos?buscar=${encodeURIComponent(searchInput.value.trim())}`;
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            setupSearch('desktop');
            setupSearch('mobile');

            // Manejar la tecla Enter en los campos de búsqueda
            ['desktop', 'mobile'].forEach(type => {
                const searchInput = document.getElementById(type + '-search-minimal');
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
