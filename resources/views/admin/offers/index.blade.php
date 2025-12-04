@extends('layouts.app')

@section('title', 'Gestión de Ofertas - Edward Villa Perfumería')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Gestión de Ofertas</h1>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Volver al Dashboard
            </a>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createOfferModal">
                <i class="fas fa-plus me-2"></i>Nueva Oferta
            </button>
        </div>
    </div>

    <!-- Tabla de ofertas -->
    <div class="card shadow">
        <div class="card-header">
            <h6 class="m-0 font-weight-bold text-primary">Ofertas Registradas</h6>
        </div>
        <div class="card-body">
            @if($offers->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Precio Original</th>
                                <th>Descuento</th>
                                <th>Precio Final</th>
                                <th>Fecha Inicio</th>
                                <th>Fecha Fin</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($offers as $offer)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($offer->product->image)
                                                <img src="{{ asset('storage/products/' . $offer->product->image) }}" 
                                                     alt="{{ $offer->product->name }}" 
                                                     class="rounded me-2" style="width: 40px; height: 40px; object-fit: cover;">
                                            @else
                                                <div class="bg-light rounded me-2 d-flex align-items-center justify-content-center" 
                                                     style="width: 40px; height: 40px;">
                                                    <i class="fas fa-image text-muted"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <div class="fw-bold">{{ $offer->product->name }}</div>
                                                <small class="text-muted">{{ $offer->product->category->name }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>${{ number_format($offer->product->price, 2) }}</td>
                                    <td>
                                        <span class="badge bg-success">{{ $offer->discount_percentage }}%</span>
                                    </td>
                                    <td class="fw-bold text-success">${{ number_format($offer->final_price, 2) }}</td>
                                    <td>{{ $offer->start_date->format('d/m/Y') }}</td>
                                    <td>{{ $offer->end_date->format('d/m/Y') }}</td>
                                    <td>
                                        @if($offer->isValid())
                                            <span class="badge bg-success">Activa</span>
                                        @elseif($offer->end_date < now())
                                            <span class="badge bg-danger">Expirada</span>
                                        @elseif($offer->start_date > now())
                                            <span class="badge bg-warning">Programada</span>
                                        @else
                                            <span class="badge bg-secondary">Inactiva</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            @if($offer->active && $offer->end_date >= now())
                                                <button type="button" class="btn btn-sm btn-outline-primary" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#editOfferModal{{ $offer->id }}">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <form action="{{ route('admin.offers.deactivate', $offer) }}" 
                                                      method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                                            onclick="return confirm('¿Desactivar esta oferta?')">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>

                                <!-- Modal para editar oferta -->
                                <div class="modal fade" id="editOfferModal{{ $offer->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Editar Oferta</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <form action="{{ route('admin.offers.update', $offer) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label class="form-label">Producto</label>
                                                        <input type="text" class="form-control" 
                                                               value="{{ $offer->product->name }}" readonly>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="discount_percentage" class="form-label">Porcentaje de Descuento (%)</label>
                                                        <input type="number" class="form-control" 
                                                               name="discount_percentage" 
                                                               value="{{ $offer->discount_percentage }}" 
                                                               min="1" max="99" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="end_date" class="form-label">Fecha de Fin</label>
                                                        <input type="datetime-local" class="form-control" 
                                                               name="end_date" 
                                                               value="{{ $offer->end_date->format('Y-m-d\TH:i') }}" 
                                                               required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="description" class="form-label">Descripción</label>
                                                        <textarea class="form-control" name="description" rows="3">{{ $offer->description }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                    <button type="submit" class="btn btn-primary">Actualizar Oferta</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Paginación -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $offers->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-tags text-muted mb-3" style="font-size: 4rem;"></i>
                    <h4 class="text-muted">No hay ofertas registradas</h4>
                    <p class="text-muted">Crea tu primera oferta para atraer más clientes.</p>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createOfferModal">
                        <i class="fas fa-plus me-2"></i>Crear Primera Oferta
                    </button>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal para crear oferta -->
<div class="modal fade" id="createOfferModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nueva Oferta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.offers.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="product_id" class="form-label">Producto</label>
                        <select class="form-select" name="product_id" required>
                            <option value="">Seleccionar producto...</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}">
                                    {{ $product->name }} - ${{ number_format($product->price, 2) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="discount_percentage" class="form-label">Porcentaje de Descuento (%)</label>
                        <input type="number" class="form-control" name="discount_percentage" 
                               min="1" max="99" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="start_date" class="form-label">Fecha de Inicio</label>
                                <input type="datetime-local" class="form-control" name="start_date" 
                                       value="{{ now()->format('Y-m-d\TH:i') }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="end_date" class="form-label">Fecha de Fin</label>
                                <input type="datetime-local" class="form-control" name="end_date" 
                                       value="{{ now()->addDays(7)->format('Y-m-d\TH:i') }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Descripción (Opcional)</label>
                        <textarea class="form-control" name="description" rows="3" 
                                  placeholder="Describe la oferta..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Crear Oferta</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
