<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'CarTur — Concesionario 2025-2026')</title>
    <meta name="description" content="CarTur — Venta y alquiler de autos 2025-2026. Ford, Lamborghini, BMW, Ferrari, Aorus, Mercedes-Benz y Audi.">

    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">

    <!-- Fuentes -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;700;900&family=Poppins:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    @stack('styles')
</head>
<body>

    <nav class="navbar">
        <div class="navbar__container">
            <a href="{{ route('landing') }}" class="navbar__logo">CarTur</a>

            <ul class="navbar__menu">
                <li><a href="{{ route('landing') }}">Inicio</a></li>
                <li><a href="{{ route('landing') }}#servicio">Servicio</a></li>
                <li><a href="{{ route('landing') }}#marcas">Marcas</a></li>
                <li><a href="{{ route('catalog') }}" class="navbar__cta">Catálogo</a></li>
            </ul>

            <button class="navbar__toggle" aria-label="Abrir menú">
                <span></span><span></span><span></span>
            </button>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer class="footer">
        <div class="container">
            <div class="footer__top">
                <div class="footer__col">
                    <div class="footer__logo">CarTur</div>
                    <p class="footer__tagline">Concesionario de autos 2025-2026. Venta y alquiler de las marcas más exclusivas del mundo.</p>
                </div>
                <div class="footer__col">
                    <h4>Navegación</h4>
                    <ul>
                        <li><a href="{{ route('landing') }}">Inicio</a></li>
                        <li><a href="{{ route('landing') }}#servicio">Servicio</a></li>
                        <li><a href="{{ route('landing') }}#marcas">Marcas</a></li>
                        <li><a href="{{ route('catalog') }}">Catálogo</a></li>
                    </ul>
                </div>
                <div class="footer__col">
                    <h4>Contacto</h4>
                    <ul>
                        <li>Av. Insurgentes 1234, CDMX</li>
                        <li>+52 55 1234 5678</li>
                        <li>ventas@cartur.mx</li>
                    </ul>
                </div>
                <div class="footer__col">
                    <h4>Redes</h4>
                    <div class="footer__social">
                        <a href="#" aria-label="Instagram">IG</a>
                        <a href="#" aria-label="Facebook">FB</a>
                        <a href="#" aria-label="Twitter">X</a>
                        <a href="#" aria-label="YouTube">YT</a>
                    </div>
                </div>
            </div>
            <div class="footer__bottom">
                <p>&copy; {{ date('Y') }} CarTur. Todos los derechos reservados.</p>
                <p>Temporada 2025 — 2026</p>
            </div>
        </div>
    </footer>

    <script src="{{ asset('js/main.js') }}"></script>
    @stack('scripts')
</body>
</html>
