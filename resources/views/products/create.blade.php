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

    .form-comedor-wrapper {
        background: #FFFFFF;
        border-radius: 14px;
        padding: 32px;
        max-width: 640px;
        box-shadow: 0 4px 15px rgba(46, 58, 50, 0.07);
        opacity: 0;
        animation: fadeInUp 0.5s ease forwards;
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(12px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .form-comedor-wrapper label:not(.form-check-label) {
        display: block;
        color: #5C6B5F;
        font-size: 0.78rem;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        font-weight: 600;
        margin-bottom: 6px;
    }

    .form-comedor-wrapper .form-control,
    .form-comedor-wrapper .form-select {
        border: 1px solid #E4E6E1;
        border-radius: 9px;
        padding: 10px 14px;
        color: #2E3A32;
        background-color: #FCFCFA;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .form-comedor-wrapper .form-control:focus,
    .form-comedor-wrapper .form-select:focus {
        border-color: #5A8D6C;
        box-shadow: 0 0 0 3px rgba(90, 141, 108, 0.12);
        background-color: #FFFFFF;
    }

    .form-comedor-wrapper small.text-muted {
        display: block;
        margin-top: 6px;
        color: #A0A69C !important;
        font-size: 0.75rem;
    }

    .form-comedor-wrapper .form-check {
        background-color: #F7F9F6;
        border: 1px solid #E4E6E1;
        border-radius: 9px;
        padding: 12px 14px 12px 40px;
    }

    .form-comedor-wrapper .form-check-input {
        border-color: #B9C4BB;
    }

    .form-comedor-wrapper .form-check-input:checked {
        background-color: #5A8D6C;
        border-color: #5A8D6C;
    }

    .form-comedor-wrapper .form-check-label {
        color: #2E3A32;
        font-size: 0.9rem;
    }

    .btn-comedor-primary {
        background-color: #5A8D6C;
        border: none;
        color: #fff;
        font-weight: 600;
        padding: 10px 24px;
        border-radius: 9px;
        transition: background-color 0.2s ease, transform 0.2s ease;
    }

    .btn-comedor-primary:hover {
        background-color: #4A7A5A;
        color: #fff;
        transform: translateY(-2px);
    }
</style>

<div class="dashboard-bg">

    <div class="page-header">
        <h2>Nuevos Productos</h2>
    </div>

    <div class="form-comedor-wrapper">
        <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label>Categoría</label>
                <select name="category_id" class="form-select" required>
                    @foreach ($categories as $c)
                        <option value="{{ $c->id }}">{{ $c->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label>Nombre</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Código de barras (opcional)</label>
                <input type="text" name="barcode" class="form-control">
                <small class="text-muted">Si se deja vacío, se generará un SKU interno automático (INT-XXX)</small>
            </div>
            <div class="row">
                <div class="col mb-3">
                    <label>Precio de costo</label>
                    <input type="number" step="0.01" name="cost_price" class="form-control" required>
                </div>
                <div class="col mb-3">
                    <label>Precio de venta</label>
                    <input type="number" step="0.01" name="sale_price" class="form-control" required>
                </div>
            </div>
            <div class="row">
                <div class="col mb-3">
                    <label>Stock inicial</label>
                    <input type="number" name="stock" class="form-control" required>
                </div>
                <div class="col mb-3">
                    <label>Stock mínimo</label>
                    <input type="number" name="min_stock" class="form-control" value="5">
                </div>
            </div>
            <div class="form-check mb-3">
                <input type="checkbox" name="always_available" value="1" class="form-check-input">
                <label class="form-check-label">Siempre disponible (ej. preparado al momento)</label>
            </div>
            <div class="mb-3">
                <label>Imagen</label>
                <input type="file" name="image" class="form-control" accept=".jpg,.jpeg,.png,.webp">
            </div>
            <button class="btn-comedor-primary">Guardar ptm</button>
        </form>
    </div>

</div>

@endsection