<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cafechuzo</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<nav class="navbar navbar-dark bg-dark px-3">
    <span class="navbar-brand">☕ Cafechuzo</span>
    <div>
        @auth
            @if (auth()->user()->isAdmin())
                <a href="{{ route('dashboard') }}" class="text-white me-3">Dashboard</a>
                <a href="{{ route('users.index') }}" class="text-white me-3">Usuarios</a>
                <a href="{{ route('categories.index') }}" class="text-white me-3">Categorías</a>
                <a href="{{ route('products.index') }}" class="text-white me-3">Inventario</a>
                <a href="{{ route('reports.index') }}" class="text-white me-3">Reportes</a>
            @endif
            <a href="{{ route('pos.index') }}" class="text-white me-3">POS</a>
            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                @csrf
                <button class="btn btn-sm btn-outline-light">Salir</button>
            </form>
        @endauth
    </div>
</nav>

<div class="container mt-4">
    @yield('content')
</div>
</body>
</html>
