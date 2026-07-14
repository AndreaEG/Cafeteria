@extends('layouts.app')
@section('content')
<h2>Nuevo Producto</h2>
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
            <label>Stock mínimo (alerta)</label>
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
    <button class="btn btn-success">Guardar</button>
</form>
@endsection