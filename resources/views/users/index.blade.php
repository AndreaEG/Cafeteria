@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between mb-3">
    <h2>Gestión de Usuarios</h2>
    <a href="{{ route('users.create') }}" class="btn btn-success">+ Nuevo Usuario</a>
</div>

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-striped">
    <thead>
        <tr><th>Nombre</th><th>Correo</th><th>Rol</th><th>Acciones</th></tr>
    </thead>
    <tbody>
        @foreach ($users as $user)
        <tr>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td><span class="badge bg-{{ $user->isAdmin() ? 'primary' : 'secondary' }}">{{ $user->role }}</span></td>
            <td>
                <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-warning">Editar</a>
                <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Deshabilitar usuario?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger">Eliminar</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
