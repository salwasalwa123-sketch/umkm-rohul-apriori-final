@extends('layouts.admin')

@section('title', 'Analisis Apriori')
@section('crumb', 'Analisis Apriori')

@section('content')
    <div class="page-heading"><div><p class="eyebrow">POLA KERANJANG BELANJA</p><h1>Analisis <em>Apriori.</em></h1><p class="page-subtitle">Cari produk yang cenderung dibeli bersama untuk menyusun rekomendasi paket.</p></div></div>
    <section class="content-panel wide">
        <div class="content-panel-title"><div><h2>Parameter analisis</h2><p>Support dihitung dari transaksi yang masuk periode; confidence dari transaksi yang memuat antecedent.</p></div></div>
        <form class="filter-form" method="GET" action="{{ route('admin.apriori') }}">
            <div class="form-group"><label class="field-label" for="min_support">Minimum support (%)</label><input class="text-field" id="min_support" type="number" name="min_support" value="{{ old('min_support', $filters['min_support'] ?? 20) }}" min="1" max="100" step="1" required>@error('min_support')<p class="field-error">{{ $message }}</p>@enderror</div>
            <div class="form-group"><label class="field-label" for="min_confidence">Minimum confidence (%)</label><input class="text-field" id="min_confidence" type="number" name="min_confidence" value="{{ old('min_confidence', $filters['min_confidence'] ?? 50) }}" min="1" max="100" step="1" required>@error('min_confidence')<p class="field-error">{{ $message }}</p>@enderror</div>
            <div class="form-group"><label class="field-label" for="date_from">Dari tanggal</label><input class="text-field" id="date_from" type="date" name="date_from" value="{{ $filters['date_from'] ?? '' }}"></div>
            <div class="form-group"><label class="field-label" for="date_to">Sampai tanggal</label><input class="text-field" id="date_to" type="date" name="date_to" value="{{ $filters['date_to'] ?? '' }}">@error('date_to')<p class="field-error">{{ $message }}</p>@enderror</div>
            <button class="button button-dark" type="submit">Jalankan analisis <span aria-hidden="true">↗</span></button>
        </form>
        <div class="apriori-overview"><span>Transaksi dianalisis <strong>{{ number_format($transaction_count) }}</strong></span><span>Support minimum <strong>{{ number_format($minimumSupport * 100, 1) }}%</strong></span><span>Confidence minimum <strong>{{ number_format($minimumConfidence * 100, 1) }}%</strong></span><span>Frequent itemset <strong>{{ count($itemsets) }}</strong></span></div>
    </section>

    <section class="content-panel wide" style="margin-top:15px">
        <div class="content-panel-title"><div><h2>Aturan asosiasi</h2><p>Jika produk pada sisi kiri dibeli, sisi kanan berpeluang ikut terbeli. Lift di atas 1 menunjukkan asosiasi positif.</p></div></div>
        <div class="table-scroll"><table class="data-table"><thead><tr><th>JIKA BELI</th><th>MAKA BELI</th><th>SUPPORT</th><th>CONFIDENCE</th><th>LIFT</th></tr></thead><tbody>
            @forelse ($rules as $rule)
                <tr><td><span class="rule-products">{{ implode(', ', $rule['antecedent']) }}</span></td><td><span class="rule-products">{{ implode(', ', $rule['consequent']) }}</span></td><td><span class="metric-inline">{{ number_format($rule['support'] * 100, 1) }}%</span></td><td><span class="metric-inline">{{ number_format($rule['confidence'] * 100, 1) }}%</span></td><td><span class="lift-positive">{{ number_format($rule['lift'], 2) }}</span></td></tr>
            @empty
                <tr><td colspan="5" class="table-empty">Belum ada aturan yang memenuhi ambang. Turunkan support/confidence atau perluas periode transaksi.</td></tr>
            @endforelse
        </tbody></table></div>
    </section>

    <section class="dashboard-grid apriori-lower">
        <article class="content-panel wide">
            <div class="content-panel-title"><div><h2>Paket produk potensial</h2><p>Kombinasi 2-3 produk terurut berdasarkan frekuensi muncul di keranjang.</p></div></div>
            <div class="table-scroll"><table class="data-table"><thead><tr><th>PRODUK DALAM PAKET</th><th>TRANSAKSI</th><th>SUPPORT</th></tr></thead><tbody>
                @forelse ($packages as $package)
                    <tr><td><div class="itemset-cell">@foreach ($package['products'] as $product)<span class="itemset-chip">{{ $product['name'] }}</span>@endforeach</div></td><td>{{ $package['count'] }}</td><td>{{ number_format($package['support'] * 100, 1) }}%</td></tr>
                @empty
                    <tr><td colspan="3" class="table-empty">Belum ada kombinasi frequent pada ambang ini.</td></tr>
                @endforelse
            </tbody></table></div>
        </article>
        <article class="content-panel wide">
            <div class="content-panel-title"><div><h2>Frequent itemset</h2><p>Support untuk itemset ukuran 1, 2, dan 3.</p></div></div>
            <div class="table-scroll"><table class="data-table"><thead><tr><th>UKURAN</th><th>ITEMSET</th><th>SUPPORT</th></tr></thead><tbody>
                @forelse ($itemsets as $itemset)
                    <tr><td>{{ count($itemset['products']) }} item</td><td><div class="itemset-cell">@foreach ($itemset['products'] as $product)<span class="itemset-chip">{{ $product['name'] }}</span>@endforeach</div></td><td>{{ number_format($itemset['support'] * 100, 1) }}%</td></tr>
                @empty
                    <tr><td colspan="3" class="table-empty">Belum ada itemset yang memenuhi minimum support.</td></tr>
                @endforelse
            </tbody></table></div>
        </article>
    </section>
@endsection