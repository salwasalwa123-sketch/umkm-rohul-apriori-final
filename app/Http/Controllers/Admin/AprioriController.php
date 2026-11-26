<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AprioriAnalyzer;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AprioriController extends Controller
{
    public function __invoke(Request $request, AprioriAnalyzer $analyzer): View
    {
        $filters = $request->validate([
            'min_support' => ['nullable', 'numeric', 'gt:0', 'lte:100'],
            'min_confidence' => ['nullable', 'numeric', 'gt:0', 'lte:100'],
            'date_from' => ['nullable', 'date'],
            'date_to' => ['nullable', 'date', 'after_or_equal:date_from'],
        ]);
        $support = (float) ($filters['min_support'] ?? 20) / 100;
        $confidence = (float) ($filters['min_confidence'] ?? 50) / 100;
        $results = $analyzer->analyze($support, $confidence, $filters['date_from'] ?? null, $filters['date_to'] ?? null);

        return view('admin.apriori', [
            'filters' => $filters,
            'minimumSupport' => $support,
            'minimumConfidence' => $confidence,
            ...$results,
        ]);
    }
}
