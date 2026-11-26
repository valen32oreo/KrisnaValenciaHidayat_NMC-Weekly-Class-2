@extends('layouts.app')

@section('title', 'EcoBite | Home')

@section('content')
@php
    $items = collect($foodItems);
    $totalStock = (int) $items->sum('stock');
    $totalLokasi = $items->pluck('location')->unique()->count();
    $maxDiscount = (int) ($items->map(fn ($i) => $i->original_price > 0
        ? round(($i->original_price - $i->discounted_price) / $i->original_price * 100) : 0)->max() ?? 0);

    $langkah = [
        ['store', 'UMKM mengunggah porsi surplus', 'Mitra mengisi menu sisa hari ini, harga diskon, stok, jam ambil, dan lokasi.'],
        ['shopping-bag', 'Pembeli mengklaim porsi', 'Pilih porsi dari katalog, lalu klaim sebelum stok habis.'],
        ['map-pin', 'Ambil di lokasi UMKM', 'Datang sesuai jam ambil. Makanan terselamatkan, UMKM tetap untung.'],
    ];
@endphp

<!-- Hero -->
<section class="bg-brand-900 text-white min-h-[calc(100vh-4rem)] flex flex-col justify-center relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 lg:py-0 w-full grid lg:grid-cols-5 gap-10 items-center">
        
        <div class="lg:col-span-3 space-y-5">
            <h1 class="text-3xl md:text-5xl font-extrabold tracking-tight leading-tight">
                Makanan layak makan dari UMKM sekitar Anda, <span class="text-brand-200 underline decoration-brand-400/40 underline-offset-8">jangan sampai terbuang.</span>
            </h1>
            <p class="text-brand-100 leading-relaxed max-w-xl">
                <strong class="text-white font-bold">EcoBite</strong> menghubungkan UMKM kuliner yang punya makanan sisa di akhir hari dengan pembeli yang mencari harga lebih hemat.
            </p>
            <div class="flex flex-wrap gap-3 pt-2">
                <a href="#katalog" class="inline-flex items-center gap-2 bg-white text-brand-800 hover:bg-brand-50 font-bold text-sm px-6 py-3 rounded-xl transition shadow-md">
                    <i data-lucide="shopping-bag" class="w-4 h-4"></i> Lihat porsi hari ini
                </a>
                <button onclick="openModalForm()" class="inline-flex items-center gap-2 border border-white/40 hover:bg-white/10 text-white font-semibold text-sm px-6 py-3 rounded-xl transition">
                    <i data-lucide="store" class="w-4 h-4"></i> Saya UMKM, tambah porsi
                </button>
            </div>
        </div>

        <dl class="lg:col-span-2 grid grid-cols-3 lg:grid-cols-1 gap-px bg-white/20 rounded-2xl overflow-hidden border border-white/20">
            <div class="bg-brand-800 p-4 lg:p-5">
                <dd class="text-2xl lg:text-4xl font-extrabold">{{ $totalStock }}</dd>
                <dt class="text-xs lg:text-sm text-brand-200 mt-1">porsi siap diselamatkan</dt>
            </div>
            <div class="bg-brand-800 p-4 lg:p-5">
                <dd class="text-2xl lg:text-4xl font-extrabold">{{ $maxDiscount > 0 ? $maxDiscount.'%' : '-' }}</dd>
                <dt class="text-xs lg:text-sm text-brand-200 mt-1">hemat tertinggi hari ini</dt>
            </div>
            <div class="bg-brand-800 p-4 lg:p-5">
                <dd class="text-2xl lg:text-4xl font-extrabold">{{ $totalLokasi }}</dd>
                <dt class="text-xs lg:text-sm text-brand-200 mt-1">lokasi pengambilan</dt>
            </div>
        </dl>

    </div>
