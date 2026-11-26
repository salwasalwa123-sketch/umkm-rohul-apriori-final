@extends('layouts.admin')

@section('title', 'Transaksi')
@section('crumb', 'Transaksi')

@section('content')
    <div class="page-heading"><div><p class="eyebrow">DATA PENJUALAN</p><h1>Catatan <em>transaksi.</em></h1><p class="page-subtitle">Setiap transaksi menjadi sumber data pola pembelian.</p></div><a class="button button-dark" href="{{ route('admin.transactions.create') }}"><span aria-hidden="true">＋</span> Catat transaksi</a></div>
    <section class="content-panel wide">
        <div class="content-panel-title"><div><h2>Riwayat transaksi</h2><p>{{ $transactions->total() }} transaksi tercatat</p></div></div>
        <div class="table-scroll"><table class="data-table"><thead><tr><th>KODE TRANSAKSI</th><th>TANGGAL</th><th>PRODUK DALAM KERANJANG</th><th>ITEM</th><th>TOTAL</th></tr></thead><tbody>
            @forelse ($transactions as $transaction)
                @php($total = $transaction->products->sum(fn ($product) => $product->price * $product->pivot->qty))
                <tr><td><strong>{{ $transaction->transaction_code }}</strong></td><td>{{ $transaction->transaction_date->format('d M Y') }}</td><td>{{ $transaction->products->pluck('name')->join(', ') }}</td><td>{{ $transaction->products->sum('pivot.qty') }}</td><td><strong>Rp {{ number_format($total, 0, ',', '.') }}</strong></td></tr>
            @empty
                <tr><td colspan="5" class="table-empty">Belum ada transaksi. Catat beberapa produk dalam satu keranjang.</td></tr>
            @endforelse
        </tbody></table></div>
        <div class="pagination-links">{{ $transactions->links() }}</div>
    </section>
@endsection