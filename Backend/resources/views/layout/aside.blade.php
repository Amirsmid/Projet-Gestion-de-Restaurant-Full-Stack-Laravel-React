<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <div class="sidebar-brand-wrapper d-flex align-items-center justify-content-center mb-3">
        <a class="navbar-brand brand-logo" href="{{ route('dashboard') }}">
            @if (isset($infoormations) && $infoormations?->logo)
                <img src="{{ asset('images') }}/{{ $infoormations->logo }}" width="120" alt="logo" style="max-height: 60px; object-fit: contain;" />
            @else
                <span class="h5 m-0 text-white">{{ config('app.name','Dashboard') }}</span>
            @endif
        </a>
    </div>
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                <i class="icon-grid menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('categorie.*') ? 'active' : '' }}" href="{{ route('categorie.index') }}">
                <i class="ti-tag menu-icon"></i>
                <span class="menu-title">Catégories</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('article.*') ? 'active' : '' }}" href="{{ route('article.index') }}">
                <i class="ti-bookmark-alt menu-icon"></i>
                <span class="menu-title">Articles</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('commende.*') ? 'active' : '' }}" href="{{ route('commende.index') }}">
                <i class="fas fa-file menu-icon"></i>
                <span class="menu-title">Commendes</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('reservation.*') ? 'active' : '' }}" href="{{ route('reservation.index') }}">
                <i class="fas fa-clock menu-icon"></i>
                <span class="menu-title">Reservations</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('contactes.*') ? 'active' : '' }}" href="{{ route('contactes.index') }}">
                <i class="fas fa-mail-bulk menu-icon"></i>
                <span class="menu-title">Contacts</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('client.*') ? 'active' : '' }}" href="{{ route('client.index') }}">
                <i class="fas fa-users menu-icon"></i>
                <span class="menu-title">Clients</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('parameter.*') ? 'active' : '' }}" href="{{ route('parameter.index') }}">
                <i class="ti-settings  menu-icon"></i>
                <span class="menu-title">Parameter</span>
            </a>
        </li>
    </ul>
</nav>