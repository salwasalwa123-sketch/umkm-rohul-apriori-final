<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class TransactionController extends Controller
{
    public function index(): View
    {
        return view('admin.transactions.index', ['transactions' => Transaction::with('products')->latest('transaction_date')->paginate(15)]);
    }

    public function create(): View
    {
        return view('admin.transactions.create', ['products' => Product::where('stock', '>', 0)->orderBy('name')->get()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'transaction_date' => ['required', 'date'],
            'items' => ['required', 'array'],
            'items.*' => ['nullable', 'integer', 'min:0'],
        ]);
        $items = collect($data['items'])->filter(fn ($qty) => (int) $qty > 0);

        if ($items->isEmpty()) {
            return back()->withErrors(['items' => 'Pilih setidaknya satu produk.'])->withInput();
        }

        try {
            $transaction = DB::transaction(function () use ($data, $items) {
                $products = Product::whereIn('id', $items->keys())->lockForUpdate()->get()->keyBy('id');

                foreach ($items as $productId => $qty) {
                    if (! isset($products[$productId]) || $products[$productId]->stock < (int) $qty) {
                        throw new \DomainException('Stok produk berubah atau tidak mencukupi. Periksa kembali jumlah yang dipilih.');
                    }
                }

                $transaction = Transaction::create([
                    'transaction_code' => 'TRX-'.now()->format('ymd').'-'.Str::upper(Str::random(5)),
                    'transaction_date' => $data['transaction_date'],
                ]);

                foreach ($items as $productId => $qty) {
                    $transaction->details()->create(['product_id' => $productId, 'qty' => (int) $qty]);
                    $products[$productId]->decrement('stock', (int) $qty);
                }

                return $transaction;
            });
        } catch (\DomainException $exception) {
            return back()->withErrors(['items' => $exception->getMessage()])->withInput();
        }

        return redirect()->route('admin.transactions.index')->with('success', 'Transaksi '.$transaction->transaction_code.' berhasil disimpan.');
    }
}
