@extends('layouts.admin')

@php($editing = $category->exists)
@section('title', $editing ? 'Ubah kategori' : 'Kategori baru')
@section('crumb', 'Kategori')

@section('content')
    <div class="page-heading"><div><p class="eyebrow">SUSUN KATALOG</p><h1>{{ $editing ? 'Ubah' : 'Buat' }} <em>kategori.</em></h1><p class="page-subtitle">Nama kategori akan tampil di katalog publik.</p></div></div>
    <section class="content-panel">
        <form method="POST" action="{{ $editing ? route('admin.categories.update', $category) : route('admin.categories.store') }}">
            @csrf
            @if ($editing) @method('PUT') @endif
            <div class="form-group">
                <label class="field-label" for="name">Nama kategori</label>
                <input class="text-field" id="name" name="name" value="{{ old('name', $category->name) }}" maxlength="120" required autofocus>
                @error('name')<p class="field-error">{{ $message }}</p>@enderror
            </div>
            <div class="form-actions"><button class="button button-dark" type="submit">{{ $editing ? 'Simpan perubahan' : 'Buat kategori' }} <span aria-hidden="true">↗</span></button><a class="secondary-button" href="{{ route('admin.categories.index') }}">Batal</a></div>
        </form>
    </section>
@endsection