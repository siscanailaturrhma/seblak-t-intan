# Prompt Claude --- Website Menu dan Pemesanan Seblak

Saya ingin membuat sebuah website bernama **Menu dan Pemesanan Seblak**
sebagai project pengembangan web.

Project ini bertujuan untuk membantu pelanggan melihat menu dan memesan
seblak secara online, sekaligus membantu pemilik usaha mengelola menu
dan pesanan melalui sistem admin.

**Teknologi yang WAJIB digunakan:** - Backend: Laravel - Database:
MySQL - Admin Panel: Filament - Frontend: Blade, HTML, CSS, dan
JavaScript - Framework CSS: Tailwind CSS jika diperlukan

Jangan mengganti teknologi tersebut dengan PHP native, React, atau
framework lain.

## 1. Konsep Utama Website

Website memiliki dua bagian utama:

1.  Halaman publik yang dapat diakses pelanggan.
2.  Halaman admin untuk pemilik usaha.

Website harus memiliki desain modern, responsif, mudah digunakan, dan
sesuai dengan tema usaha kuliner seblak.

## 2. Fitur Halaman Publik

### A. Beranda

-   Menampilkan nama dan logo usaha.
-   Menampilkan profil usaha.
-   Menampilkan foto produk seblak.
-   Menyediakan navigasi menuju menu, lokasi, dan testimoni.

### B. Menu dan Harga

-   Menampilkan daftar menu seblak beserta foto, nama, deskripsi, dan
    harga.
-   Menampilkan kategori menu.
-   Menampilkan informasi produk yang tersedia.
-   Menyediakan tombol untuk memilih menu dan melakukan pemesanan.

### C. Kustomisasi Pesanan

Pelanggan dapat: - Memilih menu seblak. - Memilih level pedas. - Memilih
satu atau beberapa topping tambahan. - Menentukan jumlah pesanan. -
Melihat total harga yang dihitung secara otomatis berdasarkan menu,
topping, dan jumlah yang dipilih.

### D. Pemesanan Online

-   Menyimpan data pesanan ke database MySQL.
-   Menyimpan rincian menu, level pedas, topping, jumlah, dan total
    harga.
-   Setelah pesanan berhasil disimpan, pelanggan diarahkan ke WhatsApp
    untuk konfirmasi pembayaran.
-   Pesan WhatsApp berisi informasi pesanan yang relevan.

### E. Profil Usaha

-   Menampilkan informasi mengenai usaha seblak.
-   Menjelaskan produk dan keunggulan usaha.

### F. Lokasi

-   Menampilkan alamat usaha.
-   Menampilkan lokasi melalui peta.

### G. Testimoni

-   Menampilkan ulasan atau testimoni pelanggan.

## 3. Fitur Admin Menggunakan Filament

Gunakan Filament sebagai admin panel untuk mengelola data website.

### A. Dashboard

-   Menampilkan jumlah menu.
-   Menampilkan jumlah kategori.
-   Menampilkan jumlah pesanan yang masuk.

### B. Manajemen Menu (CRUD)

Admin dapat: - Menambahkan menu. - Melihat daftar menu. - Mengubah nama,
harga, deskripsi, foto, dan kategori menu. - Menghapus menu.

### C. Manajemen Kategori (CRUD)

Admin dapat: - Menambahkan kategori. - Melihat daftar kategori. -
Mengubah kategori. - Menghapus kategori.

### D. Manajemen Topping (CRUD)

Admin dapat: - Menambahkan topping beserta harga. - Melihat daftar
topping. - Mengubah informasi topping. - Menghapus topping.

### E. Manajemen Pesanan

Admin dapat: - Melihat daftar seluruh pesanan yang masuk. - Melihat
detail pesanan pelanggan. - Melihat menu, level pedas, topping, jumlah,
dan total harga setiap pesanan.

## 4. Ketentuan Database

Gunakan MySQL dengan struktur tabel yang terorganisir dan memiliki
relasi yang benar.

Tabel yang diperlukan meliputi: - `admins` atau `users` untuk
autentikasi admin. - `categories` untuk kategori menu. - `menus` untuk
data menu. - `toppings` untuk data topping. - `orders` untuk data
pesanan. - `order_items` untuk detail menu dalam pesanan. -
`order_item_toppings` untuk topping yang dipilih. - `testimonials` untuk
testimoni pelanggan.

Gunakan Laravel Migration, Eloquent Model, dan relasi antarmodel agar
pengelolaan data lebih terstruktur.

## 5. Ketentuan Desain

Buat desain yang: - Modern dan minimalis. - Memiliki nuansa warna yang
sesuai dengan makanan seblak. - Menggunakan card untuk menampilkan
produk. - Memiliki navigasi yang jelas. - Responsif di desktop dan
smartphone. - Memiliki tampilan admin yang rapi melalui Filament. -
Mudah dipahami oleh pengguna.

## 6. Ketentuan Pengerjaan

Saya masih belajar Laravel, jadi berikan panduan secara bertahap dan
jelas.

Urutan pengerjaan:

1.  Menentukan versi Laravel dan Filament yang kompatibel.
2.  Menyiapkan project dan konfigurasi database MySQL.
3.  Membuat struktur database menggunakan Migration.
4.  Membuat Model dan relasi Eloquent.
5.  Membuat admin panel menggunakan Filament.
6.  Membuat CRUD menu, kategori, dan topping.
7.  Membuat dashboard admin.
8.  Membuat halaman publik menggunakan Blade.
9.  Membuat fitur kustomisasi pesanan.
10. Membuat perhitungan harga otomatis.
11. Membuat penyimpanan pesanan ke database.
12. Membuat integrasi WhatsApp untuk konfirmasi pembayaran.
13. Melakukan pengujian seluruh fitur.

Untuk setiap tahap: - Jelaskan file yang harus dibuat atau diubah. -
Berikan kode lengkap yang siap digunakan. - Jelaskan lokasi file dalam
struktur project Laravel. - Berikan instruksi terminal yang harus
dijalankan. - Jelaskan cara menguji hasilnya. - Pastikan kode pada tahap
sebelumnya tetap kompatibel dengan tahap berikutnya.

Jangan memberikan kode yang terpotong atau hanya berupa contoh jika saya
meminta implementasi lengkap.

**PENTING: Pertahankan konsep utama website menu dan pemesanan seblak
ini sesuai deskripsi project. Jangan menambahkan fitur yang tidak
diminta atau mengubah alur utama sistem.**

Mulailah dari tahap pertama dan bimbing saya sampai website selesai
serta dapat dijalankan dengan baik.
