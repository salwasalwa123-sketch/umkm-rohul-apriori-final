@extends('layouts.admin')

@section('title', 'Kategori')
@section('crumb', 'Kategori')

@section('content')
    <div class="page-heading">
        <div><p class="eyebrow">SUSUN KATALOG</p><h1>Kelola <em>kategori.</em></h1><p class="page-subtitle">Kelompokkan produk agar mudah ditemukan pembeli.</p></div>
        <a class="button button-dark" href="{{ route('admin.categories.create') }}"><span aria-hidden="true">＋</span> Kategori baru</a>
    </div>
    <section class="content-panel wide">
        <div class="content-panel-title"><div><h2>Daftar kategori</h2><p>{{ $categories->total() }} kategori terdaftar</p></div></div>
        <div class="table-scroll"><table class="data-table"><thead><tr><th>NAMA KATEGORI</th><th>JUMLAH PRODUK</th><th>DIBUAT</th><th>AKSI</th></tr></thead><tbody>
            @forelse ($categories as $category)
                <tr>
                    <td><strong>{{ $category->name }}</strong></td><td>{{ $category->products_count }} produk</td><td>{{ $category->created_at->format('d M Y') }}</td>
                    <td><div class="table-actions"><a href="{{ route('admin.categories.edit', $category) }}">Ubah</a><form class="inline-form" method="POST" action="{{ route('admin.categories.destroy', $category) }}" onsubmit="return confirm('Hapus kategori ini?')">@csrf @method('DELETE')<button type="submit">Hapus</button></form></div></td>
                </tr>
            @empty
                <tr><td colspan="4" class="table-empty">Belum ada kategori.</td></tr>
            @endforelse
        </tbody></table></div>
        <div class="pagination-links">{{ $categories->links() }}</div>
    </section>
@endsection