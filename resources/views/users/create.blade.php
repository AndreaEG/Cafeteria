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
        max-width: 520px;
        box-shadow: 0 4px 15px rgba(46, 58, 50, 0.07);
        opacity: 0;
        animation: fadeInUp 0.5s ease forwards;
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(12px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .form-comedor-wrapper .mb-3 label {
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

    .alert-errors {
        background: #FDECEA;
        border: 1px solid #F5C2C0;
        color: #8A2E28;
        border-radius: 9px;
        padding: 14px 18px;
        margin-bottom: 20px;
        max-width: 520px;
    }

    .alert-errors ul {
        margin: 0;
        padding-left: 20px;
    }
</style>

<div class="dashboard-bg">

    <div class="page-header">
        <h2>Nuevo Usuario</h2>
    </div>

    @if ($errors->any())
        <div class="alert-errors">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="form-comedor-wrapper">
        <form method="POST" action="{{ route('users.store') }}">
            @csrf
            <div class="mb-3">
                <label>Nombre</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
            </div>
            <div class="mb-3">
                <label>Correo</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
            </div>
            <div class="mb-3">
                <label>Contraseña</label>
                <input type="password" name="password" class="form-control" required>
                <small class="text-muted">Mínimo 5 caracteres y 1 mayúscula.</small>
            </div>
            <div class="mb-3">
                <label>Confirmar Contraseña</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Rol</label>
                <select name="role" class="form-select" required>
                    <option value="trabajador" {{ old('role') == 'trabajador' ? 'selected' : '' }}>Trabajador</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrador</option>
                </select>
            </div>
            <button class="btn-comedor-primary">Guardar</button>
        </form>
    </div>

</div>

@endsection