</section>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-16 pt-10">

    <!-- Notifikasi -->
    @if(session('success'))
        <div id="notifikasi" class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-900 rounded-xl flex items-center justify-between gap-3">
            <span class="flex items-center gap-3 text-sm font-semibold"><i data-lucide="check-circle-2" class="w-5 h-5 text-emerald-600 shrink-0"></i>{{ session('success') }}</span>
            <button onclick="this.parentElement.remove()" aria-label="Tutup" class="text-emerald-600"><i data-lucide="x" class="w-4 h-4"></i></button>
        </div>
    @endif
    @if(session('error'))
        <div id="notifikasi" class="p-4 bg-rose-50 border border-rose-200 text-rose-900 rounded-xl flex items-center justify-between gap-3">
            <span class="flex items-center gap-3 text-sm font-semibold"><i data-lucide="alert-circle" class="w-5 h-5 text-rose-600 shrink-0"></i>{{ session('error') }}</span>
            <button onclick="this.parentElement.remove()" aria-label="Tutup" class="text-rose-600"><i data-lucide="x" class="w-4 h-4"></i></button>
        </div>
    @endif

    <!-- Cara kerja -->
    <section id="cara-kerja" class="scroll-mt-24 space-y-6">
        <div class="flex flex-wrap items-end justify-between gap-2">
            <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">Cara kerja <span class="text-brand-800">EcoBite</span></h2>
            <a href="{{ route('perancangan') }}" class="text-sm font-semibold text-brand-700 hover:underline">Lihat perancangan aplikasi</a>
        </div>
        <ol class="grid md:grid-cols-3 gap-8 md:gap-0 md:divide-x divide-slate-200">
            @foreach($langkah as $i => [$ikon, $judul, $isi])
                <li class="md:px-8 first:md:pl-0 last:md:pr-0 flex gap-4">
                    <span class="w-10 h-10 shrink-0 rounded-full bg-brand-600 text-white font-extrabold flex items-center justify-center">{{ $i + 1 }}</span>
                    <div>
                        <p class="font-bold text-slate-900 flex items-center gap-2"><i data-lucide="{{ $ikon }}" class="w-4 h-4 text-brand-600"></i>{{ $judul }}</p>
                        <p class="text-sm text-slate-600 mt-1 leading-relaxed">{{ $isi }}</p>
                    </div>
                </li>
            @endforeach
        </ol>
    </section>

    <!-- Katalog -->
    <section id="katalog" class="scroll-mt-24 space-y-6">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">Porsi surplus hari ini</h2>
                <p class="text-sm text-slate-500 mt-1">Klaim sebelum stok habis, lalu ambil pada jam yang tertera.</p>
            </div>
            <div class="relative w-full md:w-72">
                <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                <input id="cari" type="search" placeholder="Cari menu atau lokasi" class="w-full border border-slate-300 rounded-xl pl-9 pr-3 py-2.5 text-sm outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($foodItems as $item)
                @php
                    $savings = $item->original_price - $item->discounted_price;
                    $percent = $item->original_price > 0 ? round($savings / $item->original_price * 100) : 0;
                    $soldOut = $item->stock <= 0;
                @endphp
                <article data-cari="{{ strtolower($item->title.' '.$item->location) }}" class="bg-white rounded-2xl border border-slate-200 flex flex-col overflow-hidden hover:border-brand-300 transition-colors">
                    <div class="p-5 flex-1 space-y-3">
                        <div class="flex items-start justify-between gap-3">
                            <h3 class="font-bold text-slate-900 leading-snug">{{ $item->title }}</h3>
                            <span class="shrink-0 text-xs font-bold text-brand-700 bg-brand-50 rounded-md px-2 py-1">Hemat {{ $percent }}%</span>
                        </div>
                        <p class="text-sm text-slate-500 flex items-start gap-1.5"><i data-lucide="map-pin" class="w-4 h-4 text-brand-600 shrink-0 mt-0.5"></i>{{ $item->location }}</p>
                        <p class="text-sm text-slate-600 line-clamp-2 leading-relaxed">{{ $item->description }}</p>
                    </div>

                    <!-- Jam ambil: informasi terpenting, dibuat seperti sobekan tiket -->
                    <div class="px-5 py-3 bg-brand-50 border-y border-dashed border-brand-300 flex items-center justify-between gap-3 text-sm">
                        <span class="flex items-center gap-2 font-bold text-brand-800"><i data-lucide="clock" class="w-4 h-4"></i>Ambil {{ substr($item->pickup_start, 0, 5) }}–{{ substr($item->pickup_end, 0, 5) }} WIB</span>
                        <span class="text-xs font-semibold {{ $item->stock <= 2 ? 'text-amber-700' : 'text-slate-500' }}">{{ $soldOut ? 'Habis' : ($item->stock <= 2 ? 'Tinggal '.$item->stock : 'Sisa '.$item->stock) }}</span>
                    </div>

                    <div class="p-5 flex items-center justify-between gap-3">
                        <div>
                            <p class="text-xs text-slate-400 line-through">Rp{{ number_format($item->original_price, 0, ',', '.') }}</p>
                            <p class="text-xl font-extrabold text-slate-900">Rp{{ number_format($item->discounted_price, 0, ',', '.') }}</p>
                        </div>
                        <form action="{{ route('reserve', $item->id) }}" method="POST">
                            @csrf
                            <button type="submit" {{ $soldOut ? 'disabled' : '' }} class="px-5 py-2.5 rounded-xl text-sm font-bold text-white transition {{ $soldOut ? 'bg-slate-300 cursor-not-allowed' : 'bg-brand-600 hover:bg-brand-700 active:scale-[0.98]' }}">
                                {{ $soldOut ? 'Stok habis' : 'Klaim porsi' }}
                            </button>
                        </form>
                    </div>
                </article>
            @empty
                <div class="col-span-full text-center py-14 bg-white rounded-2xl border border-dashed border-slate-300">
                    <i data-lucide="inbox" class="w-8 h-8 text-slate-400 mx-auto mb-3"></i>
                    <h3 class="font-bold text-slate-800">Belum ada porsi surplus hari ini</h3>
                    <p class="text-sm text-slate-500 mt-1 mb-4">Jika Anda pemilik UMKM, tambahkan porsi pertama Anda.</p>
                    <button onclick="openModalForm()" class="bg-brand-600 hover:bg-brand-700 text-white font-bold text-sm px-5 py-2.5 rounded-xl transition">Tambah porsi surplus</button>
                </div>
            @endforelse
        </div>
        <p id="kosong" class="hidden text-center text-sm text-slate-500 py-8">Tidak ada porsi yang cocok dengan pencarian Anda.</p>
    </section>
