@extends('layouts.admin')

@section('title', 'Transaksi baru')
@section('crumb', 'Transaksi baru')

@section('content')
    <div class="page-heading"><div><p class="eyebrow">DATA PENJUALAN</p><h1>Catat <em>transaksi.</em></h1><p class="page-subtitle">Masukkan jumlah setiap produk yang dibeli pada keranjang ini.</p></div></div>
    <section class="content-panel wide">
        <form method="POST" action="{{ route('admin.transactions.store') }}">
            @csrf
            <div class="form-group" style="max-width:260px; margin-bottom:22px"><label class="field-label" for="transaction_date">Tanggal transaksi</label><input class="text-field" id="transaction_date" type="date" name="transaction_date" value="{{ old('transaction_date', now()->toDateString()) }}" required>@error('transaction_date')<p class="field-error">{{ $message }}</p>@enderror</div>
            <div class="content-panel-title"><div><h2>Pilih produk</h2><p>Gunakan jumlah 0 jika produk tidak termasuk keranjang.</p></div></div>
            @error('items')<p class="field-error">{{ $message }}</p>@enderror
            <div class="item-picker">
                @forelse ($products as $product)
                    <label class="pick-row"><span class="pick-product">{{ $product->name }}<small>{{ $product->category->name }} · Rp {{ number_format($product->price, 0, ',', '.') }}</small></span><span class="pick-stock">Stok {{ $product->stock }}</span><input type="number" name="items[{{ $product->id }}]" value="{{ old('items.'.$product->id, 0) }}" min="0" max="{{ $product->stock }}" aria-label="Jumlah {{ $product->name }}"></label>
                @empty
                    <div class="table-empty">Tidak ada produk dengan stok tersedia.</div>
                @endforelse
            </div>
            <div class="form-actions"><button class="button button-dark" type="submit">Simpan transaksi <span aria-hidden="true">↗</span></button><a class="secondary-button" href="{{ route('admin.transactions.index') }}">Batal</a></div>
        </form>
    </section>
@endsection