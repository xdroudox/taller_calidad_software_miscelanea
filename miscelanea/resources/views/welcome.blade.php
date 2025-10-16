<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Miscelánea') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Solo íconos de Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

    <!-- Tu hoja de estilos personalizada -->
    @vite(['resources/css/welcome.css'])
</head>
<body>
    <div class="hero-section">
        <div class="container">
            @if (Route::has('login'))
                <div class="opciones-login">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn-custom btn-login">
                            <i class="bi bi-speedometer2"></i> Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn-custom btn-login">
                            <i class="bi bi-box-arrow-in-right"></i> Iniciar sesión
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn-custom btn-register">
                                <i class="bi bi-person-plus"></i> Registrarse
                            </a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="contenido-principal">
                <div class="texto-bienvenida">
                    <i class="bi bi-shop product-icon"></i>
                    <h1 class="logo-text">Miscelánea Digital</h1>
                    <p class="descripcion">
                        Tu tienda de útiles escolares y papelería favorita. 
                        Encuentra todo lo que necesitas para tus proyectos, 
                        estudios y oficina.
                    </p>
                    <div class="botones">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="btn-custom btn-login">
                                <i class="bi bi-arrow-right-circle"></i> Ir al Sistema
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="btn-custom btn-login">
                            Comenzar
                            </a>
                        @endauth
                    </div>
                </div>

                <div class="tarjetas">
                    <div class="feature-card">
                        <i class="bi bi-pencil-fill"></i>
                        <h4>Útiles Escolares</h4>
                        <p>Lápices, colores, cuadernos y más</p>
                    </div>
                    <div class="feature-card">
                        <i class="bi bi-scissors"></i>
                        <h4>Manualidades</h4>
                        <p>Tijeras, pegamento, cartulinas</p>
                    </div>
                    <div class="feature-card">
                        <i class="bi bi-file-earmark-text"></i>
                        <h4>Papelería</h4>
                        <p>Papel bond, folders, archivadores</p>
                    </div>
                    <div class="feature-card">
                        <i class="bi bi-palette-fill"></i>
                        <h4>Arte</h4>
                        <p>Pinturas, pinceles, marcadores</p>
                    </div>
                </div>
            </div>

            <div class="caracteristicas">
                <p>
                    <i class="bi bi-check-circle"></i> Gestión de inventario
                    <i class="bi bi-check-circle"></i> Control de categorías
                    <i class="bi bi-check-circle"></i> Reportes en tiempo real
                </p>
            </div>
        </div>
    </div>
</body>
</html>
