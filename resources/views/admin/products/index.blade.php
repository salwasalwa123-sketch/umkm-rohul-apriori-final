@extends('layouts.admin')

@section('title', 'Produk')
@section('crumb', 'Produk')

@section('content')
    <div class="page-heading">
        <div><p class="eyebrow">KATALOG UMKM</p><h1>Kelola <em>produk.</em></h1><p class="page-subtitle">Atur harga, stok, dan informasi produk yang tampil di katalog publik.</p></div>
        <a class="button button-dark" href="{{ route('admin.products.create') }}"><span aria-hidden="true">＋</span> Produk baru</a>
    </div>
    <section class="content-panel wide">
        <div class="content-panel-title"><div><h2>Semua produk</h2><p>{{ $products->total() }} produk terdaftar</p></div></div>
        <div class="table-scroll"><table class="data-table"><thead><tr><th>NAMA PRODUK</th><th>KATEGORI</th><th>HARGA</th><th>STOK</th><th>AKSI</th></tr></thead><tbody>
            @forelse ($products as $product)
                <tr><td><strong>{{ $product->name }}</strong></td><td>{{ $product->category->name }}</td><td>Rp {{ number_format($product->price, 0, ',', '.') }}</td><td class="{{ $product->stock < 5 ? 'stock-low' : '' }}">{{ $product->stock }} unit</td>
                    <td><div class="table-actions"><a href="{{ route('admin.products.edit', $product) }}">Ubah</a><form class="inline-form" method="POST" action="{{ route('admin.products.destroy', $product) }}" onsubmit="return confirm('Hapus produk ini?')">@csrf @method('DELETE')<button type="submit">Hapus</button></form></div></td></tr>
            @empty
                <tr><td colspan="5" class="table-empty">Belum ada produk di katalog.</td></tr>
            @endforelse
        </tbody></table></div>
        <div class="pagination-links">{{ $products->links() }}</div>
    </section>
@endsection