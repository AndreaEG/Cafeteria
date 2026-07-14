@extends('layouts.app')

@section('content')

<style>
    .dashboard-bg {
        position: relative;
        min-height: 100vh;
        padding: 40px 20px;
        background-color: #FAFAF7;
        background-image:
            linear-gradient(135deg, rgba(216, 137, 60, 0.04) 25%, transparent 25%),
            linear-gradient(225deg, rgba(216, 137, 60, 0.04) 25%, transparent 25%),
            linear-gradient(45deg, rgba(90, 141, 108, 0.04) 25%, transparent 25%),
            linear-gradient(315deg, rgba(90, 141, 108, 0.04) 25%, transparent 25%);
        background-position: 40px 0, 40px 0, 0 0, 0 0;
        background-size: 80px 80px;
        border-radius: 12px;
    }

    .page-header {
        margin-bottom: 25px;
        border-left: 5px solid #5A8D6C;
        padding-left: 15px;
    }

    .page-header h2 {
        font-family: 'Segoe UI', system-ui, sans-serif;
        color: #2E3A32;
        font-weight: 700;
        letter-spacing: 0.3px;
        margin: 0;
    }

    .filter-comedor-form {
        background: #FFFFFF;
        border-radius: 12px;
        padding: 18px 20px;
        box-shadow: 0 4px 15px rgba(46, 58, 50, 0.06);
        align-items: center;
    }

    .filter-comedor-form .form-control {
        border: 1px solid #E4E6E1;
        border-radius: 9px;
        padding: 9px 14px;
        color: #2E3A32;
        background-color: #FCFCFA;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .filter-comedor-form .form-control:focus {
        border-color: #5A8D6C;
        box-shadow: 0 0 0 3px rgba(90, 141, 108, 0.12);
        background-color: #FFFFFF;
    }

    .btn-comedor-primary {
        background-color: #5A8D6C;
        border: none;
        color: #fff;
        font-weight: 600;
        padding: 9px 22px;
        border-radius: 9px;
        transition: background-color 0.2s ease, transform 0.2s ease;
    }

    .btn-comedor-primary:hover {
        background-color: #4A7A5A;
        color: #fff;
        transform: translateY(-2px);
    }

    .summary-card {
        border: none;
        border-radius: 14px;
        padding: 24px;
        background: #FFFFFF;
        box-shadow: 0 4px 15px rgba(46, 58, 50, 0.07);
        opacity: 0;
        animation: fadeInUp 0.5s ease forwards;
    }

    .summary-card:nth-child(1) { animation-delay: 0.05s; }
    .summary-card:nth-child(2) { animation-delay: 0.15s; }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(12px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .summary-card h5 {
        color: #8A8F86;
        font-size: 0.78rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 10px;
        font-weight: 600;
    }

    .summary-card h2 {
        color: #2E3A32;
        font-weight: 700;
        margin: 0;
    }

    .card-ventas-report  { border-left: 4px solid #5A8D6C; }
    .card-ganancia-report { border-left: 4px solid #D8893C; }

    .table-comedor-wrapper {
        background: #FFFFFF;
        border-radius: 14px;
        padding: 10px;
        box-shadow: 0 4px 15px rgba(46, 58, 50, 0.07);
        opacity: 0;
        animation: fadeInUp 0.5s ease forwards;
        animation-delay: 0.25s;
    }

    .table-comedor {
        margin-bottom: 0;
    }

    .table-comedor thead th {
        background-color: #F4F6F3;
        color: #5C6B5F;
        font-size: 0.78rem;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        border: none;
        padding: 14px 16px;
    }

    .table-comedor tbody td {
        padding: 14px 16px;
        vertical-align: middle;
        color: #2E3A32;
        border-color: #F0F1EE;
    }

    .table-comedor tbody tr {
        transition: background-color 0.2s ease;
    }

    .table-comedor tbody tr:hover {
        background-color: #FAF9F4;
    }
</style>

<div class="dashboard-bg">

    <div class="page-header">
        <h2>Reporte de Ganancias</h2>
    </div>

    <form method="GET" class="row g-3 mb-4 filter-comedor-form">
        <div class="col-auto">
            <input type="date" name="from" value="{{ $from }}" class="form-control">
        </div>
        <div class="col-auto">
            <input type="date" name="to" value="{{ $to }}" class="form-control">
        </div>
        <div class="col-auto">
            <button class="btn-comedor-primary">Filtrar</button>
        </div>
    </form>

    <div class="row mb-4 g-3">
        <div class="col-md-6">
            <div class="summary-card card-ventas-report">
                <h5>Ventas totales</h5>
                <h2>${{ number_format($totalVentas, 2) }}</h2>
            </div>
        </div>
        <div class="col-md-6">
            <div class="summary-card card-ganancia-report">
                <h5>Ganancia neta</h5>
                <h2>${{ number_format($totalGanancia, 2) }}</h2>
            </div>
        </div>
    </div>

    <div class="table-comedor-wrapper">
        <table class="table table-comedor">
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
    </div>

</div>

@endsection