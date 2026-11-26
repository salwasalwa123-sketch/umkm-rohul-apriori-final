@extends('layouts.admin')

@php($editing = $product->exists)
@section('title', $editing ? 'Ubah produk' : 'Produk baru')
@section('crumb', 'Produk')

@section('content')
    <div class="page-heading"><div><p class="eyebrow">KATALOG UMKM</p><h1>{{ $editing ? 'Ubah' : 'Tambah' }} <em>produk.</em></h1><p class="page-subtitle">Informasi produk ditampilkan untuk pembeli di katalog publik.</p></div></div>
    <section class="content-panel">
        <form method="POST" action="{{ $editing ? route('admin.products.update', $product) : route('admin.products.store') }}">
            @csrf
            @if ($editing) @method('PUT') @endif
            <div class="form-grid">
                <div class="form-group full"><label class="field-label" for="name">Nama produk</label><input class="text-field" id="name" name="name" value="{{ old('name', $product->name) }}" maxlength="180" required>@error('name')<p class="field-error">{{ $message }}</p>@enderror</div>
                <div class="form-group"><label class="field-label" for="category_id">Kategori</label><select class="select-field" id="category_id" name="category_id" required><option value="">Pilih kategori</option>@foreach ($categories as $category)<option value="{{ $category->id }}" @selected(old('category_id', $product->category_id) == $category->id)>{{ $category->name }}</option>@endforeach</select>@error('category_id')<p class="field-error">{{ $message }}</p>@enderror</div>
                <div class="form-group"><label class="field-label" for="price">Harga jual (Rp)</label><input class="text-field" id="price" type="number" name="price" value="{{ old('price', $product->price) }}" min="0" step="500" required>@error('price')<p class="field-error">{{ $message }}</p>@enderror</div>
                <div class="form-group"><label class="field-label" for="stock">Stok tersedia</label><input class="text-field" id="stock" type="number" name="stock" value="{{ old('stock', $product->stock ?? 0) }}" min="0" required>@error('stock')<p class="field-error">{{ $message }}</p>@enderror</div>
                <div class="form-group full"><label class="field-label" for="image_url">URL foto produk</label><input class="text-field" id="image_url" type="url" name="image_url" value="{{ old('image_url', $product->image_url) }}" maxlength="2048" placeholder="https://images.unsplash.com/..." required>@error('image_url')<p class="field-error">{{ $message }}</p>@enderror</div>
                <div class="form-group full"><label class="field-label" for="description">Deskripsi</label><textarea class="textarea-field" id="description" name="description" maxlength="2000" placeholder="Ceritakan bahan, rasa, ukuran, atau proses pembuatannya">{{ old('description', $product->description) }}</textarea>@error('description')<p class="field-error">{{ $message }}</p>@enderror</div>
            </div>
            <div class="form-actions"><button class="button button-dark" type="submit">{{ $editing ? 'Simpan perubahan' : 'Tambah produk' }} <span aria-hidden="true">↗</span></button><a class="secondary-button" href="{{ route('admin.products.index') }}">Batal</a></div>
        </form>
    </section>
@endsection