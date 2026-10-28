<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Iniciar sesión · ShopAdmin</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            background: linear-gradient(120deg, #312e81, #4f46e5 50%, #7c3aed);
        }
        .login-card {
            width: 100%;
            max-width: 420px;
            border: 0;
            border-radius: 1rem;
            box-shadow: 0 20px 50px rgba(0, 0, 0, .25);
        }
        .login-logo {
            width: 64px; height: 64px;
            border-radius: 1rem;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.8rem; color: #fff;
            background: linear-gradient(90deg, #4f46e5, #7c3aed);
        }
        .btn-brand { background: linear-gradient(90deg, #4f46e5, #7c3aed); border: 0; color: #fff; font-weight: 600; }
        .btn-brand:hover { color: #fff; filter: brightness(1.12); }
    </style>
</head>
<body>

<div class="card login-card">
    <div class="card-body p-4 p-md-5">

        <div class="d-flex flex-column align-items-center mb-4">
            <div class="login-logo mb-3"><i class="bi bi-box-seam-fill"></i></div>
            <h1 class="h4 fw-bold mb-1">ShopAdmin</h1>
            <p class="text-muted small mb-0">Inventario de accesorios informáticos</p>
        </div>

        @if (session('success'))
            <div class="alert alert-success border-0 py-2 small">
                <i class="bi bi-check-circle-fill me-1"></i> {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login.store') }}">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label fw-semibold">Correo electrónico</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                    <input type="email" id="email" name="email" value="{{ old('email') }}"
                           class="form-control @error('email') is-invalid @enderror"
                           placeholder="admin@ejemplo.com" required autofocus>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label fw-semibold">Contraseña</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                    <input type="password" id="password" name="password"
                           class="form-control @error('password') is-invalid @enderror"
                           required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-check mb-4">
                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                <label class="form-check-label small" for="remember">Recordarme</label>
            </div>

            <button type="submit" class="btn btn-brand w-100 py-2">
                <i class="bi bi-box-arrow-in-right"></i> Iniciar sesión
            </button>
        </form>
    </div>
</div>

</body>
</html>