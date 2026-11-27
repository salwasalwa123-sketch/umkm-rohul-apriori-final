# PROMPT KE-2 - Perbaikan Foto Produk Tidak Sesuai

Prompt ini digunakan setelah prompt pertama, untuk memperbaiki bug foto produk katalog.

---

Foto produk di katalog tidak sesuai. Tolong perbaiki DatabaseSeeder dan ProductSeeder: ganti gambar placeholder salad dan buah random menjadi gambar yang relevan per kategori. Untuk Makanan & Camilan pakai foto makanan tradisional, Madu Sialang pakai foto madu/botol madu, Keripik pakai foto keripik. Gunakan URL unsplash yang relevan atau buat logic agar tidak duplikat gambar yang sama. Setelah itu jalankan php artisan migrate:fresh --seed dan npm run build.
