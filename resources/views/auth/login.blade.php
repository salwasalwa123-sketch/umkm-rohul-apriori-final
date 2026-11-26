<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk Admin | Ruang Rohul</title>
    <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Fraunces:opsz,wght@9..144,500;9..144,600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="login-body">
    <a class="login-back" href="{{ route('store') }}">Kembali ke katalog</a>
    <main class="login-scene">
        <div class="login-art">
            <img src="https://images.unsplash.com/photo-1472396961693-142e6e269027?auto=format&fit=crop&w=1300&q=85" alt="Lanskap hijau Rokan Hulu">
            <div class="login-art-overlay"></div>
            <a class="wordmark login-wordmark" href="{{ route('store') }}"><span class="mark">R</span><span>RUANG <b>ROHUL</b></span></a>
            <div class="login-art-copy"><p class="eyebrow light">RUANG KERJA UMKM</p><h1>Merawat usaha,<br><em>menguatkan daerah.</em></h1><p>Kelola produk, transaksi, dan peluang baru untuk pelaku usaha Rokan Hulu.</p></div>
            <span class="login-art-credit">ROKAN HULU · RIAU</span>
        </div>
        <div class="login-panel"><div class="login-form-wrap">
            <p class="eyebrow">SELAMAT DATANG KEMBALI</p><h2>Masuk ke<br><em>ruang kerja.</em></h2>
            <p class="login-lead">Gunakan akun administrator untuk melanjutkan.</p>
            <x-auth-session-status class="flash flash-success" :status="session('status')" />
            <form method="POST" action="{{ route('login') }}" class="form-stack">
                @csrf
                <label class="field-label" for="email">Alamat email</label>
                <input class="text-field" id="email" type="email" name="email" value="{{ old('email') }}" autocomplete="username" required autofocus>
                <x-input-error :messages="$errors->get('email')" class="field-error" />
                <label class="field-label" for="password">Kata sandi</label>
                <input class="text-field" id="password" type="password" name="password" autocomplete="current-password" required>
                <x-input-error :messages="$errors->get('password')" class="field-error" />
                <label class="check-label"><input id="remember_me" type="checkbox" name="remember"> <span>Ingat saya di perangkat ini</span></label>
                <button class="button button-dark login-submit" type="submit">Masuk <span aria-hidden="true">↗</span></button>
            </form>
            <p class="login-footnote">Akses terbatas untuk pengelola Ruang Rohul.</p>
        </div></div>
    </main>
</body>
</html>
