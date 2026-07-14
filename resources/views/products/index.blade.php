@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between mb-3">
    <h2>Catálogo de Productos</h2>
    <a href="{{ route('products.create') }}" class="btn btn-success">+ Nuevo Producto</a>
</div>

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-striped">
    <thead>
        <tr><th>Foto</th><th>Nombre</th><th>Código</th><th>Precio</th><th>Stock</th><th>Acciones</th></tr>
    </thead>
    <tbody>
        @foreach ($products as $p)
        <tr class="{{ $p->isLowStock() ? 'table-danger' : '' }}">
            <td>
                @if ($p->image_path)
                    <img src="{{ asset('storage/'.$p->image_path) }}" width="40">
                @endif
            </td>
            <td>{{ $p->name }}</td>
            <td>{{ $p->barcode ?? $p->internal_sku }}</td>
            <td>${{ number_format($p->sale_price, 2) }}</td>
            <td>{{ $p->stock }}</td>
            <td>
                <a href="{{ route('products.edit', $p) }}" class="btn btn-sm btn-warning">Editar</a>
                <form action="{{ route('products.destroy', $p) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar producto?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger">Eliminar</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection