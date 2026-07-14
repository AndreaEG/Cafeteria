@extends('layouts.app')
@section('content')
<h2>Nuevo Usuario</h2>
<form method="POST" action="{{ route('users.store') }}">
    @csrf
    <div class="mb-3">
        <label>Nombre</label>
        <input type="text" name="name" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Correo</label>
        <input type="email" name="email" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Contraseña</label>
        <input type="password" name="password" class="form-control" required>
        <small class="text-muted">Mínimo 10 caracteres, 1 mayúscula y 1 carácter especial.</small>
    </div>
    <div class="mb-3">
        <label>Confirmar Contraseña</label>
        <input type="password" name="password_confirmation" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Rol</label>
        <select name="role" class="form-select" required>
            <option value="trabajador">Trabajador</option>
            <option value="admin">Administrador</option>
        </select>
    </div>
    <button class="btn btn-success">Guardar</button>
</form>
@endsection
