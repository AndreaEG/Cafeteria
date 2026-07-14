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

    .welcome-title {
        font-family: 'Segoe UI', system-ui, sans-serif;
        color: #2E3A32;
        font-weight: 700;
        letter-spacing: 0.3px;
        margin-bottom: 30px;
        border-left: 5px solid #5A8D6C;
        padding-left: 15px;
    }

    .dash-card {
        border: none;
        border-radius: 14px;
        padding: 24px;
        background: #FFFFFF;
        box-shadow: 0 4px 15px rgba(46, 58, 50, 0.07);
        transition: transform 0.25s ease, box-shadow 0.25s ease;
        opacity: 0;
        animation: fadeInUp 0.5s ease forwards;
    }

    .dash-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 20px rgba(46, 58, 50, 0.12);
    }

    .dash-card:nth-child(1) { animation-delay: 0.05s; }
    .dash-card:nth-child(2) { animation-delay: 0.15s; }
    .dash-card:nth-child(3) { animation-delay: 0.25s; }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(12px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .dash-card h6 {
        color: #8A8F86;
        font-size: 0.78rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 8px;
    }

    .dash-card h3 {
        color: #2E3A32;
        font-weight: 700;
        margin: 0;
    }

    .card-ventas  { border-left: 4px solid #5A8D6C; }
    .card-pedidos { border-left: 4px solid #D8893C; }
    .card-alerta  { border-left: 4px solid #C0625A; }

    .stock-alert {
        background: #FFF6F5;
        border: 1px solid #F1D2CE;
        border-radius: 12px;
        padding: 20px 24px;
        margin-top: 30px;
        opacity: 0;
        animation: fadeInUp 0.5s ease forwards;
        animation-delay: 0.35s;
    }

    .stock-alert h5 {
        color: #B04A3F;
        font-weight: 600;
        margin-bottom: 12px;
        font-size: 1rem;
    }

    .stock-alert ul {
        list-style: none;
        padding-left: 0;
        margin: 0;
    }

    .stock-alert li {
        padding: 6px 0;
        color: #A8433A;
        border-bottom: 1px dashed #F1D2CE;
    }

    .stock-alert li:last-child {
        border-bottom: none;
    }
</style>

<div class="dashboard-bg">

    <h2 class="welcome-title">Bienvenido, {{ auth()->user()->name }}</h2>

    <div class="row mt-4 g-3">
        <div class="col-md-4">
            <div class="dash-card card-ventas">
                <h6>Ventas de Hoy</h6>
                <h3>${{ number_format($ventasHoy, 2) }}</h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="dash-card card-pedidos">
                <h6>Pedidos de Hoy</h6>
                <h3>{{ $pedidosHoy }}</h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="dash-card card-alerta">
                <h6>Alerta de Inventario</h6>
                <h3>{{ $productosSinStock->count() }}</h3>
            </div>
        </div>
    </div>

    @if ($productosSinStock->count() > 0)
    <div class="stock-alert">
        <h5>⚠ Productos sin stock:</h5>
        <ul>
            @foreach ($productosSinStock as $p)
                <li>{{ $p->name }}</li>
            @endforeach
        </ul>
    </div>
    @endif

</div>

@endsection