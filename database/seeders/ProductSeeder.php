<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use LogicException;

class ProductSeeder extends Seeder
{
    private const PRODUCT_IMAGES = [
        'Madu Sialang 250 ml' => 'photo-1587049352846-4a222e784d38',
        'Keripik Nenas' => 'photo-1566478989037-eec170784d0b',
        'Keripik Pisang Kepok' => 'photo-1573080496219-bb080dd4f877',
        'Dodol Nenas' => 'photo-1751813992865-9dbd7f23e0e4',
        'Kacang Pukul Pasir Pengaraian' => 'photo-1772984959639-54284678b805',
        'Rendang Lokan' => 'photo-1791269003813-714ce9e47d29',
        'Sambal Ikan Salai' => 'photo-1692302756206-3dd7506cb8f0',
        'Kerupuk Sagu' => 'photo-1792055319942-1b44643dfaa1',
        'Kopi Liberika Rokan Hulu 200 g' => 'photo-1442512595331-e89e73853f31',
        'Kopi Robusta Ujung Batu 200 g' => 'photo-1495474472287-4d71bcdd2085',
        'Gula Aren Semut 250 g' => 'photo-1606313564200-e75d5e30476c',
        'Teh Daun Gambir' => 'photo-1544787219-7f47ccb76574',
        'Batik Tulis Rokan Hulu' => 'photo-1761517099330-13b34b141d74',
        'Batik Cap Motif Suluk' => 'photo-1761517100146-f1f3ad9270a2',
        'Songket Melayu Riau' => 'photo-1583391733956-6c78276477e3',
        'Tas Anyaman Pandan' => 'photo-1590874103328-eac38a683ce7',
        'Kopiah Resam Rokan Hulu' => 'photo-1521369909029-2afed882baee',
        'Minyak Kelapa Murni 250 ml' => 'photo-1608571423902-eed4a5ad8108',
        'Kerajinan Lidi Sawit' => 'photo-1494438639946-1ebd1d20bf85',
        'Manisan Kulit Nenas' => 'photo-1499636136210-6f4ee915583e',
    ];

    public function run(): void
    {
        $imageIds = array_values(self::PRODUCT_IMAGES);

        if (count($imageIds) !== count(array_unique($imageIds))) {
            throw new LogicException('Setiap produk harus memakai foto Unsplash yang berbeda.');
        }

        $products = Product::query()
            ->whereIn('name', array_keys(self::PRODUCT_IMAGES))
            ->get()
            ->keyBy('name');

        if ($products->count() !== count(self::PRODUCT_IMAGES)) {
            throw new LogicException('Daftar produk gambar tidak cocok dengan katalog.');
        }

        foreach (self::PRODUCT_IMAGES as $name => $imageId) {
            $products[$name]->update([
                'image_url' => "https://images.unsplash.com/{$imageId}?auto=format&fit=crop&w=900&q=85",
            ]);
        }
    }
}
