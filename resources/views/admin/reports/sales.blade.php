@extends('layouts.app')

@section('title', 'Reporte de Ventas - Edward Villa Perfumería')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Reporte de Ventas</h1>
    </div>

    <!-- Filtros -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.reports.sales') }}" class="row g-3">
                <div class="col-md-4">
                    <label for="start_date" class="form-label">Fecha Inicio</label>
                    <input type="date" class="form-control" id="start_date" name="start_date" 
                           value="{{ request('start_date', now()->startOfMonth()->format('Y-m-d')) }}">
                </div>
                <div class="col-md-4">
                    <label for="end_date" class="form-label">Fecha Fin</label>
                    <input type="date" class="form-control" id="end_date" name="end_date" 
                           value="{{ request('end_date', now()->endOfMonth()->format('Y-m-d')) }}">
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary">Filtrar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Resumen -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Ventas Totales
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                ${{ number_format($summary['total_sales'], 2) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
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
                                Total Pedidos
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($summary['total_orders']) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-shopping-cart fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Promedio por Pedido
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                ${{ number_format($summary['average_order'], 2) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calculator fa-2x text-gray-300"></i>
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
                                Productos Vendidos
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($summary['products_sold']) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-box fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Lista de Ventas -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Detalle de Ventas</h6>
        </div>
        <div class="card-body">
            @if($sales->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID Pedido</th>
                                <th>Cliente</th>
                                <th>Productos</th>
                                <th>Total</th>
                                <th>Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sales as $sale)
                                <tr>
                                    <td>{{ $sale->id }}</td>
                                    <td>{{ $sale->user->name }}</td>
                                    <td>
                                        <ul class="list-unstyled mb-0">
                                            @foreach($sale->items as $item)
                                                <li>{{ $item->quantity }}x {{ $item->product->name }}</li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td>${{ number_format($sale->total, 2) }}</td>
                                    <td>{{ $sale->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-center text-muted my-5">No hay ventas registradas en el período seleccionado.</p>
            @endif
        </div>
    </div>
</div>

@push('styles')
<style>
    .border-left-primary { border-left: 0.25rem solid #4e73df !important; }
    .border-left-success { border-left: 0.25rem solid #1cc88a !important; }
    .border-left-info { border-left: 0.25rem solid #36b9cc !important; }
    .border-left-warning { border-left: 0.25rem solid #f6c23e !important; }
    .text-xs { font-size: 0.7rem; }
</style>
@endpush
@endsection
