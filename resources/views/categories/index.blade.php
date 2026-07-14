@extends('layouts.app')
@section('content')
<h2>Gestión de Categorías</h2>

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if ($errors->any())
    <div class="alert alert-danger">{{ $errors->first() }}</div>
@endif

<div class="card mb-4">
    <div class="card-body">
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
                <button class="btn btn-success w-100">Agregar</button>
            </div>
        </form>
    </div>
</div>

<table class="table table-striped">
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
                    <button class="btn btn-sm btn-danger" {{ $cat->products_count > 0 ? 'disabled' : '' }}>Eliminar</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
