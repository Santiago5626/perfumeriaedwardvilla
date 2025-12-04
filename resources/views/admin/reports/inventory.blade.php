@extends('layouts.app')

@section('title', 'Reporte de Inventario - Edward Villa Perfumería')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Reporte de Inventario</h1>
        <a href="{{ route('admin.productos.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Agregar Producto
        </a>
    </div>

    <!-- Resumen de Inventario -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Productos
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($products->count()) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-box fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Stock Bajo (<10)
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($lowStock) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Sin Stock
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($outOfStock) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-times-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Valor Total Inventario
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                ${{ number_format($products->sum(function($product) { return $product->price * $product->stock; }), 2) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Lista de Productos -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Inventario de Productos</h6>
        </div>
        <div class="card-body">
            @if($products->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Imagen</th>
                                <th>Producto</th>
                                <th>Categoría</th>
                                <th>Precio</th>
                                <th>Stock</th>
                                <th>Total Vendido</th>
                                <th>Valor en Stock</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                                <tr class="{{ $product->stock == 0 ? 'table-danger' : ($product->stock < 10 ? 'table-warning' : '') }}">
                                    <td>
                                        @if($product->image)
                                            <img src="{{ asset('storage/products/' . $product->image) }}" 
                                                 alt="{{ $product->name }}" 
                                                 class="rounded" style="width: 50px; height: 50px; object-fit: cover;">
                                        @else
                                            <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                                                 style="width: 50px; height: 50px;">
                                                <i class="fas fa-image text-muted"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <strong>{{ $product->name }}</strong>
                                        @if($product->size)
                                            <br><small class="text-muted">{{ $product->size }}</small>
                                        @endif
                                    </td>
                                    <td>{{ $product->category->name }}</td>
                                    <td>${{ number_format($product->price, 2) }}</td>
                                    <td>
                                        <span class="badge {{ $product->stock == 0 ? 'bg-danger' : ($product->stock < 10 ? 'bg-warning' : 'bg-success') }}">
                                            {{ $product->stock }}
                                        </span>
                                    </td>
                                    <td>{{ $product->total_sold ?? 0 }}</td>
                                    <td>${{ number_format($product->price * $product->stock, 2) }}</td>
                                    <td>
                                        @if($product->active)
                                            <span class="badge bg-success">Activo</span>
                                        @else
                                            <span class="badge bg-secondary">Inactivo</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.productos.edit', $product) }}" 
                                               class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="{{ route('products.show', $product) }}" 
                                               class="btn btn-sm btn-outline-info" target="_blank">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">No hay productos en el inventario</h5>
                    <p class="text-muted">Comienza agregando tu primer producto.</p>
                    <a href="{{ route('admin.productos.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Agregar Producto
                    </a>
                </div>
            @endif
        </div>
    </div>

    @if($products->count() > 0)
        <!-- Productos con Stock Bajo -->
        @if($lowStock > 0)
            <div class="card shadow mb-4">
                <div class="card-header py-3 bg-warning">
                    <h6 class="m-0 font-weight-bold text-white">
                        <i class="fas fa-exclamation-triangle me-2"></i>Productos con Stock Bajo
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($products->where('stock', '<', 10)->where('stock', '>', 0) as $product)
                            <div class="col-md-6 col-lg-4 mb-3">
                                <div class="card border-warning">
                                    <div class="card-body">
                                        <h6 class="card-title">{{ $product->name }}</h6>
                                        <p class="card-text">
                                            <small class="text-muted">{{ $product->category->name }}</small><br>
                                            <strong>Stock: {{ $product->stock }}</strong>
                                        </p>
                                        <a href="{{ route('admin.productos.edit', $product) }}" class="btn btn-sm btn-warning">
                                            Actualizar Stock
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        <!-- Productos Sin Stock -->
        @if($outOfStock > 0)
            <div class="card shadow mb-4">
                <div class="card-header py-3 bg-danger">
                    <h6 class="m-0 font-weight-bold text-white">
                        <i class="fas fa-times-circle me-2"></i>Productos Sin Stock
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($products->where('stock', 0) as $product)
                            <div class="col-md-6 col-lg-4 mb-3">
                                <div class="card border-danger">
                                    <div class="card-body">
                                        <h6 class="card-title">{{ $product->name }}</h6>
                                        <p class="card-text">
                                            <small class="text-muted">{{ $product->category->name }}</small><br>
                                            <strong class="text-danger">Sin Stock</strong>
                                        </p>
                                        <a href="{{ route('admin.productos.edit', $product) }}" class="btn btn-sm btn-danger">
                                            Reponer Stock
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    @endif
</div>

@push('styles')
<style>
    .border-left-primary { border-left: 0.25rem solid #4e73df !important; }
    .border-left-success { border-left: 0.25rem solid #1cc88a !important; }
    .border-left-info { border-left: 0.25rem solid #36b9cc !important; }
    .border-left-warning { border-left: 0.25rem solid #f6c23e !important; }
    .border-left-danger { border-left: 0.25rem solid #e74a3b !important; }
    .text-xs { font-size: 0.7rem; }
</style>
@endpush
@endsection
