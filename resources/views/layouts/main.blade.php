<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titulo', 'NombrePaginaWeb')</title>
    <link rel="stylesheet" href="/styles.css">
    @stack('styles')
</head>
<body>

<header>
    <div class="header-top">
        <a href="{{ route('home') }}" class="logo">NombrePaginaWeb</a>

        <div class="header-usuario">
            @auth
                <div class="header-dropdown">
                    <button class="header-dropdown-toggle" id="header-dropdown-btn" aria-expanded="false" aria-haspopup="true">
                        @if(Auth::user()->foto_perfil)
                            <img src="{{ Storage::url(Auth::user()->foto_perfil) }}" alt="Foto de perfil" class="header-avatar">
                        @else
                            <div class="header-avatar header-avatar-inicial">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                        @endif
                        <span class="header-dropdown-nombre">{{ Auth::user()->name }}</span>
                        <span class="header-dropdown-caret">&#9660;</span>
                    </button>
                    <div class="header-dropdown-menu" id="header-dropdown-menu">
                        <div class="header-dropdown-cabecera">
                            @if(Auth::user()->foto_perfil)
                                <img src="{{ Storage::url(Auth::user()->foto_perfil) }}" alt="" class="header-dropdown-avatar">
                            @else
                                <div class="header-avatar header-avatar-inicial header-dropdown-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                            @endif
                            <div>
                                <div class="header-dropdown-nombre-big">{{ Auth::user()->name }}</div>
                                <div class="header-dropdown-email">{{ Auth::user()->email }}</div>
                            </div>
                        </div>
                        <hr class="header-dropdown-sep">
                        <a href="{{ route('perfil') }}" class="header-dropdown-item">&#128100; Mi perfil</a>
                        <a href="{{ route('configuracion') }}" class="header-dropdown-item">&#9881; Configuración de cuenta</a>
                        <a href="{{ route('mis_solicitudes') }}" class="header-dropdown-item">&#128196; Mis solicitudes</a>
                        <hr class="header-dropdown-sep">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="header-dropdown-item header-dropdown-logout">&#10148; Cerrar sesión</button>
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}">Iniciar sesión</a>
                <span>|</span>
                <a href="{{ route('register') }}">Registrarse</a>
            @endauth
        </div>
    </div>

    <nav class="top-nav" aria-label="Navegación principal">
        <ul>
            <li><a href="{{ route('home') }}">Inicio</a></li>
            <li><a href="{{ route('home') }}">Adoptar</a></li>
            @auth
                @if(Auth::user()->es_admin)
                    <li><a href="{{ route('admin.animales.index') }}">Administración</a></li>
                @endif
            @endauth
            <li><a href="{{ route('contacto') }}">Contacto</a></li>
        </ul>
    </nav>
</header>

<div class="layout">

    <aside aria-label="Menú lateral">
        <div class="sidebar-section">
            <h3>Explorar</h3>
            <ul>
                <li><a href="{{ route('home') }}">Todos los animales</a></li>
                <li><a href="{{ route('home', ['especie' => 'Perro']) }}">Perros</a></li>
                <li><a href="{{ route('home', ['especie' => 'Gato']) }}">Gatos</a></li>
                <li><a href="{{ route('home', ['especie' => 'Otro']) }}">Otros</a></li>
            </ul>
        </div>

        @auth
        <div class="sidebar-section">
            <h3>Mi cuenta</h3>
            <ul>
                <li><a href="{{ route('perfil') }}">Mi perfil</a></li>
                <li><a href="{{ route('configuracion') }}">Configuración</a></li>
                <li><a href="{{ route('mis_solicitudes') }}">Mis solicitudes</a></li>
            </ul>
        </div>
        @else
        <div class="sidebar-section">
            <h3>Acceso</h3>
            <ul>
                <li><a href="{{ route('login') }}">Iniciar sesión</a></li>
                <li><a href="{{ route('register') }}">Crear cuenta</a></li>
            </ul>
        </div>
        @endauth

        @auth
        @if(Auth::user()->es_admin)
        <div class="sidebar-section">
            <h3>Administración</h3>
            <ul>
                <li><a href="{{ route('admin.animales.index') }}">Gestionar animales</a></li>
                <li><a href="{{ route('admin.solicitudes.index') }}">Solicitudes</a></li>
                <li><a href="{{ route('admin.mensajes.index') }}">Mensajes</a></li>
            </ul>
        </div>
        @endif
        @endauth

        <div class="sidebar-section">
            <h3>Información</h3>
            <ul>
                <li><a href="{{ route('contacto') }}">Contacto</a></li>
                <li><a href="{{ route('sobre_nosotros') }}">Sobre nosotros</a></li>
                <li><a href="/como_se_hizo.pdf" target="_blank">Informe técnico</a></li>
            </ul>
        </div>
    </aside>

    <main>
        @if(session('exito'))
            <div class="alert alert-exito">{{ session('exito') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif

        @yield('contenido')
    </main>

</div>

<footer>
    <p>
        &copy; {{ date('Y') }} NombrePaginaWeb &mdash;
        <a href="{{ route('sobre_nosotros') }}">Sobre nosotros</a>
        &nbsp;|&nbsp;
        <a href="{{ route('contacto') }}">Contacto</a>
        &nbsp;|&nbsp;
        <a href="/como_se_hizo.pdf" target="_blank">Informe técnico (PDF)</a>
    </p>
</footer>

<script>
(function() {
    var btn = document.getElementById('header-dropdown-btn');
    var menu = document.getElementById('header-dropdown-menu');
    if (!btn) return;
    btn.addEventListener('click', function(e) {
        e.stopPropagation();
        var open = menu.classList.toggle('abierto');
        btn.setAttribute('aria-expanded', open);
    });
    document.addEventListener('click', function() {
        menu.classList.remove('abierto');
        btn.setAttribute('aria-expanded', false);
    });
})();
</script>
</body>
</html>