</div>

<!-- Form tambah porsi -->
<div id="modalForm" class="hidden fixed inset-0 z-[60] overflow-y-auto bg-slate-900/60" role="dialog" aria-modal="true" aria-labelledby="judulForm">
    <div class="min-h-full flex items-center justify-center p-4" onclick="if (event.target === this) closeModalForm()">
        <div class="bg-white rounded-2xl w-full max-w-lg shadow-2xl p-6">
            <div class="flex items-start justify-between gap-4 mb-5">
                <div>
                    <h3 id="judulForm" class="text-lg font-bold text-slate-900">Tambah porsi surplus</h3>
                    <p class="text-sm text-slate-500">Untuk Mitra UMKM. Porsi akan langsung tampil di katalog.</p>
                </div>
                <button onclick="closeModalForm()" aria-label="Tutup form" class="w-8 h-8 shrink-0 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-500 flex items-center justify-center"><i data-lucide="x" class="w-4 h-4"></i></button>
            </div>

            @if($errors->any())
                <div class="mb-4 p-3 bg-rose-50 border border-rose-200 text-rose-800 rounded-xl text-sm">
                    <p class="font-bold mb-1">Data belum bisa disimpan:</p>
                    <ul class="list-disc list-inside">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                </div>
            @endif

            <form action="{{ route('store') }}" method="POST" class="space-y-4">
                @csrf
                @php $in = 'w-full border border-slate-300 rounded-xl px-3 py-2.5 text-sm outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500'; $lb = 'block text-sm font-semibold text-slate-700 mb-1'; @endphp
                <div>
                    <label class="{{ $lb }}">Nama menu atau paket</label>
                    <input type="text" name="title" value="{{ old('title') }}" required class="{{ $in }}" placeholder="Contoh: Paket Nasi Ayam Serundeng">
                </div>
                <div>
                    <label class="{{ $lb }}">Deskripsi singkat</label>
                    <textarea name="description" rows="2" class="{{ $in }}" placeholder="Kondisi makanan, isi paket, dibuat kapan">{{ old('description') }}</textarea>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="{{ $lb }}">Harga normal (Rp)</label>
                        <input id="hargaNormal" type="number" name="original_price" min="1" value="{{ old('original_price') }}" required class="{{ $in }}" placeholder="20000">
                    </div>
                    <div>
                        <label class="{{ $lb }}">Harga diskon (Rp)</label>
                        <input id="hargaDiskon" type="number" name="discounted_price" min="1" value="{{ old('discounted_price') }}" required class="{{ $in }}" placeholder="10000">
                    </div>
                </div>
                <p id="infoDiskon" class="text-xs text-slate-500 -mt-2">Harga diskon harus lebih rendah dari harga normal.</p>
                <div class="grid grid-cols-3 gap-3">
                    <div>
                        <label class="{{ $lb }}">Stok</label>
                        <input type="number" name="stock" min="1" value="{{ old('stock') }}" required class="{{ $in }}" placeholder="5">
                    </div>
                    <div>
                        <label class="{{ $lb }}">Ambil mulai</label>
                        <input type="time" name="pickup_start" value="{{ old('pickup_start', '18:00') }}" required class="{{ $in }}">
                    </div>
                    <div>
                        <label class="{{ $lb }}">Ambil sampai</label>
                        <input type="time" name="pickup_end" value="{{ old('pickup_end', '21:00') }}" required class="{{ $in }}">
                    </div>
                </div>
                <div>
                    <label class="{{ $lb }}">Lokasi pengambilan</label>
                    <input type="text" name="location" value="{{ old('location') }}" required class="{{ $in }}" placeholder="Contoh: Jl. Margonda Raya No. 45, Depok">
                </div>
                <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                    <button type="button" onclick="closeModalForm()" class="px-5 py-2.5 text-sm font-semibold text-slate-600 hover:bg-slate-100 rounded-xl transition">Batal</button>
                    <button type="submit" class="px-5 py-2.5 text-sm font-bold bg-brand-600 hover:bg-brand-700 text-white rounded-xl transition">Simpan porsi</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    @if($errors->any())
        openModalForm();
    @endif
    if (new URLSearchParams(window.location.search).get('tambah')) { openModalForm(); }

    const notif = document.getElementById('notifikasi');
    if (notif) { notif.scrollIntoView({ behavior: 'smooth', block: 'center' }); }

    // Info diskon langsung saat harga diisi
    const hn = document.getElementById('hargaNormal'), hd = document.getElementById('hargaDiskon'), info = document.getElementById('infoDiskon');
    function hitungDiskon() {
        const n = +hn.value, d = +hd.value;
        if (!n || !d) return;
        info.textContent = d < n ? 'Pembeli hemat ' + Math.round((n - d) / n * 100) + '% dari harga normal.' : 'Harga diskon harus lebih rendah dari harga normal.';
        info.className = 'text-xs -mt-2 ' + (d < n ? 'text-brand-700' : 'text-rose-600');
    }
    hn.addEventListener('input', hitungDiskon); hd.addEventListener('input', hitungDiskon);

    // Cari menu atau lokasi
    const cari = document.getElementById('cari');
    cari.addEventListener('input', function () {
        const v = cari.value.toLowerCase().trim(); let n = 0;
        document.querySelectorAll('[data-cari]').forEach(function (el) {
            const cocok = el.dataset.cari.includes(v);
            el.classList.toggle('hidden', !cocok);
            if (cocok) n++;
        });
        document.getElementById('kosong').classList.toggle('hidden', n > 0);
    });
</script>
@endpush
@endsection