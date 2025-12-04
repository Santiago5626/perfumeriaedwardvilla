@extends('layouts.app')

@section('title', 'Gestión de Pedidos - Edward Villa Perfumería')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Gestión de Pedidos</h1>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Volver al Dashboard
        </a>
    </div>

    <!-- Filtros -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-3">
                    <label for="status" class="form-label">Estado</label>
                    <select name="status" id="status" class="form-select">
                        <option value="">Todos los estados</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pendiente</option>
                        <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Procesando</option>
                        <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Enviado</option>
                        <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Entregado</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelado</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="date_from" class="form-label">Desde</label>
                    <input type="date" name="date_from" id="date_from" class="form-control" value="{{ request('date_from') }}">
                </div>
                <div class="col-md-3">
                    <label for="date_to" class="form-label">Hasta</label>
                    <input type="date" name="date_to" id="date_to" class="form-control" value="{{ request('date_to') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search me-2"></i>Filtrar
                        </button>
                        <a href="{{ route('admin.pedidos.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-2"></i>Limpiar
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Lista de Pedidos -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Lista de Pedidos ({{ $orders->total() }} total)</h5>
        </div>
        <div class="card-body p-0">
            @if($orders->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Cliente</th>
                                <th>Fecha</th>
                                <th>Total</th>
                                <th>Estado</th>
                                <th>Productos</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <td>
                                        <strong>#{{ $order->id }}</strong>
                                    </td>
                                    <td>
                                        <div>
                                            <strong>{{ $order->user->name }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $order->user->email }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            {{ $order->created_at->format('d/m/Y') }}
                                            <br>
                                            <small class="text-muted">{{ $order->created_at->format('H:i') }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <strong>${{ number_format($order->total, 2) }}</strong>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $order->status == 'pending' ? 'warning' : ($order->status == 'processing' ? 'info' : ($order->status == 'shipped' ? 'primary' : ($order->status == 'delivered' ? 'success' : 'danger'))) }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <small>
                                            {{ $order->items->count() }} producto(s)
                                            <br>
                                            {{ $order->items->sum('quantity') }} unidad(es)
                                        </small>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#orderModal{{ $order->id }}">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <form action="{{ route('admin.pedidos.updateStatus', $order) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('PATCH')
                                                            <input type="hidden" name="status" value="pending">
                                                            <button type="submit" class="dropdown-item">
                                                                <i class="fas fa-clock text-warning me-2"></i>Pendiente
                                                            </button>
                                                        </form>
                                                    </li>
                                                    <li>
                                                        <form action="{{ route('admin.pedidos.updateStatus', $order) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('PATCH')
                                                            <input type="hidden" name="status" value="processing">
                                                            <button type="submit" class="dropdown-item">
                                                                <i class="fas fa-cog text-info me-2"></i>Procesando
                                                            </button>
                                                        </form>
                                                    </li>
                                                    <li>
                                                        <form action="{{ route('admin.pedidos.updateStatus', $order) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('PATCH')
                                                            <input type="hidden" name="status" value="shipped">
                                                            <button type="submit" class="dropdown-item">
                                                                <i class="fas fa-shipping-fast text-primary me-2"></i>Enviado
                                                            </button>
                                                        </form>
                                                    </li>
                                                    <li>
                                                        <form action="{{ route('admin.pedidos.updateStatus', $order) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('PATCH')
                                                            <input type="hidden" name="status" value="delivered">
                                                            <button type="submit" class="dropdown-item">
                                                                <i class="fas fa-check text-success me-2"></i>Entregado
                                                            </button>
                                                        </form>
                                                    </li>
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li>
                                                        <form action="{{ route('admin.pedidos.updateStatus', $order) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('PATCH')
                                                            <input type="hidden" name="status" value="cancelled">
                                                            <button type="submit" class="dropdown-item text-danger">
                                                                <i class="fas fa-times text-danger me-2"></i>Cancelar
                                                            </button>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Modal para ver detalles del pedido -->
                                <div class="modal fade" id="orderModal{{ $order->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Detalles del Pedido #{{ $order->id }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <h6>Información del Cliente</h6>
                                                        <p><strong>Nombre:</strong> {{ $order->user->name }}</p>
                                                        <p><strong>Email:</strong> {{ $order->user->email }}</p>
                                                        <p><strong>Teléfono:</strong> {{ $order->phone }}</p>
                                                        <p><strong>Dirección:</strong> {{ $order->shipping_address }}</p>
                                                        @if($order->notes)
                                                            <p><strong>Notas:</strong> {{ $order->notes }}</p>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-6">
                                                        <h6>Información del Pedido</h6>
                                                        <p><strong>Fecha:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
                                                        <p><strong>Estado:</strong> 
                                                            <span class="badge bg-{{ $order->status == 'pending' ? 'warning' : ($order->status == 'processing' ? 'info' : ($order->status == 'shipped' ? 'primary' : ($order->status == 'delivered' ? 'success' : 'danger'))) }}">
                                                                {{ ucfirst($order->status) }}
                                                            </span>
                                                        </p>
                                                        <p><strong>Total:</strong> ${{ number_format($order->total, 2) }}</p>
                                                    </div>
                                                </div>
                                                
                                                <h6 class="mt-4">Productos</h6>
                                                <div class="table-responsive">
                                                    <table class="table table-sm">
                                                        <thead>
                                                            <tr>
                                                                <th>Producto</th>
                                                                <th>Cantidad</th>
                                                                <th>Precio</th>
                                                                <th>Subtotal</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($order->items as $item)
                                                                <tr>
                                                                    <td>{{ $item->product->name }}</td>
                                                                    <td>{{ $item->quantity }}</td>
                                                                    <td>${{ number_format($item->price, 2) }}</td>
                                                                    <td>${{ number_format($item->price * $item->quantity, 2) }}</td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <th colspan="3">Total</th>
                                                                <th>${{ number_format($order->total, 2) }}</th>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">No hay pedidos</h5>
                    <p class="text-muted">No se encontraron pedidos con los filtros aplicados.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Paginación -->
    @if($orders->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $orders->links() }}
        </div>
    @endif
</div>

@push('styles')
<style>
    .table th {
        border-top: none;
        font-weight: 600;
        color: #495057;
    }
    
    .btn-group .dropdown-toggle::after {
        margin-left: 0.255em;
    }
    
    .modal-body h6 {
        color: #495057;
        font-weight: 600;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 1px solid #dee2e6;
    }
</style>
@endpush
@endsection
