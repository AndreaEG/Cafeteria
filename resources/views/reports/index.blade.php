@extends('layouts.app')
@section('content')
<h2>Reporte de Ganancias</h2>

<form method="GET" class="row g-3 mb-4">
    <div class="col-auto">
        <input type="date" name="from" value="{{ $from }}" class="form-control">
    </div>
    <div class="col-auto">
        <input type="date" name="to" value="{{ $to }}" class="form-control">
    </div>
    <div class="col-auto">
        <button class="btn btn-primary">Filtrar</button>
    </div>
</form>

<div class="row mb-4">
    <div class="col-md-6">
        <div class="card text-bg-success p-3">
            <h5>Ventas totales</h5>
            <h2>${{ number_format($totalVentas, 2) }}</h2>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card text-bg-primary p-3">
            <h5>Ganancia neta</h5>
            <h2>${{ number_format($totalGanancia, 2) }}</h2>
        </div>
    </div>
</div>

<table class="table">
    <thead><tr><th>Fecha</th><th>Cajero</th><th>Total</th></tr></thead>
    <tbody>
        @foreach ($sales as $sale)
        <tr>
            <td>{{ $sale->created_at->format('d/m/Y H:i') }}</td>
            <td>{{ $sale->user->name }}</td>
            <td>${{ number_format($sale->total, 2) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection