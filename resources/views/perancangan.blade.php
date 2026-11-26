@extends('layouts.app')

@section('title', 'EcoBite | Perancangan')

@section('content')
@php
    $alur = [
        ['store', 'UMKM mengisi form', 'Mitra mengisi nama paket, harga normal, harga diskon, stok, jam ambil, dan lokasi.'],
        ['database', 'Data divalidasi dan disimpan', 'Laravel memeriksa input (harga diskon harus lebih rendah dari harga normal) lalu menyimpannya ke tabel food_items dengan status active.'],
        ['search', 'Pembeli melihat katalog', 'Beranda menampilkan porsi surplus lengkap dengan harga, persentase diskon, sisa stok, dan jam ambil.'],
        ['shopping-bag', 'Pembeli mengklaim porsi', 'Stok berkurang satu dan sistem menerbitkan kode klaim unik (ECO-XXXXXX) yang dicatat di tabel reservations. Porsi yang stoknya habis hilang dari katalog.'],
        ['map-pin', 'Pembeli mengambil makanan', 'Pembeli datang ke lokasi UMKM pada jam ambil yang tertera dan menunjukkan kode klaim.'],
    ];

    $tabel = [
        'users' => [
            ['id', 'bigint (PK)', 'Identitas akun'],
            ['name, email, password', 'string', 'Data akun. Saat ini hanya dua akun tetap: id 1 Mitra UMKM, id 2 Pembeli'],
        ],
        'food_items' => [
            ['id', 'bigint (PK)', 'Identitas unik porsi'],
            ['user_id', 'bigint (FK users.id)', 'Mitra pemilik porsi'],
            ['title', 'string', 'Nama makanan atau paket'],
            ['description', 'text, nullable', 'Deskripsi kondisi makanan'],
            ['original_price', 'integer', 'Harga normal (Rp)'],
            ['discounted_price', 'integer', 'Harga setelah diskon (Rp)'],
            ['stock', 'integer', 'Jumlah porsi tersisa'],
            ['pickup_start / pickup_end', 'time', 'Rentang jam pengambilan'],
            ['location', 'string', 'Alamat pengambilan'],
            ['status', 'string', 'active (tampil di katalog) atau sold_out (stok habis)'],
        ],
        'reservations' => [
            ['id', 'bigint (PK)', 'Identitas klaim'],
            ['user_id', 'bigint (FK users.id)', 'Pembeli yang mengklaim'],
            ['food_item_id', 'bigint (FK food_items.id)', 'Porsi yang diklaim'],
            ['claim_code', 'string', 'Kode klaim unik, format ECO-XXXXXX'],
            ['quantity', 'integer', 'Jumlah porsi diklaim (saat ini selalu 1)'],
            ['status', 'string', 'Status klaim, awalnya booked'],
        ],
    ];

    $warna = [
        ['#059669', 'Hijau merek', 'Tombol utama dan penanda aksi'],
        ['#065f46', 'Hijau tua', 'Latar hero dan judul'],
        ['#ecfdf5', 'Hijau muda', 'Latar ikon dan lencana'],
        ['#0f172a', 'Slate gelap', 'Teks utama dan tombol klaim'],
        ['#f8fafc', 'Slate terang', 'Latar halaman'],
    ];

    $tahap = [
        ['Menentukan tema dan masalah', 'Memilih Tech for Good dan merumuskan masalah makanan layak konsumsi yang terbuang di UMKM kuliner.'],
        ['Merancang alur dan data', 'Menyusun alur pengguna dan struktur tabel food_items dari kebutuhan Mitra UMKM dan pembeli.'],
        ['Mendesain antarmuka', 'Menetapkan palet warna, tipografi, dan komponen: hero, langkah cara kerja, kartu porsi, dan form modal.'],
        ['Implementasi', 'Membangun halaman dengan Laravel Blade, Tailwind CSS, dan ikon Lucide.'],
        ['Uji coba dan perbaikan', 'Mencoba alur tambah dan klaim porsi, lalu memperbaiki tampilan serta data yang belum akurat.'],
    ];
@endphp

