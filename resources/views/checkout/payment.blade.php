@extends('layouts.app')

@section('title', 'Pago - Edward Villa Perfumería')
@section('description', 'Completa tu pago de forma segura con Mercado Pago.')

@section('content')
<div class="checkout-container">
    <!-- Progress Steps -->
    <div class="checkout-progress mb-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="progress-steps">
                        <a href="{{ route('cart.index') }}" class="step completed">
                            <div class="step-number">1</div>
                            <div class="step-label">Carrito</div>
                        </a>
                        <div class="step-line completed"></div>
                        <a href="{{ route('checkout.shipping') }}" class="step completed">
                            <div class="step-number">2</div>
                            <div class="step-label">Envío</div>
                        </a>
                        <div class="step-line completed"></div>
                        <a href="{{ route('checkout.confirm') }}" class="step completed">
                            <div class="step-number">3</div>
                            <div class="step-label">Confirmar</div>
                        </a>
                        <div class="step-line completed"></div>
                        <div class="step active">
                            <div class="step-number">4</div>
                            <div class="step-label">Pago</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Payment Form -->
        <div class="col-lg-8">
            <div class="payment-container">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0">
                        <h3 class="mb-0 fw-bold">
                            <i class="fas fa-credit-card me-2 text-primary"></i>
                            Pago Seguro
                        </h3>
                        <p class="text-muted mb-0 mt-2">Completa tu pago de forma segura con Mercado Pago</p>
                    </div>
                    <div class="card-body p-4">
                        <!-- Mercado Pago Button -->
                        <div id="mercadopago-button-container" class="text-center">
                            <!-- El botón de Mercado Pago se cargará aquí -->
                        </div>
                        
                        <!-- Loading State -->
                        <div id="payment-loading" class="text-center py-5">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Cargando...</span>
                            </div>
                            <p class="mt-3 text-muted">Preparando el formulario de pago...</p>
                        </div>
                        
                        <!-- Error State -->
                        <div id="payment-error" class="alert alert-danger d-none">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <span id="error-message">Hubo un error al cargar el formulario de pago. Por favor, recarga la página.</span>
                        </div>
                        
                        <!-- Back Button -->
                        <div class="mt-4">
                            <a href="{{ route('checkout.shipping') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Volver a Información de Envío
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Security Information -->
                <div class="security-info mt-4">
                    <div class="card border-0 bg-light">
                        <div class="card-body">
                            <h6 class="fw-bold mb-3">
                                <i class="fas fa-shield-alt text-success me-2"></i>
                                Tu pago está protegido
                            </h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <ul class="list-unstyled mb-0">
                                        <li class="mb-2">
                                            <i class="fas fa-check text-success me-2"></i>
                                            Encriptación SSL de 256 bits
                                        </li>
                                        <li class="mb-2">
                                            <i class="fas fa-check text-success me-2"></i>
                                            Procesado por Mercado Pago
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <ul class="list-unstyled mb-0">
                                        <li class="mb-2">
                                            <i class="fas fa-check text-success me-2"></i>
                                            Cumple con PCI DSS
                                        </li>
                                        <li class="mb-2">
                                            <i class="fas fa-check text-success me-2"></i>
                                            Datos protegidos
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="col-lg-4">
            <div class="order-summary-container">
                <div class="card border-0 shadow-sm sticky-top">
                    <div class="card-header bg-white border-0">
                        <h5 class="mb-0 fw-bold">Resumen del Pedido</h5>
                    </div>
                    <div class="card-body">
                        <!-- Order Details -->
                        <div class="order-details mb-3">
                            <h6 class="fw-bold">Pedido #{{ $order->id }}</h6>
                            <p class="text-muted mb-2">{{ $order->items->count() }} productos</p>
                        </div>
                        
                        <!-- Shipping Information -->
                        <div class="shipping-info mb-3">
                            <h6 class="fw-bold">Envío a:</h6>
                            <p class="mb-1">{{ $order->first_name }} {{ $order->last_name }}</p>
                            <p class="text-muted mb-0">
                                {{ $order->address }}<br>
                                {{ $order->city }}, {{ $order->state }}<br>
                                {{ $order->country }}
                                @if($order->postal_code)
                                    {{ $order->postal_code }}
                                @endif
                            </p>
                        </div>
                        
                        <hr>
                        
                        <!-- Summary Totals -->
                        <div class="summary-row">
                            <span>Subtotal</span>
                            <span class="fw-bold">${{ number_format($order->subtotal, 2) }}</span>
                        </div>
                        
                        <div class="summary-row">
                            <span>Envío</span>
                            <span class="text-success">
                                @if($order->shipping == 0)
                                    Gratis
                                @else
                                    ${{ number_format($order->shipping, 2) }}
                                @endif
                            </span>
                        </div>
                        
                        <hr>
                        
                        <div class="summary-total">
                            <span class="fw-bold fs-5">Total a Pagar</span>
                            <span class="fw-bold fs-5 text-primary">
                                ${{ number_format($order->total, 2) }}
                            </span>
                        </div>
                    </div>
                </div>
                
                <!-- Payment Methods -->
                <div class="payment-methods mt-4">
                    <div class="card border-0 bg-light">
                        <div class="card-body text-center">
                            <h6 class="fw-bold mb-3">Métodos de Pago Aceptados</h6>
                            <div class="payment-icons">
                                <i class="fab fa-cc-visa text-primary me-2" style="font-size: 2rem;"></i>
                                <i class="fab fa-cc-mastercard text-warning me-2" style="font-size: 2rem;"></i>
                                <i class="fab fa-cc-amex text-info me-2" style="font-size: 2rem;"></i>
                                <i class="fas fa-university text-success" style="font-size: 2rem;"></i>
                            </div>
                            <small class="text-muted d-block mt-2">
                                Tarjetas de crédito, débito y transferencias bancarias
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .checkout-container {
        padding: 2rem 0;
    }

    /* Progress Steps */
    .progress-steps {
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 2rem;
        padding: 1rem;
        background: white;
        border-radius: 15px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }

    .step {
        display: flex;
        flex-direction: column;
        align-items: center;
        position: relative;
        flex: 1;
        text-align: center;
        padding: 0 1rem;
        text-decoration: none;
        cursor: pointer;
    }

    .step:hover {
        text-decoration: none;
    }

    .step.completed:hover .step-number {
        transform: scale(1.1);
    }

    .step.completed:hover .step-label {
        color: var(--primary-color);
    }

    .step-number {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: #e9ecef;
        color: #6c757d;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        margin-bottom: 0.5rem;
        transition: all 0.3s ease;
        position: relative;
        z-index: 2;
    }

    .step.active .step-number {
        background-color: var(--primary-color);
        color: white;
        transform: scale(1.1);
    }

    .step.completed .step-number {
        background-color: var(--gold);
        color: white;
    }

    .step-label {
        font-size: 0.9rem;
        color: #6c757d;
        font-weight: 500;
        white-space: nowrap;
    }

    .step.active .step-label {
        color: var(--primary-color);
        font-weight: 600;
    }

    .step.completed .step-label {
        color: var(--gold);
        font-weight: 600;
    }

    .step-line {
        position: absolute;
        top: 20px;
        left: calc(50% + 30px);
        right: calc(50% - 30px);
        height: 2px;
        background-color: #e9ecef;
        z-index: 1;
    }

    .step-line.completed {
        background-color: var(--gold);
    }

    #mercadopago-button-container {
        min-height: 200px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }

    .summary-total {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .payment-icons i {
        transition: transform 0.3s ease;
    }

    .payment-icons i:hover {
        transform: scale(1.1);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .checkout-container {
            padding: 0.5rem 0;
        }

        .progress-steps {
            padding: 0.5rem;
            margin-bottom: 1rem;
        }

        .step {
            padding: 0 0.25rem;
        }

        .step-number {
            width: 30px;
            height: 30px;
            font-size: 0.8rem;
        }

        .step-label {
            font-size: 0.7rem;
        }

        .payment-icons i {
            font-size: 1.5rem !important;
            margin: 0 0.25rem;
        }
    }
</style>
@endpush

@push('scripts')
<!-- Mercado Pago SDK -->
<script src="https://sdk.mercadopago.com/js/v2"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const preferenceId = '{{ $preference->id ?? '' }}';
        
        if (!preferenceId) {
            showPaymentError('Error al obtener la preferencia de pago');
            return;
        }

        try {
            // Inicializar Mercado Pago
            const mp = new MercadoPago('{{ config("services.mercadopago.public_key") }}', {
                locale: 'es-CO'
            });

            // Ocultar loading
            document.getElementById('payment-loading').style.display = 'none';

            // Crear botón de pago
            mp.checkout({
                preference: {
                    id: preferenceId
                },
                render: {
                    container: '#mercadopago-button-container',
                    label: 'Pagar con Mercado Pago',
                }
            });

        } catch (error) {
            console.error('Error inicializando Mercado Pago:', error);
            showPaymentError('Error al cargar el formulario de pago. Por favor, recarga la página.');
        }

        function showPaymentError(message) {
            document.getElementById('payment-loading').style.display = 'none';
            document.getElementById('error-message').textContent = message;
            document.getElementById('payment-error').classList.remove('d-none');
        }
    });
</script>
@endpush
@endsection
