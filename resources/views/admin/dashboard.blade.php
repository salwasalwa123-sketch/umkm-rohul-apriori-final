@extends('layouts.admin')

@section('title', 'Ringkasan')
@section('crumb', 'Ringkasan')

@section('content')
    <div class="page-heading">
        <div><p class="eyebrow">SELAMAT DATANG, {{ strtoupper(auth()->user()->name) }}</p><h1>Ringkasan <em>usaha.</em></h1><p class="page-subtitle">Pantau katalog dan aktivitas penjualan UMKM Rokan Hulu.</p></div>
        <a class="button button-dark" href="{{ route('admin.transactions.create') }}"><span aria-hidden="true">＋</span> Catat transaksi</a>
    </div>
    <section class="metric-grid" aria-label="Statistik utama">
        <article class="metric-card metric-green"><span class="metric-label">TOTAL PRODUK</span><strong>{{ number_format($productCount) }}</strong><span class="metric-note">Produk aktif di katalog</span><span class="metric-symbol">◫</span></article>
        <article class="metric-card metric-yellow"><span class="metric-label">KATEGORI</span><strong>{{ number_format($categoryCount) }}</strong><span class="metric-note">Kelompok produk</span><span class="metric-symbol">▤</span></article>
        <article class="metric-card metric-coral"><span class="metric-label">TRANSAKSI</span><strong>{{ number_format($transactionCount) }}</strong><span class="metric-note">Total transaksi tercatat</span><span class="metric-symbol">⇄</span></article>
        <article class="metric-card metric-white"><span class="metric-label">OMZET TERKUMPUL</span><strong class="metric-currency">Rp {{ number_format($revenue, 0, ',', '.') }}</strong><span class="metric-note">Dari seluruh transaksi</span><span class="metric-symbol">↗</span></article>
    </section>
    <section class="dashboard-grid">
        <article class="panel sales-panel">
            <div class="panel-heading"><div><p class="eyebrow">AKTIVITAS 7 HARI</p><h2>Pergerakan <em>penjualan</em></h2></div><span class="panel-unit">RUPIAH</span></div>
            <div class="sales-chart" role="img" aria-label="Grafik penjualan tujuh hari terakhir">
                @foreach ($chart as $point)
                    <div class="chart-column"><div class="bar-track"><span class="chart-bar" style="height: {{ $point['total'] ? max(5, ($point['total'] / $chartMax) * 100) : 2 }}%" title="Rp {{ number_format($point['total'], 0, ',', '.') }}"></span></div><span class="chart-label">{{ $point['label'] }}</span></div>
                @endforeach
            </div>
        </article>
        <article class="panel quick-panel">
            <div class="panel-heading"><div><p class="eyebrow">LANGKAH CEPAT</p><h2>Kelola <em>hari ini.</em></h2></div></div>
            <a class="quick-link" href="{{ route('admin.products.create') }}"><span class="quick-number">01</span><span><b>Tambah produk</b><small>Perbarui pilihan katalog</small></span><span class="quick-arrow">↗</span></a>
            <a class="quick-link" href="{{ route('admin.categories.create') }}"><span class="quick-number">02</span><span><b>Buat kategori</b><small>Susun katalog lebih rapi</small></span><span class="quick-arrow">↗</span></a>
            <a class="quick-link" href="{{ route('admin.apriori') }}"><span class="quick-number">03</span><span><b>Lihat analisis</b><small>Temukan produk yang sering dibeli</small></span><span class="quick-arrow">↗</span></a>
        </article>
    </section>
    <section class="panel recent-panel">
        <div class="panel-heading"><div><p class="eyebrow">AKTIVITAS TERBARU</p><h2>Transaksi <em>terkini.</em></h2></div><a class="text-link" href="{{ route('admin.transactions.index') }}">Semua transaksi <span aria-hidden="true">→</span></a></div>
        @if ($recentTransactions->isEmpty())
            <div class="table-empty">Belum ada transaksi. Catat transaksi pertama untuk mulai melihat aktivitas penjualan.</div>
        @else
            <div class="table-scroll"><table class="data-table"><thead><tr><th>KODE</th><th>TANGGAL</th><th>PRODUK</th><th>JUMLAH ITEM</th></tr></thead><tbody>
                @foreach ($recentTransactions as $transaction)
                    <tr><td><strong>{{ $transaction->transaction_code }}</strong></td><td>{{ $transaction->transaction_date->format('d M Y') }}</td><td>{{ $transaction->products->pluck('name')->take(2)->join(', ') }}{{ $transaction->products->count() > 2 ? ' +' . ($transaction->products->count() - 2) . ' produk' : '' }}</td><td>{{ $transaction->products->sum('pivot.qty') }}</td></tr>
                @endforeach
            </tbody></table></div>
        @endif
    </section>
@endsection