<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-12">

    <!-- Judul -->
    <div class="space-y-3 max-w-3xl">
        <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-brand-50 border border-brand-200 text-xs font-semibold text-brand-700">
            <i data-lucide="leaf" class="w-3.5 h-3.5"></i>
            <span>Tema: Tech for Good — Solve Social &amp; Green Issues</span>
        </span>
        <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight text-slate-900">Perancangan EcoBite</h1>
        <p class="text-slate-600 leading-relaxed">
            Halaman ini menjelaskan bagaimana EcoBite dirancang sebelum dan selama dibuat: masalah yang dipecahkan, alur pengguna, rancangan data, rancangan tampilan, dan tahapan pengerjaannya.
        </p>
    </div>

    <!-- Masalah dan solusi -->
    <section class="grid md:grid-cols-2 gap-6">
        <div class="bg-white rounded-2xl border border-slate-200/80 p-6 space-y-2">
            <h2 class="font-extrabold text-slate-900 flex items-center gap-2"><i data-lucide="alert-triangle" class="w-4 h-4 text-amber-600"></i> Masalah</h2>
            <p class="text-sm text-slate-600 leading-relaxed">UMKM kuliner sering memiliki porsi makanan yang masih layak di akhir hari, tetapi tidak terjual dan akhirnya dibuang. Di sisi lain, masyarakat mencari makanan yang lebih terjangkau.</p>
        </div>
        <div class="bg-white rounded-2xl border border-slate-200/80 p-6 space-y-2">
            <h2 class="font-extrabold text-slate-900 flex items-center gap-2"><i data-lucide="lightbulb" class="w-4 h-4 text-brand-600"></i> Solusi</h2>
            <p class="text-sm text-slate-600 leading-relaxed">EcoBite mempertemukan keduanya. UMKM menawarkan porsi surplus dengan harga diskon, pembeli mengklaimnya sebelum jam ambil berakhir, sehingga makanan terselamatkan dan UMKM tetap memperoleh pendapatan.</p>
        </div>
    </section>

    <!-- Pengguna -->
    <section class="space-y-4">
        <h2 class="text-xl font-extrabold text-slate-900">Pengguna dan kebutuhannya</h2>
        <div class="grid md:grid-cols-2 gap-6 text-sm text-slate-600">
            <div class="bg-white rounded-2xl border border-slate-200/80 p-6">
                <p class="font-bold text-slate-900 mb-1">Mitra UMKM</p>
                Perlu cara cepat untuk mengunggah porsi sisa beserta harga, stok, jam ambil, dan lokasi.
            </div>
            <div class="bg-white rounded-2xl border border-slate-200/80 p-6">
                <p class="font-bold text-slate-900 mb-1">Pembeli</p>
                Perlu melihat porsi yang tersedia hari ini, membandingkan harga, dan mengklaim porsi dengan satu langkah.
            </div>
        </div>
    </section>

    <!-- Alur pengguna -->
    <section class="space-y-4">
        <h2 class="text-xl font-extrabold text-slate-900">Alur pengguna</h2>
        <ol class="space-y-3">
            @foreach($alur as $i => [$ikon, $judul, $isi])
                <li class="bg-white rounded-2xl border border-slate-200/80 p-5 flex gap-4 items-start">
                    <span class="w-10 h-10 shrink-0 rounded-xl bg-brand-50 text-brand-600 flex items-center justify-center"><i data-lucide="{{ $ikon }}" class="w-5 h-5"></i></span>
                    <div>
                        <p class="font-bold text-slate-900">{{ $i + 1 }}. {{ $judul }}</p>
                        <p class="text-sm text-slate-600 mt-0.5">{{ $isi }}</p>
                    </div>
                </li>
            @endforeach
        </ol>
    </section>

    <!-- Rancangan data -->
    <section class="space-y-4">
        <h2 class="text-xl font-extrabold text-slate-900">Rancangan data</h2>
        <p class="text-sm text-slate-600 max-w-3xl">Satu akun (users) dapat memiliki banyak porsi (food_items), dan satu porsi dapat memiliki banyak klaim (reservations).</p>
        @foreach($tabel as $namaTabel => $daftarKolom)
            <div class="space-y-2">
                <h3 class="font-bold text-slate-900"><code class="text-brand-700">{{ $namaTabel }}</code></h3>
                <div class="bg-white rounded-2xl border border-slate-200/80 overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-slate-50 text-slate-500 text-xs">
                            <tr><th class="px-5 py-3 font-semibold">Kolom</th><th class="px-5 py-3 font-semibold">Tipe</th><th class="px-5 py-3 font-semibold">Fungsi</th></tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($daftarKolom as [$nama, $tipe, $fungsi])
                                <tr><td class="px-5 py-3 font-mono text-xs text-slate-800">{{ $nama }}</td><td class="px-5 py-3 text-slate-600">{{ $tipe }}</td><td class="px-5 py-3 text-slate-600">{{ $fungsi }}</td></tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach
    </section>

    <!-- Rancangan tampilan -->
    <section class="space-y-4">
        <h2 class="text-xl font-extrabold text-slate-900">Rancangan tampilan</h2>
        <p class="text-sm text-slate-600 max-w-3xl">Hijau dipilih karena identik dengan lingkungan. Font Plus Jakarta Sans dipakai agar teks mudah dibaca di layar kecil. Struktur halaman: hero berisi pesan utama dan tiga angka ringkas, bagian cara kerja tiga langkah, katalog porsi berbentuk kartu dengan jam ambil sebagai informasi utama, dan form tambah porsi dalam modal.</p>
        <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
            @foreach($warna as [$hex, $nama, $fungsi])
                <div class="bg-white rounded-2xl border border-slate-200/80 p-3 space-y-2">
                    <div class="h-14 rounded-xl border border-slate-200/80" style="background: {{ $hex }}"></div>
                    <p class="text-xs font-bold text-slate-900">{{ $nama }} <span class="font-mono font-normal text-slate-400">{{ $hex }}</span></p>
                    <p class="text-xs text-slate-500">{{ $fungsi }}</p>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Tahapan -->
    <section class="space-y-4">
        <h2 class="text-xl font-extrabold text-slate-900">Tahapan pembuatan</h2>
        <ol class="space-y-3">
            @foreach($tahap as $i => [$judul, $isi])
                <li class="bg-white rounded-2xl border border-slate-200/80 p-5">
                    <p class="font-bold text-slate-900">Tahap {{ $i + 1 }}: {{ $judul }}</p>
                    <p class="text-sm text-slate-600 mt-0.5">{{ $isi }}</p>
                </li>
            @endforeach
        </ol>
    </section>

    <!-- Keterbatasan -->
    <section class="space-y-4">
        <h2 class="text-xl font-extrabold text-slate-900">Keterbatasan dan rencana pengembangan</h2>
        <p class="text-sm text-slate-600 max-w-3xl">Versi ini sengaja dibuat sederhana agar fokus pada alur utama. Berikut hal yang belum ada dan rencana ke depannya.</p>
        <div class="bg-white rounded-2xl border border-slate-200/80 divide-y divide-slate-100 text-sm">
            @foreach([
                ['Belum ada login', 'Mitra dan pembeli masih diwakili dua akun tetap (user_id 1 dan 2), sehingga siapa pun bisa menambah porsi. Rencananya ada pendaftaran dan login agar mitra hanya mengelola porsinya sendiri.'],
                ['Kode klaim belum bisa diverifikasi', 'Kode hanya ditampilkan sekali setelah klaim. Rencananya ada riwayat klaim untuk pembeli dan halaman verifikasi kode untuk mitra.'],
                ['Porsi belum otomatis tutup setelah jam ambil berakhir', 'Rencananya porsi disembunyikan atau ditandai berakhir secara otomatis.'],
                ['Belum ada peta dan filter jarak', 'Rencananya pembeli bisa mencari porsi terdekat dari lokasinya.'],
            ] as [$masalah, $rencana])
                <div class="p-5">
                    <p class="font-bold text-slate-900">{{ $masalah }}</p>
                    <p class="text-slate-600 mt-0.5">{{ $rencana }}</p>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Dampak -->
    <section class="rounded-3xl bg-gradient-to-br from-emerald-900 via-teal-800 to-slate-900 text-white p-8 space-y-2">
        <h2 class="text-xl font-extrabold">Dampak yang dituju</h2>
        <p class="text-sm text-slate-300 leading-relaxed max-w-3xl">EcoBite mendukung SDG 12 (Konsumsi dan Produksi yang Bertanggung Jawab): mengurangi makanan terbuang, membantu pendapatan UMKM, dan memberi akses makanan lebih murah bagi masyarakat.</p>
        <a href="{{ route('home') }}" class="inline-flex items-center gap-2 mt-3 bg-brand-500 hover:bg-brand-600 text-white font-bold text-sm px-5 py-2.5 rounded-xl transition">
            <i data-lucide="arrow-left" class="w-4 h-4"></i><span>Kembali ke katalog</span>
        </a>
    </section>
</div>
@endsection