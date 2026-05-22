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

</header>

<div class="subheader">
    <button id="btn-sidebar" class="btn-hamburguesa">&#9776;</button>
    
    <div class="subheader-sesion">
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
                        <a href="{{ route('perfil') }}" class="header-dropdown-item">Mi perfil</a>
                        <a href="{{ route('configuracion') }}" class="header-dropdown-item">Configuración de cuenta</a>
                        <a href="{{ route('mis_solicitudes') }}" class="header-dropdown-item">Mis solicitudes</a>
                        <hr class="header-dropdown-sep">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="header-dropdown-item header-dropdown-logout">Cerrar sesión</button>
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
</div>

<div class="sidebar-overlay" id="sidebar-overlay"></div>

<aside id="sidebar" aria-label="Menú lateral">
    <button id="btn-cerrar-sidebar" class="sidebar-cerrar">&times;</button>

        <div class="sidebar-section">
            <ul>
                <li><a href="{{ route('home') }}">Inicio</a></li>
                <li class="sidebar-grupo">
                    <span class="sidebar-grupo-titulo">Adoptar</span>
                    <ul class="sidebar-subgrupo">
                        <li><a href="{{ route('home') }}">Todos</a></li>
                        <li><a href="{{ route('home', ['especie' => 'Perro']) }}">Perros</a></li>
                        <li><a href="{{ route('home', ['especie' => 'Gato']) }}">Gatos</a></li>
                        <li><a href="{{ route('home', ['especie' => 'Otro']) }}">Otros</a></li>
                    </ul>
                </li>
                <li><a href="{{ route('contacto') }}">Contacto</a></li>
                <li><a href="{{ route('sobre_nosotros') }}">Sobre nosotros</a></li>
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
    </aside>

<div class="layout">

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
    // Dropdown usuario
    var btn = document.getElementById('header-dropdown-btn');
    var menu = document.getElementById('header-dropdown-menu');
    if (btn) {
        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            var open = menu.classList.toggle('abierto');
            btn.setAttribute('aria-expanded', open);
        });
        document.addEventListener('click', function() {
            menu.classList.remove('abierto');
            btn.setAttribute('aria-expanded', false);
        });
    }

    // Altura del header dinámica
    var alturaHeader = document.querySelector('header');
    function setHeaderHeight() {
        document.documentElement.style.setProperty('--header-h', alturaHeader.offsetHeight + 'px');
    }
    setHeaderHeight();
    window.addEventListener('resize', setHeaderHeight);

    // Sidebar
    var sidebar = document.getElementById('sidebar');
    var overlay = document.getElementById('sidebar-overlay');
    var btnSidebar = document.getElementById('btn-sidebar');

    function abrirSidebar() {
        sidebar.classList.add('abierto');
        overlay.classList.add('activo');
    }
    function cerrarSidebar() {
        sidebar.classList.remove('abierto');
        overlay.classList.remove('activo');
    }

    btnSidebar.addEventListener('click', function() {
        sidebar.classList.contains('abierto') ? cerrarSidebar() : abrirSidebar();
    });
    overlay.addEventListener('click', cerrarSidebar);
    document.getElementById('btn-cerrar-sidebar').addEventListener('click', cerrarSidebar);
})();
</script>
</body>
</html>
