@extends('layouts.app')

@section('title', '¡Pedido Completado! - Edward Villa Perfumería')
@section('description', 'Tu pedido ha sido procesado exitosamente.')

@section('content')
<div class="success-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center p-5">
                        <!-- Success Icon -->
                        <div class="success-icon mb-4">
                            <i class="fas fa-check-circle text-success"></i>
                        </div>

                        <!-- Success Message -->
                        <h1 class="success-title mb-4">¡Gracias por tu compra!</h1>
                        <p class="success-message mb-4">
                            Tu pedido ha sido procesado exitosamente.<br>
                            Te hemos enviado un correo electrónico con los detalles de tu compra.
                        </p>

                        <!-- Order Details -->
                        <div class="order-details text-start mb-4">
                            <h5 class="fw-bold mb-3">Detalles del Pedido:</h5>
                            <div class="row">
                                <div class="col-sm-6">
                                    <p class="mb-1"><strong>Número de Pedido:</strong></p>
                                    <p class="text-muted">#{{ $order->id }}</p>
                                </div>
                                <div class="col-sm-6">
                                    <p class="mb-1"><strong>Fecha:</strong></p>
                                    <p class="text-muted">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-sm-6">
                                    <p class="mb-1"><strong>Total:</strong></p>
                                    <p class="text-primary fw-bold">${{ number_format($order->total, 2) }}</p>
                                </div>
                                <div class="col-sm-6">
                                    <p class="mb-1"><strong>Estado:</strong></p>
                                    <span class="badge bg-success">Pagado</span>
                                </div>
                            </div>
                        </div>

                        <!-- Shipping Information -->
                        <div class="shipping-info text-start mb-4">
                            <h5 class="fw-bold mb-3">Información de Envío:</h5>
                            <p class="mb-1">{{ $order->first_name }} {{ $order->last_name }}</p>
                            <p class="mb-1">{{ $order->address }}</p>
                            <p class="mb-1">{{ $order->city }}, {{ $order->state }}</p>
                            <p class="mb-1">{{ $order->country }}</p>
                            @if($order->postal_code)
                                <p class="mb-1">{{ $order->postal_code }}</p>
                            @endif
                        </div>

                        <!-- Next Steps -->
                        <div class="next-steps mb-4">
                            <h5 class="fw-bold mb-3">Próximos Pasos:</h5>
                            <div class="row g-4">
                                <div class="col-md-4">
                                    <div class="step-card">
                                        <div class="step-icon mb-3">
                                            <i class="fas fa-box text-primary"></i>
                                        </div>
                                        <h6 class="step-title">Preparación</h6>
                                        <p class="step-description small text-muted">
                                            Estamos preparando tu pedido para envío
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="step-card">
                                        <div class="step-icon mb-3">
                                            <i class="fas fa-truck text-primary"></i>
                                        </div>
                                        <h6 class="step-title">Envío</h6>
                                        <p class="step-description small text-muted">
                                            Recibirás actualizaciones del estado de envío
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="step-card">
                                        <div class="step-icon mb-3">
                                            <i class="fas fa-home text-primary"></i>
                                        </div>
                                        <h6 class="step-title">Entrega</h6>
                                        <p class="step-description small text-muted">
                                            Tu pedido llegará en 3-5 días hábiles
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="action-buttons">
                            <a href="{{ route('orders.show', $order) }}" class="btn btn-primary-custom btn-lg mb-3">
                                <i class="fas fa-file-alt me-2"></i>Ver Detalles del Pedido
                            </a>
                            <br>
                            <a href="{{ route('products.index') }}" class="btn btn-outline-dark">
                                <i class="fas fa-arrow-left me-2"></i>Continuar Comprando
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Support Information -->
                <div class="support-info text-center mt-4">
                    <p class="mb-2">¿Necesitas ayuda con tu pedido?</p>
                    <p class="mb-0">
                        <i class="fas fa-envelope me-2"></i>
                        <a href="mailto:soporte@edwardvillaperfumeria.com" class="text-decoration-none">
                            soporte@edwardvillaperfumeria.com
                        </a>
                    </p>
                    <p class="mb-0">
                        <i class="fas fa-phone me-2"></i>
                        <a href="tel:+573184812707" class="text-decoration-none">
                            +57 318 4812707
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .success-container {
        padding: 4rem 0;
        background-color: var(--light-gray);
        min-height: calc(100vh - 200px);
    }

    .success-icon {
        font-size: 5rem;
        color: #28a745;
        animation: scaleIn 0.5s ease-in-out;
    }

    .success-title {
        font-family: var(--font-display);
        color: var(--primary-color);
        font-size: 2.5rem;
        font-weight: 600;
    }

    .success-message {
        font-size: 1.2rem;
        color: var(--medium-gray);
    }

    .step-card {
        padding: 1.5rem;
        background: white;
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
    }

    .step-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    }

    .step-icon {
        font-size: 2rem;
        color: var(--primary-color);
    }

    .step-title {
        font-weight: 600;
        color: var(--primary-color);
        margin-bottom: 0.5rem;
    }

    .support-info a {
        color: var(--primary-color);
        transition: color 0.3s ease;
    }

    .support-info a:hover {
        color: var(--gold);
    }

    @keyframes scaleIn {
        0% {
            transform: scale(0);
            opacity: 0;
        }
        100% {
            transform: scale(1);
            opacity: 1;
        }
    }

    @media (max-width: 768px) {
        .success-container {
            padding: 2rem 0;
        }

        .success-title {
            font-size: 2rem;
        }

        .success-message {
            font-size: 1rem;
        }

        .step-card {
            margin-bottom: 1rem;
        }
    }
</style>
@endpush
@endsection
