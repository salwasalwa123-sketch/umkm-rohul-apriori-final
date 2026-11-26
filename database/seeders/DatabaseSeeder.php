<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@rohul.go.id'],
            ['name' => 'Administrator UMKM', 'password' => Hash::make('password')],
        );

        $catalog = [
            'Makanan & Camilan' => [
                ['Madu Sialang 250 ml', 65000, 35, 'Madu hutan alami dari kawasan Rokan Hulu.'],
                ['Keripik Nenas', 22000, 48, 'Keripik renyah dari nenas pilihan Rokan Hulu.'],
                ['Keripik Pisang Kepok', 18000, 42, 'Camilan pisang dengan rasa gurih-manis.'],
                ['Dodol Nenas', 28000, 26, 'Dodol buah buatan perajin lokal.'],
                ['Kacang Pukul Pasir Pengaraian', 25000, 30, 'Kacang renyah khas Pasir Pengaraian.'],
                ['Rendang Lokan', 45000, 18, 'Olahan lokan berbumbu rempah Melayu.'],
                ['Sambal Ikan Salai', 32000, 24, 'Sambal rumahan dengan ikan salai pilihan.'],
                ['Kerupuk Sagu', 16000, 60, 'Kerupuk sagu ringan untuk teman makan.'],
            ],
            'Kopi & Minuman' => [
                ['Kopi Liberika Rokan Hulu 200 g', 48000, 32, 'Kopi liberika dengan karakter rasa khas.'],
                ['Kopi Robusta Ujung Batu 200 g', 42000, 28, 'Robusta lokal sangrai medium.'],
                ['Gula Aren Semut 250 g', 26000, 40, 'Gula aren alami dari pengrajin desa.'],
                ['Teh Daun Gambir', 24000, 21, 'Seduhan herbal dari tanaman lokal.'],
            ],
            'Kerajinan & Kain' => [
                ['Batik Tulis Rokan Hulu', 185000, 12, 'Batik motif lokal dikerjakan dengan tangan.'],
                ['Batik Cap Motif Suluk', 95000, 16, 'Kain batik motif Suluk khas daerah.'],
                ['Songket Melayu Riau', 320000, 7, 'Tenun songket bernuansa Melayu.'],
                ['Tas Anyaman Pandan', 78000, 14, 'Tas anyaman pandan buatan perajin lokal.'],
                ['Kopiah Resam Rokan Hulu', 65000, 19, 'Kopiah anyaman resam yang ringan.'],
            ],
            'Oleh-oleh & Produk Alam' => [
                ['Minyak Kelapa Murni 250 ml', 52000, 23, 'Minyak kelapa murni produksi rumahan.'],
                ['Kerajinan Lidi Sawit', 38000, 17, 'Kerajinan tangan dari lidi sawit.'],
                ['Manisan Kulit Nenas', 20000, 25, 'Manisan buah dengan rasa segar.'],
            ],
        ];

        $products = [];
        foreach ($catalog as $categoryName => $items) {
            $category = Category::firstOrCreate(['name' => $categoryName]);

            foreach ($items as [$name, $price, $stock, $description]) {
                $products[$name] = Product::firstOrCreate(
                    ['name' => $name],
                    [
                        'category_id' => $category->id,
                        'price' => $price,
                        'stock' => $stock,
                        'description' => $description,
                    ],
                );
            }
        }

        $this->call(ProductSeeder::class);

        if (Transaction::exists()) {
            return;
        }

        $baskets = array_merge(
            array_fill(0, 10, ['Madu Sialang 250 ml', 'Keripik Nenas', 'Kopi Liberika Rokan Hulu 200 g']),
            array_fill(0, 8, ['Madu Sialang 250 ml', 'Keripik Nenas']),
            array_fill(0, 5, ['Keripik Nenas', 'Batik Tulis Rokan Hulu']),
            array_fill(0, 5, ['Kopi Liberika Rokan Hulu 200 g', 'Gula Aren Semut 250 g']),
            array_fill(0, 4, ['Madu Sialang 250 ml', 'Batik Tulis Rokan Hulu', 'Kopi Liberika Rokan Hulu 200 g']),
        );

        foreach ($baskets as $index => $basket) {
            $transaction = Transaction::create([
                'transaction_code' => 'DEMO-'.str_pad((string) ($index + 1), 4, '0', STR_PAD_LEFT),
                'transaction_date' => now()->subDays($index % 45)->toDateString(),
            ]);

            foreach ($basket as $name) {
                $transaction->details()->create([
                    'product_id' => $products[$name]->id,
                    'qty' => 1,
                ]);
            }
        }
    }
}
