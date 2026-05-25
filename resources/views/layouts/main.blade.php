<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titulo', 'Pawtect')</title>
    <link href="https://fonts.googleapis.com/css2?family=Lora:wght@600;700&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/styles.css">
    @stack('styles')
    <script>if(localStorage.getItem('sidebar')==='colapsado')document.documentElement.classList.add('sidebar-colapsado');</script>
</head>
<body>

{{-- Logo flotante fijo: abre el sidebar --}}
<button id="btn-sidebar" class="logo-toggle" aria-label="Abrir menú">
    <img src="/logo.png" alt="Pawtect">
</button>

<header>
    <div class="header-top">
        <a href="{{ route('home') }}" class="logo">
            <span class="logo-nombre">Pawtect</span>
        </a>
    </div>
</header>

<div class="subheader">
    <button id="btn-sidebar-movil" class="btn-hamburguesa btn-hamburguesa-movil">&#9776;</button>

    <nav class="nav-superior" id="nav-superior">
        <a href="{{ route('home') }}">Portada</a>
        <a href="{{ route('adoptar') }}">Adoptar</a>
        <a href="{{ route('experiencias.index') }}">Experiencias</a>
        <a href="{{ route('contacto') }}">Contacto</a>
        <a href="{{ route('sobre_nosotros') }}">Sobre nosotros</a>
    </nav>

    <div class="subheader-sesion">
            @auth
                {{-- Campanita de notificaciones --}}
                <div class="notif-wrapper">
                    <button class="notif-btn" id="notif-btn" aria-label="Notificaciones">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                            <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
                        </svg>
                        @if($notificaciones_no_leidas > 0)
                            <span class="notif-badge">{{ $notificaciones_no_leidas > 9 ? '9+' : $notificaciones_no_leidas }}</span>
                        @endif
                    </button>
                    <div class="notif-dropdown" id="notif-dropdown">
                        <div class="notif-dropdown-header">
                            <span>Notificaciones</span>
                            @if($notificaciones_no_leidas > 0)
                                <form method="POST" action="{{ route('notificaciones.todas') }}">
                                    @csrf
                                    <button type="submit" class="notif-marcar-todas">Marcar todas como leídas</button>
                                </form>
                            @endif
                        </div>
                        @if($notificaciones_recientes->isEmpty())
                            <p class="notif-vacia">No tienes notificaciones.</p>
                        @else
                            <ul class="notif-lista">
                                @foreach($notificaciones_recientes as $notif)
                                <li class="notif-item {{ $notif->leida ? '' : 'notif-no-leida' }}">
                                    <form method="POST" action="{{ route('notificaciones.leida', $notif) }}">
                                        @csrf
                                        <button type="submit" class="notif-item-btn">
                                            <span class="notif-item-texto">{{ $notif->mensaje }}</span>
                                            <span class="notif-item-fecha">{{ $notif->created_at->diffForHumans() }}</span>
                                        </button>
                                    </form>
                                </li>
                                @endforeach
                            </ul>
                            <a href="{{ route('notificaciones.index') }}" class="notif-ver-todas">Ver todas</a>
                        @endif
                    </div>
                </div>

                <span class="header-tipo">{{ Auth::user()->es_admin ? 'Administrador' : 'Usuario' }}</span>

                <div class="header-dropdown">
                    <button class="header-dropdown-toggle" id="header-dropdown-btn" aria-expanded="false" aria-haspopup="true">
                        @if(Auth::user()->foto_perfil)
                            <img src="{{ Storage::url(Auth::user()->foto_perfil) }}" alt="Foto de perfil" class="header-avatar">
                        @else
                            <span class="header-avatar header-avatar-inicial">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
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

