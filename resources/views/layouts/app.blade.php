<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Inventario TI') · ShopAdmin</title>

    {{-- Bootstrap 5.3.8 e iconos por CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        /* Estilos compartidos por todas las vistas */
        body { background: #f4f5fb; min-height: 100vh; display: flex; flex-direction: column; }

        /* Barra superior con degradado */
        .app-nav { background: linear-gradient(90deg, #312e81, #4f46e5, #7c3aed); }
        .app-nav .nav-link { border-radius: .6rem; padding: .45rem .9rem; opacity: .85; }
        .app-nav .nav-link:hover { opacity: 1; background: rgba(255, 255, 255, .12); }
        .app-nav .nav-link.active { opacity: 1; background: rgba(255, 255, 255, .22); font-weight: 600; }

        /* Cabecera de cada página */
        .page-header {
            background: linear-gradient(120deg, #4f46e5, #7c3aed 60%, #2563eb);
            color: #fff;
            padding: 2.2rem 0 4.5rem;
        }

        /* El contenido sube y se superpone a la cabecera */
        .page-body { margin-top: -3rem; }

        /* Tarjetas blancas redondeadas */
        .card-soft { border: 0; border-radius: 1rem; box-shadow: 0 10px 30px rgba(79, 70, 229, .12); }

        /* Botón principal con degradado */
        .btn-brand { background: linear-gradient(90deg, #4f46e5, #7c3aed); border: 0; color: #fff; font-weight: 600; }
        .btn-brand:hover { color: #fff; filter: brightness(1.12); }

        /* Tabla limpia */
        .table thead th {
            background: #eef0ff; color: #3730a3; font-size: .8rem;
            text-transform: uppercase; letter-spacing: .04em; border: 0;
        }
        .table > :not(caption) > * > * { padding: .85rem 1rem; }
    </style>
</head>
<body>

    {{-- Barra de navegación --}}
    <nav class="navbar navbar-expand-md app-nav" data-bs-theme="dark">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('products.index') }}">
                <i class="bi bi-box-seam-fill me-1"></i> ShopAdmin
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuPrincipal">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="menuPrincipal">
                <ul class="navbar-nav ms-auto gap-1">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}" href="{{ route('products.index') }}">
                            <i class="bi bi-box-seam"></i> Productos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}" href="{{ route('categories.index') }}">
                            <i class="bi bi-tags"></i> Categorías
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('suppliers.*') ? 'active' : '' }}" href="{{ route('suppliers.index') }}">
                            <i class="bi bi-truck"></i> Proveedores
                        </a>
                    </li>
                                        <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('stock-movements.*') ? 'active' : '' }}" href="{{ route('stock-movements.index') }}">
                            <i class="bi bi-arrow-left-right"></i> Movimientos
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    {{-- Cabecera con título, subtítulo y botón de acción (cada vista los define) --}}
    <header class="page-header">
        <div class="container d-flex flex-wrap justify-content-between align-items-center gap-3">
            <div>
                <h1 class="h2 fw-bold mb-1">@yield('title')</h1>
                <p class="mb-0 opacity-75">@yield('subtitle')</p>
            </div>
            <div>@yield('actions')</div>
        </div>
    </header>

    {{-- Contenido principal --}}
    <main class="container page-body flex-grow-1 pb-5">

        {{-- Mensajes de confirmación y error (RF07) --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm border-0" role="alert">
                <i class="bi bi-check-circle-fill me-1"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-1"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="text-center text-muted small py-3">
        ShopAdmin · Inventario de accesorios informáticos · SENATI
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>