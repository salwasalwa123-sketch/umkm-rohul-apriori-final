<?php

namespace App\Services;

use App\Models\Product;
use App\Models\TransactionDetail;
use Illuminate\Support\Collection;

class AprioriAnalyzer
{
    public function analyze(float $minimumSupport, float $minimumConfidence, ?string $dateFrom = null, ?string $dateTo = null): array
    {
        $details = TransactionDetail::query()
            ->whereHas('transaction', function ($query) use ($dateFrom, $dateTo) {
                $query->when($dateFrom, fn ($query) => $query->whereDate('transaction_date', '>=', $dateFrom))
                    ->when($dateTo, fn ($query) => $query->whereDate('transaction_date', '<=', $dateTo));
            })
            ->get(['transaction_id', 'product_id']);

        $baskets = $details->groupBy('transaction_id')
            ->map(fn (Collection $items) => $items->pluck('product_id')->unique()->sort()->values()->all())
            ->values();
        $transactionCount = $baskets->count();

        if ($transactionCount === 0) {
            return ['transaction_count' => 0, 'itemsets' => [], 'rules' => [], 'packages' => []];
        }

        $minimumCount = max(1, (int) ceil($minimumSupport * $transactionCount));
        $productIds = $baskets->flatten()->unique()->sort()->values()->all();
        $supportCounts = [];

        foreach ($productIds as $productId) {
            $supportCounts[implode(',', [$productId])] = $this->countContaining($baskets, [$productId]);
        }

        $levels = [];
        $frequentSingles = array_values(array_filter(
            array_map(fn ($productId) => [$productId], $productIds),
            fn ($itemset) => $supportCounts[implode(',', $itemset)] >= $minimumCount,
        ));
        $levels[1] = $frequentSingles;

        for ($size = 2; $size <= 3; $size++) {
            $candidates = $this->candidates($levels[$size - 1] ?? [], $size);
            $frequent = [];

            foreach ($candidates as $candidate) {
                $key = implode(',', $candidate);
                $supportCounts[$key] = $this->countContaining($baskets, $candidate);

                if ($supportCounts[$key] >= $minimumCount) {
                    $frequent[] = $candidate;
                }
            }

            $levels[$size] = $frequent;
        }

        $idsInResults = collect($levels)->flatten(1)->flatten()->unique()->all();
        $names = Product::query()->whereIn('id', $idsInResults)->pluck('name', 'id');
        $itemsets = [];
        $rules = [];
        $packages = [];

        foreach ($levels as $size => $itemsetsAtSize) {
            foreach ($itemsetsAtSize as $itemset) {
                $count = $supportCounts[implode(',', $itemset)];
                $products = collect($itemset)->map(fn ($id) => ['id' => $id, 'name' => $names[$id] ?? 'Produk dihapus'])->all();
                $entry = ['products' => $products, 'count' => $count, 'support' => $count / $transactionCount];
                $itemsets[] = $entry;

                if ($size > 1) {
                    $packages[] = $entry;

                    foreach ($this->partitions($itemset) as [$antecedent, $consequent]) {
                        $antecedentCount = $supportCounts[implode(',', $antecedent)]
                            ?? $this->countContaining($baskets, $antecedent);
                        $consequentCount = $supportCounts[implode(',', $consequent)]
                            ?? $this->countContaining($baskets, $consequent);
                        $confidence = $antecedentCount > 0 ? $count / $antecedentCount : 0;
                        $lift = $consequentCount > 0 ? $confidence / ($consequentCount / $transactionCount) : 0;

                        if ($confidence >= $minimumConfidence) {
                            $rules[] = [
                                'antecedent' => collect($antecedent)->map(fn ($id) => $names[$id] ?? 'Produk dihapus')->all(),
                                'consequent' => collect($consequent)->map(fn ($id) => $names[$id] ?? 'Produk dihapus')->all(),
                                'support' => $count / $transactionCount,
                                'confidence' => $confidence,
                                'lift' => $lift,
                            ];
                        }
                    }
                }
            }
        }

        usort($rules, fn ($left, $right) => [$right['confidence'], $right['lift'], $right['support']] <=> [$left['confidence'], $left['lift'], $left['support']]);
        usort($packages, fn ($left, $right) => [$right['count'], count($right['products'])] <=> [$left['count'], count($left['products'])]);

        return [
            'transaction_count' => $transactionCount,
            'itemsets' => $itemsets,
            'rules' => $rules,
            'packages' => array_slice($packages, 0, 5),
        ];
    }

    private function countContaining(Collection $baskets, array $items): int
    {
        return $baskets->filter(fn ($basket) => count(array_diff($items, $basket)) === 0)->count();
    }

    private function candidates(array $previousLevel, int $size): array
    {
        $candidates = [];
        $count = count($previousLevel);

        for ($left = 0; $left < $count; $left++) {
            for ($right = $left + 1; $right < $count; $right++) {
                $candidate = array_values(array_unique(array_merge($previousLevel[$left], $previousLevel[$right])));
                sort($candidate);

                if (count($candidate) !== $size) {
                    continue;
                }

                $allSubsetsFrequent = true;
                foreach ($this->subsets($candidate, $size - 1) as $subset) {
                    if (! in_array($subset, $previousLevel, true)) {
                        $allSubsetsFrequent = false;
                        break;
                    }
                }

                if ($allSubsetsFrequent) {
                    $candidates[implode(',', $candidate)] = $candidate;
                }
            }
        }

        return array_values($candidates);
    }

    private function partitions(array $items): array
    {
        $partitions = [];
        for ($size = 1; $size < count($items); $size++) {
            foreach ($this->subsets($items, $size) as $antecedent) {
                $consequent = array_values(array_diff($items, $antecedent));
                $partitions[] = [$antecedent, $consequent];
            }
        }

        return $partitions;
    }

    private function subsets(array $items, int $size): array
    {
        if ($size === 1) {
            return array_map(fn ($item) => [$item], $items);
        }

        $subsets = [];
        foreach ($items as $index => $item) {
            foreach ($this->subsets(array_slice($items, $index + 1), $size - 1) as $tail) {
                $subsets[] = array_merge([$item], $tail);
            }
        }

        return $subsets;
    }
}
