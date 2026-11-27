Buatkan sistem informasi UMKM Rokan Hulu dengan algoritma Apriori untuk rekomendasi produk. Gunakan project Laravel yang sudah ada di C:\xampp\htdocs\umkm-rohul-apriori ini.

Fitur yang harus dibuat:

1. Setup Awal:
- Ubah .env DB_DATABASE menjadi umkm_rohul
- Install Laravel Breeze untuk login (composer require laravel/breeze --dev, php artisan breeze:install blade, npm install && npm run build)
- Buat database umkm_rohul di MySQL

2. Database & Model:
- categories: id, name
- products: id, category_id, name, price, stock, description
- transactions: id, transaction_code, transaction_date
- transaction_details: id, transaction_id, product_id, qty
- Buat Model dan relasinya + seeder dummy 20 produk UMKM khas Rohul (madu, keripik, batik rohul, dll)

3. Fitur Utama:
- CRUD Kategori & Produk (pakai template AdminLTE / Tailwind yang cantik)
- Halaman Transaksi: pilih beberapa produk sekaligus simpan sebagai 1 transaksi (ini data untuk Apriori)
- Dashboard: total produk, transaksi, grafik penjualan

4. Algoritma Apriori (PENTING):
- Buat halaman /apriori
- Form input: min_support (misal 20%) dan min_confidence (misal 50%) dan periode tanggal
- Proses: hitung support 1-itemset, 2-itemset, 3-itemset dari tabel transaction_details
- Hitung confidence dan lift ratio
- Tampilkan hasilnya dalam tabel: "Jika beli [Produk A] maka beli [Produk B]" dengan support, confidence, lift
- Tampilkan rekomendasi paket produk terlaris untuk UMKM

5. Tampilan:
- Gunakan layout yang modern, responsif, ada sidebar
- Landing page untuk pembeli melihat produk UMKM
- Halaman admin terpisah

Langsung kerjakan semua file: migration, model, controller, route, view. Setelah selesai, jalankan php artisan migrate --seed.
