<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cafechuzo - Iniciar Sesión</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Segoe UI', system-ui, sans-serif;
            height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            background-color: #FAFAF7;
            background-image:
                linear-gradient(135deg, rgba(216, 137, 60, 0.05) 25%, transparent 25%),
                linear-gradient(225deg, rgba(216, 137, 60, 0.05) 25%, transparent 25%),
                linear-gradient(45deg, rgba(90, 141, 108, 0.05) 25%, transparent 25%),
                linear-gradient(315deg, rgba(90, 141, 108, 0.05) 25%, transparent 25%);
            background-position: 40px 0, 40px 0, 0 0, 0 0;
            background-size: 80px 80px;
        }

        .login-card {
            background: #FFFFFF;
            border: none;
            border-radius: 18px;
            padding: 40px 36px;
            box-shadow: 0 10px 35px rgba(46, 58, 50, 0.12);
            opacity: 0;
            animation: fadeInUp 0.5s ease forwards;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(14px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .login-brand {
            text-align: center;
            color: #2E3A32;
            font-weight: 700;
            letter-spacing: 0.3px;
            margin-bottom: 6px;
        }

        .login-subtitle {
            text-align: center;
            color: #8A8F86;
            font-size: 0.85rem;
            margin-bottom: 26px;
        }

        .login-card label {
            display: block;
            color: #5C6B5F;
            font-size: 0.78rem;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            font-weight: 600;
            margin-bottom: 6px;
        }

        .login-card .form-control {
            border: 1px solid #E4E6E1;
            border-radius: 9px;
            padding: 11px 14px;
            color: #2E3A32;
            background-color: #FCFCFA;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        .login-card .form-control:focus {
            border-color: #5A8D6C;
            box-shadow: 0 0 0 3px rgba(90, 141, 108, 0.12);
            background-color: #FFFFFF;
        }

        .btn-login-comedor {
            background-color: #5A8D6C;
            border: none;
            color: #fff;
            font-weight: 700;
            letter-spacing: 0.5px;
            padding: 12px;
            border-radius: 9px;
            width: 100%;
            transition: background-color 0.2s ease, transform 0.15s ease;
        }

        .btn-login-comedor:hover {
            background-color: #4A7A5A;
            color: #fff;
            transform: translateY(-2px);
        }

        .forgot-link {
            display: block;
            text-align: center;
            margin-top: 18px;
            font-size: 0.82rem;
            color: #8A8F86;
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .forgot-link:hover {
            color: #5A8D6C;
        }

        .alert-comedor-danger {
            background: #FDF0EF;
            border: 1px solid #F1D2CE;
            color: #B04A3F;
            border-radius: 10px;
            padding: 12px 16px;
            font-size: 0.88rem;
            margin-bottom: 18px;
        }

        .alert-comedor-warning {
            background: #FFF8EC;
            border: 1px solid #F0DEB8;
            color: #A9791E;
            border-radius: 10px;
            padding: 12px 16px;
            font-size: 0.88rem;
            margin-bottom: 18px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="login-card">
                <h3 class="login-brand">🍽️ Cafechuzo</h3>
                <p class="login-subtitle">Comedor Universitario</p>

                @if ($errors->any())
                    <div class="alert-comedor-danger">{{ $errors->first() }}</div>
                @endif
                @if (session('error'))
                    <div class="alert-comedor-warning">{{ session('error') }}</div>
                @endif

                <form method="POST" action="{{ route('login.submit') }}">
                    @csrf
                    <div class="mb-3">
                        <label>Usuario / Correo</label>
                        <input type="email" name="email" class="form-control" required autofocus>
                    </div>
                    <div class="mb-3">
                        <label>Contraseña</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn-login-comedor">LOGIN</button>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>