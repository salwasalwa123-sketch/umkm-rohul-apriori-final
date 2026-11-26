<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ruang Rohul | Produk Lokal Rokan Hulu</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Fraunces:opsz,wght@9..144,500;9..144,600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="store-body">
    <header class="store-nav">
        <a class="wordmark" href="{{ route('store') }}"><span class="mark">R</span><span>RUANG <b>ROHUL</b></span></a>
        <nav class="store-links" aria-label="Navigasi utama">
            <a href="#produk">Produk pilihan</a>
            <a href="#tentang">Cerita daerah</a>
            <a class="nav-admin" href="{{ route('login') }}">Masuk admin <span aria-hidden="true">↗</span></a>
        </nav>
    </header>

    <main>
        <section class="store-hero" id="tentang">
            <img class="hero-image" src="https://images.unsplash.com/photo-1472396961693-142e6e269027?auto=format&fit=crop&w=2200&q=88" alt="Bentang alam hijau Rokan Hulu">
            <div class="hero-shade"></div>
            <div class="hero-copy">
                <p class="eyebrow light"><span></span> KABUPATEN ROKAN HULU, RIAU</p>
                <h1>Rasa dan karya<br><em>dari tanah sendiri.</em></h1>
                <p class="hero-description">Temukan produk pilihan dari para pelaku usaha lokal Rokan Hulu. Dibuat dengan ketekunan, tumbuh bersama masyarakat.</p>
                <a class="button button-cream" href="#produk">Jelajahi produk <span aria-hidden="true">↓</span></a>
            </div>
            <div class="hero-note"><span>01</span> PRODUK LOKAL, CERITA NYATA</div>
        </section>

        <section class="store-intro" aria-label="Ringkasan katalog">
            <p><strong>{{ $products->total() }}+</strong> produk pilihan</p><span class="intro-rule"></span>
            <p>Usaha lokal, mutu yang dijaga</p><span class="intro-rule"></span><p>Langsung dari Rokan Hulu</p>
        </section>

        <section class="catalog-section" id="produk">
            <div class="catalog-heading">
                <div><p class="eyebrow">PILIHAN DARI ROHUL</p><h2>Temukan yang <em>khas.</em></h2></div>
                <form method="GET" action="{{ route('store') }}" class="catalog-search">
                    <label class="sr-only" for="catalog-search">Cari produk</label>
                    <input id="catalog-search" type="search" name="q" value="{{ $search }}" placeholder="Cari produk lokal...">
                    @if ($selectedCategory)<input type="hidden" name="category" value="{{ $selectedCategory }}">@endif
                    <button aria-label="Cari produk" type="submit">⌕</button>
                </form>
            </div>
            <div class="category-filter" role="group" aria-label="Filter kategori">
                <a class="filter-chip {{ $selectedCategory ? '' : 'active' }}" href="{{ route('store', ['q' => $search]) }}">Semua produk</a>
                @foreach ($categories as $category)
                    <a class="filter-chip {{ $selectedCategory === $category->id ? 'active' : '' }}" href="{{ route('store', ['category' => $category->id, 'q' => $search]) }}">{{ $category->name }}</a>
                @endforeach
            </div>
            <div class="product-grid">
                @forelse ($products as $index => $product)
                    <article class="product-card" style="--card-delay: {{ $index % 6 }}">
                        <div class="product-visual">
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" loading="lazy">
                            <span class="product-category">{{ $product->category->name }}</span>
                            <span class="product-number">{{ str_pad((string) ($products->firstItem() + $index), 2, '0', STR_PAD_LEFT) }}</span>
                        </div>
                        <div class="product-info">
                            <h3>{{ $product->name }}</h3><p>{{ Str::limit($product->description, 76) }}</p>
                            <div class="product-bottom"><strong>Rp {{ number_format($product->price, 0, ',', '.') }}</strong><span>Tersedia {{ $product->stock }}</span></div>
                        </div>
                    </article>
                @empty
                    <div class="empty-products"><strong>Belum ada produk di sini.</strong><p>Coba kategori lain atau kata kunci yang berbeda.</p></div>
                @endforelse
            </div>
            <div class="pagination-wrap">{{ $products->links() }}</div>
        </section>

        <section class="closing-band">
            <div class="closing-orbit" aria-hidden="true"></div><p class="eyebrow light">BERDAYA DARI DAERAH</p>
            <h2>Setiap pilihan punya<br><em>arti bagi sesama.</em></h2>
            <p>Kenali pelaku usaha dan produk unggulan dari 16 kecamatan di Rokan Hulu.</p>
        </section>
    </main>
    <footer class="store-footer">
        <a class="wordmark" href="{{ route('store') }}"><span class="mark">R</span><span>RUANG <b>ROHUL</b></span></a>
        <span>Produk unggulan Kabupaten Rokan Hulu</span><span>© {{ now()->year }} Ruang Rohul</span>
    </footer>
</body>
</html>