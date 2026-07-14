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
        display: flex;
        justify-content: space-between;
        align-items: center;
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

    .btn-comedor-primary {
        background-color: #5A8D6C;
        border: none;
        color: #fff;
        font-weight: 600;
        padding: 8px 18px;
        border-radius: 8px;
        transition: background-color 0.2s ease, transform 0.2s ease;
    }

    .btn-comedor-primary:hover {
        background-color: #4A7A5A;
        color: #fff;
        transform: translateY(-2px);
    }

    .alert-comedor-success {
        background: #F0F7F1;
        border: 1px solid #C9E3CE;
        color: #3F6B4B;
        border-radius: 10px;
        padding: 14px 18px;
        font-weight: 500;
    }

    .table-comedor-wrapper {
        background: #FFFFFF;
        border-radius: 14px;
        padding: 10px;
        box-shadow: 0 4px 15px rgba(46, 58, 50, 0.07);
        opacity: 0;
        animation: fadeInUp 0.5s ease forwards;
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(12px); }
        to   { opacity: 1; transform: translateY(0); }
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
    }

    .table-comedor tbody tr {
        transition: background-color 0.2s ease;
    }

    .table-comedor tbody tr:hover {
        background-color: #FAF9F4;
    }

    .badge-rol {
        padding: 6px 12px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.75rem;
        letter-spacing: 0.3px;
    }

    .badge-admin {
        background-color: #E7F0E9;
        color: #4A7A5A;
    }

    .badge-user {
        background-color: #F1F1EF;
        color: #6B6F68;
    }

    .btn-comedor-edit {
        background-color: #FFF3E7;
        color: #B4691F;
        border: none;
        font-weight: 600;
        padding: 6px 14px;
        border-radius: 7px;
        font-size: 0.82rem;
        transition: background-color 0.2s ease;
    }

    .btn-comedor-edit:hover {
        background-color: #FCE6CC;
        color: #B4691F;
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
</style>

<div class="dashboard-bg">

    <div class="page-header">
        <h2>Gestión de Usuarios</h2>
        <a href="{{ route('users.create') }}" class="btn-comedor-primary">+ Nuevo Usuario</a>
    </div>

    @if (session('success'))
        <div class="alert-comedor-success mb-3">{{ session('success') }}</div>
    @endif

    <div class="table-comedor-wrapper">
        <table class="table table-comedor">
            <thead>
                <tr><th>Nombre</th><th>Correo</th><th>Rol</th><th>Acciones</th></tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td><span class="badge-rol {{ $user->isAdmin() ? 'badge-admin' : 'badge-user' }}">{{ $user->role }}</span></td>
                    <td>
                        <a href="{{ route('users.edit', $user) }}" class="btn-comedor-edit">Editar</a>
                        <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Deshabilitar usuario?')">
                            @csrf @method('DELETE')
                            <button class="btn-comedor-delete">Eliminar</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>

@endsection