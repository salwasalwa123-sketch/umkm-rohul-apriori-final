# 🛍️ Sistem Informasi UMKM Rokan Hulu + Algoritma Apriori

*Nama:* Salwa - Teknik Informatika  
*Lokasi:* Pekanbaru, Riau  
*Proyek:* UMKM Rokan Hulu dengan Rekomendasi Produk Apriori

### 🔗 Link Demo Lokal
http://127.0.0.1:8000

Login Admin:
- Email: admin@rohul.go.id
- Password: password

### 📝 Prompt yang Digunakan di Kiro

Proyek ini dibuat menggunakan *Kiro AI (VS Code Agent)* dengan 2 prompt:

1.  *Prompt Utama (PROMPT-KIRO.md):* Membuat sistem Laravel lengkap: CRUD kategori, produk, transaksi, dashboard, dan halaman /apriori dengan hitungan support, confidence, lift ratio.
2.  *Prompt Perbaikan (PROMPT-2-PERBAIKAN-FOTO.md):* Memperbaiki bug foto produk yang tidak sesuai (misal Madu Sialang pakai foto semangka, Kacang Pukul pakai foto salad) menjadi foto relevan dengan Unsplash.

### ✨ Fitur Utama

- Landing Page UMKM Rohul (Madu Sialang, Keripik Nanas, Batik Rohul, dll)
- CRUD Produk & Kategori (AdminLTE + Tailwind)
- Halaman Transaksi (pilih multi produk = data Apriori)
- Dashboard Grafik Penjualan
- Halaman /apriori - Input min_support, min_confidence, periode tanggal -> Output "Jika beli A maka beli B"

### 🚀 Cara Install

```bash
git clone https://github.com/salwasalwa123-sketch/umkm-rohul-apriori-final
cd umkm-rohul-apriori-final
composer install
cp .env.example .env
# ubah DB_DATABASE jadi umkm_rohul
php artisan key:generate
php artisan migrate --seed
npm install && npm run build
php artisan serve
