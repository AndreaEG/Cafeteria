<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cafechuzo</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Segoe UI', system-ui, sans-serif;
            background-color: #FAFAF7;
        }

        .navbar-comedor {
            background-color: #2E3A32;
            padding: 14px 28px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.12);
        }

        .navbar-comedor .navbar-brand {
            color: #F7F9F6 !important;
            font-weight: 700;
            font-size: 1.15rem;
            letter-spacing: 0.3px;
        }

        .navbar-comedor .nav-link-comedor {
            color: #DCE3DE;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            padding: 8px 14px;
            border-radius: 8px;
            transition: background-color 0.2s ease, color 0.2s ease;
        }

        .navbar-comedor .nav-link-comedor:hover {
            background-color: rgba(255, 255, 255, 0.08);
            color: #FFFFFF;
        }

        .btn-salir-comedor {
            background-color: transparent;
            border: 1px solid rgba(255, 255, 255, 0.35);
            color: #F7F9F6;
            font-size: 0.85rem;
            font-weight: 500;
            padding: 6px 16px;
            border-radius: 8px;
            transition: background-color 0.2s ease, border-color 0.2s ease;
        }

        .btn-salir-comedor:hover {
            background-color: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.6);
            color: #fff;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-dark navbar-comedor d-flex justify-content-between">
    <span class="navbar-brand">🍽️ Cafechuzo</span>
    <div class="d-flex align-items-center">
        @auth
            @if (auth()->user()->isAdmin())
                <a href="{{ route('dashboard') }}" class="nav-link-comedor">Dashboard</a>
                <a href="{{ route('users.index') }}" class="nav-link-comedor">Usuarios</a>
                <a href="{{ route('products.index') }}" class="nav-link-comedor">Inventario</a>
                <a href="{{ route('reports.index') }}" class="nav-link-comedor">Reportes</a>
            @endif
            <a href="{{ route('pos.index') }}" class="nav-link-comedor">POS</a>
            <form action="{{ route('logout') }}" method="POST" class="d-inline ms-2">
                @csrf
                <button class="btn-salir-comedor">Salir</button>
            </form>
        @endauth
    </div>
</nav>

<div class="container mt-4">
    @yield('content')
</div>
</body>
</html>