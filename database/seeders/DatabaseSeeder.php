<?php

namespace Database\Seeders;

use App\Models\FoodItem;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Dua akun tetap yang dipakai controller karena belum ada login:
        // id 1 = Mitra UMKM (pemilik porsi), id 2 = Pembeli (pengklaim porsi).
        // Jalankan pada database baru: php artisan migrate:fresh --seed
        $mitra = User::updateOrCreate(
            ['email' => 'mitra@ecobite.test'],
            ['name' => 'Mitra UMKM Demo', 'password' => bcrypt('password')]
        );
        User::updateOrCreate(
            ['email' => 'pembeli@ecobite.test'],
            ['name' => 'Pembeli Demo', 'password' => bcrypt('password')]
        );

        // Contoh data agar katalog tidak kosong saat demo
        if (FoodItem::count() === 0) {
            FoodItem::create([
                'user_id' => $mitra->id,
                'title' => 'Paket Nasi Ayam Serundeng + Sayur',
                'description' => 'Sisa 5 porsi kondisi hangat dan higienis, cocok untuk makan malam.',
                'original_price' => 20000,
                'discounted_price' => 10000,
                'stock' => 5,
                'pickup_start' => '18:00',
                'pickup_end' => '21:00',
                'location' => 'Jl. Margonda Raya No. 45, Depok',
                'status' => 'active',
            ]);
            FoodItem::create([
                'user_id' => $mitra->id,
                'title' => 'Roti Manis Assorted (4 Pcs)',
                'description' => 'Paket roti manis bervariasi produksi segar hari ini.',
                'original_price' => 16000,
                'discounted_price' => 8000,
                'stock' => 3,
                'pickup_start' => '20:00',
                'pickup_end' => '22:00',
                'location' => 'Kawasan Kelapa Dua, Depok',
                'status' => 'active',
            ]);
        }
    }
}