<div class="pagina-wrapper">
<aside id="sidebar" aria-label="Menú lateral">
    <button id="btn-colapsar-sidebar" class="sidebar-cerrar" aria-label="Colapsar menú">&#8592;</button>

        <div class="sidebar-section">
            <ul>
                <li><a href="{{ route('home') }}">Inicio</a></li>
                <li class="sidebar-grupo">
                    <span class="sidebar-grupo-titulo">Adoptar</span>
                    <ul class="sidebar-subgrupo">
                        <li><a href="{{ route('adoptar') }}">Todos</a></li>
                        <li><a href="{{ route('adoptar', ['especie' => 'Perro']) }}">Perros</a></li>
                        <li><a href="{{ route('adoptar', ['especie' => 'Gato']) }}">Gatos</a></li>
                        <li><a href="{{ route('adoptar', ['especie' => 'Otro']) }}">Otros</a></li>
                    </ul>
                </li>
                <li><a href="{{ route('experiencias.index') }}">Experiencias</a></li>
                <li><a href="{{ route('contacto') }}">Contacto</a></li>
                <li><a href="{{ route('sobre_nosotros') }}">Sobre nosotros</a></li>
            </ul>
        </div>

        @auth
        <div class="sidebar-section">
            <h3>Mi cuenta</h4>
            <ul>
                <li><a href="{{ route('perfil') }}">Mi perfil</a></li>
                <li><a href="{{ route('configuracion') }}">Configuración</a></li>
                <li><a href="{{ route('mis_solicitudes') }}">Mis solicitudes</a></li>
                <li>
                    <a href="{{ route('notificaciones.index') }}">Notificaciones
                        @if($notificaciones_no_leidas > 0)
                            <span class="sidebar-notif-badge">{{ $notificaciones_no_leidas }}</span>
                        @endif
                    </a>
                </li>
            </ul>
        </div>
        @else
        <div class="sidebar-section">
            <h3>Acceso</h4>
            <ul>
                <li><a href="{{ route('login') }}">Iniciar sesión</a></li>
                <li><a href="{{ route('register') }}">Crear cuenta</a></li>
            </ul>
        </div>
        @endauth

        @auth
        @if(Auth::user()->es_admin)
        <div class="sidebar-section">
            <h3>Administración</h4>
            <ul>
                <li><a href="{{ route('admin.animales.index') }}">Gestionar animales</a></li>
                <li><a href="{{ route('admin.solicitudes.index') }}">Solicitudes</a></li>
                <li><a href="{{ route('admin.experiencias.index') }}">Experiencias</a></li>
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
</div> {{-- pagina-wrapper --}}

<!-- Banner de cookies -->
<div id="cookie-banner" class="cookie-banner" style="display:none">
    <div class="cookie-banner-texto">
        <strong>🍪 Usamos cookies</strong>
        <p>Utilizamos cookies propias y de terceros para mejorar tu experiencia, analizar el tráfico y personalizar el contenido. Puedes aceptarlas todas o solo las necesarias.</p>
    </div>
    <div class="cookie-banner-acciones">
        <button id="cookie-rechazar" class="btn btn-gris btn-sm">Solo necesarias</button>
        <button id="cookie-aceptar" class="btn btn-primary btn-sm">Aceptar todas</button>
    </div>
</div>

