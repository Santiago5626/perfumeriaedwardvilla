@extends('layouts.app')

@section('title', 'Iniciar Sesión - Edward Villa Perfumería')

@section('content')
<div class="auth-container mt-4">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-8 col-xl-7">
            <div class="auth-card">
                <div class="auth-header">
                    <h2 class="auth-title">Iniciar Sesión</h2>
                    <p class="auth-subtitle">Accede a tu cuenta para continuar</p>
                </div>

                <div class="auth-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group">
                            <label for="email" class="form-label">Correo Electrónico</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-envelope"></i>
                                </span>
                                <input id="email" 
                                       type="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       name="email" 
                                       value="{{ old('email') }}" 
                                       required 
                                       autocomplete="email" 
                                       autofocus
                                       placeholder="tu@email.com">
                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password" class="form-label">Contraseña</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-lock"></i>
                                </span>
                                <input id="password" 
                                       type="password" 
                                       class="form-control @error('password') is-invalid @enderror" 
                                       name="password" 
                                       required 
                                       autocomplete="current-password"
                                       placeholder="Tu contraseña">
                                @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       name="remember" 
                                       id="remember" 
                                       {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">
                                    Recordarme
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-gold w-100">
                                <i class="fas fa-sign-in-alt me-2"></i>Iniciar Sesión
                            </button>
                        </div>

                        <div class="divider">
                            <span>o</span>
                        </div>

                        <div class="form-group">
                            <a href="{{ route('auth.google') }}" class="btn btn-google w-100">
                                <i class="fab fa-google me-2"></i>Continuar con Google
                            </a>
                        </div>

                        <div class="auth-links">
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="auth-link">
                                    ¿Olvidaste tu contraseña?
                                </a>
                            @endif
                        </div>
                    </form>
                </div>

                <div class="auth-footer">
                    <p class="text-center">
                        ¿No tienes una cuenta? 
                        <a href="{{ route('register') }}" class="auth-link-primary">Regístrate aquí</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .auth-container {
        min-height: calc(100vh - 200px);
        display: flex;
        align-items: center;
        padding: 2rem 0;
    }

    .auth-card {
        background: var(--white);
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        overflow: hidden;
        border: 1px solid #e9ecef;
        width: 100%;
        display: flex;
        flex-direction: column;
    }

    .auth-header {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
        color: var(--white);
        padding: 2rem;
        text-align: center;
        border-radius: 20px 0 0 20px;
    }

    .auth-title {
        font-family: var(--font-display);
        font-size: 2.5rem;
        font-weight: 600;
        margin-bottom: 1rem;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
    }

    .auth-subtitle {
        opacity: 0.9;
        margin-bottom: 0;
        font-size: 1.2rem;
        line-height: 1.6;
        max-width: 80%;
        margin: 0 auto;
    }

    .auth-body {
        padding: 2rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        font-weight: 600;
        color: var(--primary-color);
        margin-bottom: 0.5rem;
        display: block;
    }

    .auth-body .input-group-text {
        background-color: var(--light-gray);
        border: 1px solid #ddd;
        color: var(--medium-gray);
        width: 45px;
        justify-content: center;
    }

    .auth-body .form-control {
        border: 1px solid #ddd;
        border-left: none;
        padding: 0.75rem 1rem;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .auth-body .form-control:focus {
        border-color: var(--gold);
        box-shadow: 0 0 0 0.2rem rgba(212, 175, 55, 0.25);
    }

    .auth-body .input-group .form-control:focus + .input-group-text,
    .auth-body .input-group-text:has(+ .form-control:focus) {
        border-color: var(--gold);
    }

    .btn-gold {
        background: linear-gradient(135deg, var(--gold) 0%, #b8941f 100%);
        border: none;
        color: var(--white);
        padding: 0.75rem 1.5rem;
        font-size: 1.1rem;
        font-weight: 600;
        border-radius: 10px;
        transition: all 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .btn-gold:hover {
        background: linear-gradient(135deg, #b8941f 0%, var(--gold) 100%);
        color: var(--white);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(212, 175, 55, 0.4);
    }

    .form-check-input:checked {
        background-color: var(--gold);
        border-color: var(--gold);
    }

    .form-check-input:focus {
        border-color: var(--gold);
        box-shadow: 0 0 0 0.2rem rgba(212, 175, 55, 0.25);
    }

    .auth-links {
        text-align: center;
        margin-top: 1rem;
    }

    .auth-link {
        color: var(--medium-gray);
        text-decoration: none;
        font-size: 0.9rem;
        transition: color 0.3s ease;
    }

    .auth-link:hover {
        color: var(--gold);
        text-decoration: underline;
    }

    .auth-footer {
        background-color: var(--light-gray);
        padding: 1.5rem 2rem;
        border-top: 1px solid #e9ecef;
    }

    .auth-link-primary {
        color: var(--gold);
        text-decoration: none;
        font-weight: 600;
        transition: color 0.3s ease;
    }

    .auth-link-primary:hover {
        color: #b8941f;
        text-decoration: underline;
    }

    .divider {
        position: relative;
        text-align: center;
        margin: 1.5rem 0;
    }

    .divider::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 0;
        right: 0;
        height: 1px;
        background-color: #e9ecef;
    }

    .divider span {
        background-color: var(--white);
        padding: 0 1rem;
        color: var(--medium-gray);
        font-size: 0.9rem;
    }

    .btn-google {
        background-color: #4285f4;
        border: none;
        color: var(--white);
        padding: 0.75rem 1.5rem;
        font-size: 1rem;
        font-weight: 500;
        border-radius: 10px;
        transition: all 0.3s ease;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .btn-google:hover {
        background-color: #3367d6;
        color: var(--white);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(66, 133, 244, 0.4);
        text-decoration: none;
    }

    /* Desktop improvements */
    @media (min-width: 992px) {
        .auth-container {
            padding: 3rem 0;
        }

        .auth-card {
            max-width: 1200px;
            margin: 0 auto;
            width: 100%;
            flex-direction: row;
            min-height: 450px;
        }

        .auth-header {
            padding: 2rem;
            flex: 0 0 35%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .auth-body {
            padding: 2rem 3rem;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .auth-footer {
            position: absolute;
            bottom: 0;
            left: 35%;
            right: 0;
            padding: 1.5rem 3rem;
            background-color: var(--light-gray);
            border-top: 1px solid #e9ecef;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .auth-body .form-control {
            padding: 1rem 1.25rem;
            font-size: 1.1rem;
            border-radius: 8px;
        }

        .auth-body .input-group-text {
            width: 55px;
            font-size: 1.1rem;
            border-radius: 8px 0 0 8px;
        }

        .btn-gold, .btn-google {
            padding: 1.2rem 2rem;
            font-size: 1.2rem;
            border-radius: 12px;
            font-weight: 700;
        }

        .btn-gold {
            background: linear-gradient(135deg, var(--gold) 0%, #d4af37 50%, #b8941f 100%);
            box-shadow: 0 4px 15px rgba(212, 175, 55, 0.3);
            position: relative;
            overflow: hidden;
        }

        .btn-gold::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }

        .btn-gold:hover::before {
            left: 100%;
        }

        .btn-google {
            background: linear-gradient(135deg, #4285f4 0%, #34a853 50%, #ea4335 100%);
            box-shadow: 0 4px 15px rgba(66, 133, 244, 0.3);
            position: relative;
            overflow: hidden;
        }

        .btn-google::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }

        .btn-google:hover::before {
            left: 100%;
        }

        /* Ajustar el contenedor del auth-card para posicionamiento relativo */
        .auth-card {
            position: relative;
        }
    }

    @media (min-width: 1200px) {
        .auth-card {
            max-width: 1300px;
        }
    }

    @media (min-width: 1400px) {
        .auth-card {
            max-width: 1400px;
        }
    }

    @media (max-width: 768px) {
        .auth-container {
            padding: 1rem 0;
        }

        .auth-header {
            padding: 1.5rem;
        }

        .auth-title {
            font-size: 1.5rem;
        }

        .auth-body {
            padding: 1.5rem;
        }

        .auth-footer {
            padding: 1rem 1.5rem;
        }
    }
</style>
@endpush
@endsection
