@extends('layouts.app')
@section('content')
<h2>Editar Usuario</h2>
<form method="POST" action="{{ route('users.update', $user) }}">
    @csrf @method('PUT')
    <div class="mb-3">
        <label>Nombre</label>
        <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
    </div>
    <div class="mb-3">
        <label>Correo</label>
        <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
    </div>
    <div class="mb-3">
        <label>Nueva contraseña (opcional)</label>
        <input type="password" name="password" class="form-control">
    </div>
    <div class="mb-3">
        <label>Confirmar contraseña</label>
        <input type="password" name="password_confirmation" class="form-control">
    </div>
    <div class="mb-3">
        <label>Rol</label>
        <select name="role" class="form-select" required>
            <option value="trabajador" {{ $user->role=='trabajador'?'selected':'' }}>Trabajador</option>
            <option value="admin" {{ $user->role=='admin'?'selected':'' }}>Administrador</option>
        </select>
    </div>
    <button class="btn btn-success">Actualizar</button>
</form>
@endsection
