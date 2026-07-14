@extends('layouts.app')
@section('content')
<h2>Bienvenido, {{ auth()->user()->name }}</h2>

<div class="row mt-4">
    <div class="col-md-4">
        <div class="card text-bg-success p-3">
            <h6>Ventas de Hoy</h6>
            <h3>${{ number_format($ventasHoy, 2) }}</h3>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-bg-info p-3">
            <h6>Pedidos de Hoy</h6>
            <h3>{{ $pedidosHoy }}</h3>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-bg-danger p-3">
            <h6>Alerta de Inventario</h6>
            <h3>{{ $productosSinStock->count() }}</h3>
        </div>
    </div>
</div>

@if ($productosSinStock->count() > 0)
<div class="mt-4">
    <h5>Productos sin stock:</h5>
    <ul>
        @foreach ($productosSinStock as $p)
            <li class="text-danger">{{ $p->name }}</li>
        @endforeach
    </ul>
</div>
@endif
@endsection