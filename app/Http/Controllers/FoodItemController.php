<?php

namespace App\Http\Controllers;

use App\Models\FoodItem;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class FoodItemController extends Controller
{
    // Menampilkan katalog: hanya porsi berstatus active (porsi habis otomatis tersembunyi)
    public function index()
    {
        $foodItems = FoodItem::where('status', 'active')->latest()->get();
        return view('home', compact('foodItems'));
    }

    // Menyimpan porsi baru dari Mitra UMKM
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'original_price' => 'required|integer|min:1',
            'discounted_price' => 'required|integer|min:1|lt:original_price',
            'stock' => 'required|integer|min:1|max:1000',
            'pickup_start' => 'required|date_format:H:i',
            'pickup_end' => 'required|date_format:H:i|after:pickup_start',
            'location' => 'required|string|max:255',
        ], [
            'required' => ':attribute wajib diisi.',
            'integer' => ':attribute harus berupa angka bulat.',
            'min.numeric' => ':attribute minimal :min.',
            'max.numeric' => ':attribute maksimal :max.',
            'max.string' => ':attribute maksimal :max karakter.',
            'date_format' => ':attribute harus berformat jam:menit.',
            'discounted_price.lt' => 'Harga diskon harus lebih rendah dari harga normal.',
            'pickup_end.after' => 'Jam selesai harus setelah jam mulai.',
        ], [
            'title' => 'Nama menu',
            'description' => 'Deskripsi',
            'original_price' => 'Harga normal',
            'discounted_price' => 'Harga diskon',
            'stock' => 'Stok',
            'pickup_start' => 'Jam mulai',
            'pickup_end' => 'Jam selesai',
            'location' => 'Lokasi',
        ]);

        FoodItem::create([
            'user_id' => 1, // sementara: akun Mitra UMKM tetap, karena belum ada login
            'title' => $request->title,
            'description' => $request->description,
            'original_price' => $request->original_price,
            'discounted_price' => $request->discounted_price,
            'stock' => $request->stock,
            'pickup_start' => $request->pickup_start,
            'pickup_end' => $request->pickup_end,
            'location' => $request->location,
            'status' => 'active',
        ]);

        return back()->with('success', 'Porsi makanan surplus berhasil ditambahkan!');
    }

    // Memproses klaim: kurangi stok dan terbitkan kode klaim
    public function reserve($id)
    {
        $kode = null;

        $berhasil = DB::transaction(function () use ($id, &$kode) {
            // lockForUpdate mengunci baris agar dua klaim bersamaan tidak membuat stok minus
            $item = FoodItem::lockForUpdate()->findOrFail($id);

            if ($item->stock <= 0) {
                return false;
            }

            $item->decrement('stock');
            if ($item->stock <= 0) {
                $item->update(['status' => 'sold_out']);
            }

            $kode = 'ECO-' . strtoupper(Str::random(6));

            Reservation::create([
                'user_id' => 2, // sementara: akun Pembeli tetap, karena belum ada login
                'food_item_id' => $item->id,
                'claim_code' => $kode,
                'quantity' => 1,
                'status' => 'booked',
            ]);

            return true;
        });

        if (! $berhasil) {
            return back()->with('error', 'Stok porsi sudah habis!');
        }

        return back()->with('success', "Berhasil klaim! Kode Klaim Anda: {$kode}");
    }
}