<footer>
    <div class="footer-superior">
        <div class="footer-col footer-col-logo">
            <img src="/logo.png" alt="Pawtect" class="footer-logo-lateral">
        </div>
        <div class="footer-col">
            <h4 class="footer-col-titulo">Contacta con nosotros</h4>
            <p>Camino Bajo de Huétor, 132<br>18008 Granada</p>
            <p>T. 958 000 000</p>
            <p>Email: <a href="mailto:contacto@pawtect.es">contacto@pawtect.es</a></p>
            <p><a href="{{ route('contacto') }}">Formulario de contacto</a></p>
        </div>
        <div class="footer-col">
            <h4 class="footer-col-titulo">Boletín de novedades</h4>
            <p>Recibe sus historias por correo cada semana</p>
            <form class="footer-boletin" onsubmit="return false;">
                <input type="email" placeholder="Tu email">
                <button type="submit">Enviar</button>
            </form>
        </div>
        <div class="footer-col">
            <h4 class="footer-col-titulo">Conócenos más</h4>
            <div class="footer-redes">
                <a href="#" class="footer-red" aria-label="Facebook">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
                </a>
                <a href="#" class="footer-red" aria-label="Instagram">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none"/></svg>
                </a>
            </div>
            <p style="margin-top:0.8rem"><a href="{{ route('sobre_nosotros') }}">Sobre nosotros</a></p>
        </div>
    </div>
    <hr class="footer-sep">
    <div class="footer-inferior">
        <span class="footer-brand">
            &copy; {{ date('Y') }} Pawtect. Todos los derechos reservados.
        </span>
        <span>
            <a href="#">Política de privacidad</a>
            &nbsp;|&nbsp;
            <a href="#">Política de cookies</a>
            &nbsp;|&nbsp;
            <a href="#">Aviso legal</a>
            &nbsp;|&nbsp;
            <a href="/como_se_hizo.pdf" target="_blank">Informe técnico (PDF)</a>
        </span>
    </div>
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

    // Sidebar
    var sidebar = document.getElementById('sidebar');
    var overlay = document.getElementById('sidebar-overlay');
    var btnSidebar = document.getElementById('btn-sidebar');
    var btnSidebarMovil = document.getElementById('btn-sidebar-movil');
    var btnColapsar = document.getElementById('btn-colapsar-sidebar');

    function esMobil() { return window.innerWidth <= 700; }

    function abrirSidebar() {
        sidebar.classList.add('abierto');
        overlay.classList.add('activo');
    }
    function cerrarSidebar() {
        sidebar.classList.remove('abierto');
        overlay.classList.remove('activo');
    }

    // hamburguesa: en móvil abre overlay, en escritorio expande
    btnSidebar.addEventListener('click', function() {
        if (esMobil()) {
            sidebar.classList.contains('abierto') ? cerrarSidebar() : abrirSidebar();
        } else {
            document.documentElement.classList.remove('sidebar-colapsado');
            localStorage.setItem('sidebar', 'abierto');
        }
    });

    // flecha: en móvil cierra, en escritorio colapsa
    if (btnColapsar) {
        btnColapsar.addEventListener('click', function() {
            if (esMobil()) {
                cerrarSidebar();
            } else {
                document.documentElement.classList.add('sidebar-colapsado');
                localStorage.setItem('sidebar', 'colapsado');
            }
        });
    }

    if (btnSidebarMovil) {
        btnSidebarMovil.addEventListener('click', function() {
            sidebar.classList.contains('abierto') ? cerrarSidebar() : abrirSidebar();
        });
    }

    overlay.addEventListener('click', cerrarSidebar);

    // restaurar estado al cargar
    if (!esMobil() && localStorage.getItem('sidebar') === 'colapsado') {
        document.documentElement.classList.add('sidebar-colapsado');
    }

    // Carrusel
    var slides = document.querySelectorAll('.carrusel-slide');
    var dots   = document.querySelectorAll('.carrusel-dot');
    if (slides.length) {
        var actual = 0;

        function irA(n) {
            slides[actual].classList.remove('activa');
            dots[actual].classList.remove('activo');
            actual = (n + slides.length) % slides.length;
            slides[actual].classList.add('activa');
            dots[actual].classList.add('activo');
        }

        document.getElementById('carrusel-prev').addEventListener('click', function() { irA(actual - 1); });
        document.getElementById('carrusel-next').addEventListener('click', function() { irA(actual + 1); });
        dots.forEach(function(dot) {
            dot.addEventListener('click', function() { irA(parseInt(dot.dataset.index)); });
        });

        setInterval(function() { irA(actual + 1); }, 4000);
    }

    // notificaciones
    var notifBtn = document.getElementById('notif-btn');
    var notifDropdown = document.getElementById('notif-dropdown');
    if (notifBtn) {
        notifBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            notifDropdown.classList.toggle('abierto');
        });
        document.addEventListener('click', function() {
            notifDropdown.classList.remove('abierto');
        });
        notifDropdown.addEventListener('click', function(e) { e.stopPropagation(); });
    }

    // Cookies
    function getCookie(name) {
        var match = document.cookie.match(new RegExp('(^| )' + name + '=([^;]+)'));
        return match ? match[2] : null;
    }
    function setCookie(name, value, days) {
        var expires = new Date(Date.now() + days * 864e5).toUTCString();
        document.cookie = name + '=' + value + '; expires=' + expires + '; path=/; SameSite=Lax';
    }

    var banner = document.getElementById('cookie-banner');
    if (!getCookie('cookie_consent')) {
        banner.style.display = 'flex';
    }
    document.getElementById('cookie-aceptar').addEventListener('click', function() {
        setCookie('cookie_consent', 'all', 365);
        banner.classList.add('cookie-banner-oculto');
        setTimeout(function() { banner.style.display = 'none'; }, 400);
    });
    document.getElementById('cookie-rechazar').addEventListener('click', function() {
        setCookie('cookie_consent', 'necessary', 365);
        banner.classList.add('cookie-banner-oculto');
        setTimeout(function() { banner.style.display = 'none'; }, 400);
    });
})();
</script>
@stack('scripts')
</body>
</html>
