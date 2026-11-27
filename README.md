# 🌱 EcoBite | Platform Surplus Makanan UMKM

> **Submission Project Weekly Class 2 | GDGoC Universitas Gunadarma**
> **Tema:** Tech for Good (Solve Social & Green Issues, SDG 12: Responsible Consumption and Production)
> **Pembuat:** Krisna Valencia Hidayat

---

## 📌 1. Deskripsi Proyek

**EcoBite** adalah aplikasi web berbasis Laravel yang membantu UMKM kuliner lokal menjual sisa porsi makanan yang masih layak konsumsi dengan harga diskon di akhir hari.

**Masalah:** UMKM kuliner sering memiliki makanan layak di akhir hari yang tidak terjual lalu terbuang, sementara masyarakat dan mahasiswa mencari makanan yang lebih terjangkau.

**Solusi:** UMKM mengunggah porsi surplus, pembeli mengklaimnya lewat katalog, lalu mengambilnya di lokasi pada jam yang ditentukan. Makanan terselamatkan dan UMKM tetap memperoleh pendapatan.

---

## ✨ 2. Fitur

- Katalog porsi surplus lengkap dengan harga normal, harga diskon, persentase hemat, sisa stok, jam ambil, dan lokasi.
- Pencarian menu atau lokasi langsung di halaman katalog.
- Form tambah porsi untuk Mitra UMKM. Validasi memastikan harga diskon lebih rendah dari harga normal dan jam selesai setelah jam mulai.
- Klaim porsi oleh pembeli: stok berkurang otomatis dan sistem menerbitkan kode klaim unik (format `ECO-XXXXXX`). Porsi yang stoknya habis otomatis hilang dari katalog.
- Halaman **Perancangan** (`/perancangan`) yang menjelaskan proses desain aplikasi.
- Tampilan responsif, termasuk menu burger di layar kecil.

---

## 🛠️ 3. Tech Stack

- **Framework:** Laravel 13 (PHP 8.3)
- **Database:** MySQL
- **Templating:** Blade
- **Styling:** Tailwind CSS
- **Ikon dan font:** Lucide Icons, Plus Jakarta Sans
- **Arsitektur:** Model-View-Controller (MVC)

---

## 📐 4. Dokumen Perancangan Sistem

Penjelasan yang sama dapat dibuka langsung di aplikasi pada halaman `/perancangan`.

### A. User Flow (Alur Pengguna)

```text
[ Mitra UMKM ]
      │
      ├──> Tekan tombol "Tambah porsi"
      ├──> Isi form (nama menu, harga normal, harga diskon, stok, jam ambil, lokasi)
      └──> Simpan ──> Porsi langsung tampil di katalog

[ Pembeli ]
      │
      ├──> Buka halaman utama EcoBite
      ├──> Lihat dan cari porsi surplus di katalog
      ├──> Tekan "Klaim porsi"
      ├──> Stok berkurang dan sistem menerbitkan Kode Klaim (ECO-XXXXXX)
      └──> Pembeli mengambil makanan di lokasi pada jam ambil sambil menunjukkan kode
```

### B. Rancangan Data

Satu akun (`users`) dapat memiliki banyak porsi (`food_items`), dan satu porsi dapat memiliki banyak klaim (`reservations`).

**Tabel `users`:** `id`, `name`, `email`, `password`. Saat ini hanya ada dua akun tetap: id 1 sebagai Mitra UMKM dan id 2 sebagai Pembeli.

**Tabel `food_items`**

| Kolom | Tipe | Fungsi |
|---|---|---|
| id | bigint (PK) | Identitas unik porsi |
| user_id | bigint (FK users.id) | Mitra pemilik porsi |
| title | string | Nama menu atau paket |
| description | text, nullable | Deskripsi kondisi makanan |
| original_price | integer | Harga normal (Rp) |
| discounted_price | integer | Harga setelah diskon (Rp) |
| stock | integer | Jumlah porsi tersisa |
| pickup_start, pickup_end | time | Rentang jam pengambilan |
| location | string | Alamat pengambilan |
| status | string | `active` (tampil di katalog) atau `sold_out` (stok habis) |

**Tabel `reservations`**

| Kolom | Tipe | Fungsi |
|---|---|---|
| id | bigint (PK) | Identitas klaim |
| user_id | bigint (FK users.id) | Pembeli yang mengklaim |
| food_item_id | bigint (FK food_items.id) | Porsi yang diklaim |
| claim_code | string | Kode klaim unik, format `ECO-XXXXXX` |
| quantity | integer | Jumlah porsi diklaim (saat ini selalu 1) |
| status | string | Status klaim, awalnya `booked` |

### C. Daftar Route

| Method | URL | Nama | Fungsi |
|---|---|---|---|
| GET | `/` | `home` | Menampilkan katalog porsi surplus |
| POST | `/store` | `store` | Menyimpan porsi baru dari Mitra UMKM |
| POST | `/reserve/{id}` | `reserve` | Mengurangi stok dan membuat kode klaim |
| GET | `/perancangan` | `perancangan` | Halaman dokumen perancangan |

### D. Rancangan Tampilan

- **Warna:** hijau `#059669` (aksi utama), hijau tua `#065f46` (hero), hijau muda `#ecfdf5` (latar lencana), slate untuk teks dan latar.
- **Font:** Plus Jakarta Sans.
- **Struktur halaman:** hero dengan pesan utama dan tiga angka ringkas, bagian cara kerja tiga langkah, katalog berbentuk kartu dengan jam ambil sebagai informasi utama, dan form tambah porsi dalam modal.

---

## 🚀 5. Cara Menjalankan

```bash
git clone <url-repository>
cd <nama-folder>
composer install
cp .env.example .env
php artisan key:generate
```

Buat database kosong (misalnya `ecobite`), lalu atur `DB_DATABASE`, `DB_USERNAME`, dan `DB_PASSWORD` di file `.env`. Setelah itu:

```bash
php artisan migrate:fresh --seed
php artisan serve
```

Seeder membuat dua akun tetap (id 1 Mitra UMKM, id 2 Pembeli) yang dipakai aplikasi karena belum ada login, serta dua contoh porsi. Buka `http://localhost:8000`.

---

## ⚠️ 6. Keterbatasan dan Rencana Pengembangan

- Belum ada login. Mitra dan pembeli diwakili dua akun tetap (user_id 1 dan 2), sehingga siapa pun bisa menambah porsi. Rencananya ada pendaftaran dan login.
- Kode klaim hanya ditampilkan sekali. Rencananya ada riwayat klaim untuk pembeli dan halaman verifikasi kode untuk mitra.
- Porsi belum otomatis tutup setelah jam ambil berakhir.
- Belum ada peta dan filter jarak.
