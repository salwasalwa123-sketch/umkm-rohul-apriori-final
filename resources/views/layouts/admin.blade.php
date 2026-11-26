<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin') | Ruang Rohul</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Fraunces:opsz,wght@9..144,500;9..144,600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="admin-body">
    <div class="admin-shell">
        <aside class="sidebar" id="admin-sidebar">
            <a class="wordmark sidebar-brand" href="{{ route('admin.dashboard') }}"><span class="mark">R</span><span>RUANG <b>ROHUL</b></span></a>
            <div class="sidebar-caption">RUANG KERJA</div>
            <nav class="side-nav" aria-label="Menu admin">
                <a class="side-link {{ request()->routeIs('admin.dashboard') ? 'current' : '' }}" href="{{ route('admin.dashboard') }}"><span class="side-icon">▦</span> Ringkasan</a>
                <a class="side-link {{ request()->routeIs('admin.products.*') ? 'current' : '' }}" href="{{ route('admin.products.index') }}"><span class="side-icon">◫</span> Produk</a>
                <a class="side-link {{ request()->routeIs('admin.categories.*') ? 'current' : '' }}" href="{{ route('admin.categories.index') }}"><span class="side-icon">▤</span> Kategori</a>
                <a class="side-link {{ request()->routeIs('admin.transactions.*') ? 'current' : '' }}" href="{{ route('admin.transactions.index') }}"><span class="side-icon">⇄</span> Transaksi</a>
                <a class="side-link {{ request()->routeIs('admin.apriori') ? 'current' : '' }}" href="{{ route('admin.apriori') }}"><span class="side-icon">⌁</span> Analisis Apriori</a>
            </nav>
            <div class="sidebar-bottom">
                <a class="side-link" href="{{ route('store') }}" target="_blank"><span class="side-icon">↗</span> Lihat katalog</a>
                <div class="sidebar-user"><span class="avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span><span><b>{{ auth()->user()->name }}</b><small>Administrator</small></span></div>
                <form action="{{ route('logout') }}" method="POST">@csrf<button class="logout-button" type="submit">Keluar <span aria-hidden="true">↗</span></button></form>
            </div>
        </aside>
        <div class="sidebar-scrim" data-sidebar-close></div>
        <div class="admin-main">
            <header class="admin-topbar">
                <button class="menu-toggle" type="button" aria-label="Buka navigasi" data-sidebar-toggle><span></span><span></span></button>
                <div class="breadcrumbs"><a href="{{ route('admin.dashboard') }}">Ruang kerja</a><span>/</span><b>@yield('crumb', 'Ringkasan')</b></div>
                <a class="topbar-store" href="{{ route('store') }}" target="_blank">Katalog publik <span aria-hidden="true">↗</span></a>
            </header>
            <main class="admin-content">
                @if (session('success'))<div class="flash flash-success">{{ session('success') }}</div>@endif
                @if (session('error'))<div class="flash flash-error">{{ session('error') }}</div>@endif
                @yield('content')
            </main>
            <footer class="admin-footer"><span>Ruang Rohul · Sistem informasi UMKM</span><span>{{ now()->format('d.m.Y') }}</span></footer>
        </div>
    </div>
</body>
</html>