<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $start = now()->subDays(6)->startOfDay();
        $sales = TransactionDetail::query()
            ->join('transactions', 'transactions.id', '=', 'transaction_details.transaction_id')
            ->join('products', 'products.id', '=', 'transaction_details.product_id')
            ->whereDate('transactions.transaction_date', '>=', $start)
            ->selectRaw('transactions.transaction_date as day, SUM(transaction_details.qty * products.price) as total')
            ->groupBy('transactions.transaction_date')
            ->pluck('total', 'day');

        $chart = collect(range(6, 0))->map(function (int $offset) use ($sales) {
            $date = now()->subDays($offset);

            return ['label' => $date->translatedFormat('D'), 'date' => $date->toDateString(), 'total' => (int) ($sales[$date->toDateString()] ?? 0)];
        });

        return view('admin.dashboard', [
            'productCount' => Product::count(),
            'categoryCount' => Category::count(),
            'transactionCount' => Transaction::count(),
            'revenue' => (int) TransactionDetail::query()
                ->join('products', 'products.id', '=', 'transaction_details.product_id')
                ->selectRaw('COALESCE(SUM(transaction_details.qty * products.price), 0) as revenue')
                ->value('revenue'),
            'recentTransactions' => Transaction::with('products')->latest('transaction_date')->limit(6)->get(),
            'chart' => $chart,
            'chartMax' => max(1, (int) $chart->max('total')),
        ]);
    }
}
