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

    .alert-comedor-success {
        background: #F0F7F1;
        border: 1px solid #C9E3CE;
        color: #3F6B4B;
        border-radius: 10px;
        padding: 14px 18px;
        font-weight: 500;
    }

    .alert-comedor-danger {
        background: #FDF0EF;
        border: 1px solid #F1D2CE;
        color: #B04A3F;
        border-radius: 10px;
        padding: 14px 18px;
        font-weight: 500;
    }

    .new-category-card {
        border: none;
        border-radius: 14px;
        background: #FFFFFF;
        box-shadow: 0 4px 15px rgba(46, 58, 50, 0.07);
        padding: 26px;
        margin-bottom: 25px;
        opacity: 0;
        animation: fadeInUp 0.5s ease forwards;
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(12px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .new-category-card h5 {
        color: #2E3A32;
        font-weight: 700;
        font-size: 0.95rem;
        margin-bottom: 16px;
    }

    .new-category-card .form-control,
    .new-category-card .form-select {
        border: 1px solid #E4E6E1;
        border-radius: 9px;
        padding: 10px 14px;
        color: #2E3A32;
        background-color: #FCFCFA;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .new-category-card .form-control:focus,
    .new-category-card .form-select:focus {
        border-color: #5A8D6C;
        box-shadow: 0 0 0 3px rgba(90, 141, 108, 0.12);
        background-color: #FFFFFF;
    }

    .btn-comedor-primary {
        background-color: #5A8D6C;
        border: none;
        color: #fff;
        font-weight: 600;
        padding: 10px 18px;
        border-radius: 9px;
        transition: background-color 0.2s ease, transform 0.2s ease;
    }

    .btn-comedor-primary:hover {
        background-color: #4A7A5A;
        color: #fff;
        transform: translateY(-2px);
    }

    .table-comedor-wrapper {
        background: #FFFFFF;
        border-radius: 14px;
        padding: 10px;
        box-shadow: 0 4px 15px rgba(46, 58, 50, 0.07);
        opacity: 0;
        animation: fadeInUp 0.5s ease forwards;
        animation-delay: 0.15s;
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
        text-transform: capitalize;
    }

    .table-comedor tbody tr {
        transition: background-color 0.2s ease;
    }

    .table-comedor tbody tr:hover {
        background-color: #FAF9F4;
    }

    .btn-comedor-delete {
        background-color: #FDF0EF;
        color: #B04A3F;
        border: none;
        font-weight: 600;
        padding: 6px 14px;
        border-radius: 7px;
        font-size: 0.82rem;
        transition: background-color 0.2s ease;
    }

    .btn-comedor-delete:hover {
        background-color: #F9DEDB;
        color: #B04A3F;
    }

    .btn-comedor-delete:disabled {
        background-color: #F1F1EF;
        color: #A6A6A2;
        cursor: not-allowed;
    }
</style>

<div class="dashboard-bg">

    <div class="page-header">
        <h2>Gestión de Categorías</h2>
    </div>

    @if (session('success'))
        <div class="alert-comedor-success mb-3">{{ session('success') }}</div>
    @endif
    @if ($errors->any())
        <div class="alert-comedor-danger mb-3">{{ $errors->first() }}</div>
    @endif

    <div class="new-category-card">
        <h5>Nueva Categoría</h5>
        <form method="POST" action="{{ route('categories.store') }}" class="row g-2">
            @csrf
            <div class="col-md-5">
                <input type="text" name="name" class="form-control" placeholder="Nombre (ej. Bebidas)" required>
            </div>
            <div class="col-md-5">
                <select name="type" class="form-select" required>
                    <option value="comida">Comida</option>
                    <option value="bebida">Bebida</option>
                    <option value="empaquetado">Empaquetado</option>
                </select>
            </div>
            <div class="col-md-2">
                <button class="btn-comedor-primary w-100">Agregar</button>
            </div>
        </form>
    </div>

    <div class="table-comedor-wrapper">
        <table class="table table-comedor">
            <thead><tr><th>Nombre</th><th>Tipo</th><th>Productos</th><th>Acciones</th></tr></thead>
            <tbody>
                @foreach ($categories as $cat)
                <tr>
                    <td>{{ $cat->name }}</td>
                    <td>{{ $cat->type }}</td>
                    <td>{{ $cat->products_count }}</td>
                    <td>
                        <form action="{{ route('categories.destroy', $cat) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar categoría?')">
                            @csrf @method('DELETE')
                            <button class="btn-comedor-delete" {{ $cat->products_count > 0 ? 'disabled' : '' }}>Eliminar</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>

@endsection