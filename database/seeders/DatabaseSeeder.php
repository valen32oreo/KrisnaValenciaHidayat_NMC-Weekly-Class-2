<?php

namespace Database\Seeders;

use App\Models\FoodItem;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $mitra = User::updateOrCreate(
            ['email' => 'mitra@ecobite.test'],
            ['name' => 'Mitra UMKM Demo', 'password' => bcrypt('password')]
        );
        User::updateOrCreate(
            ['email' => 'pembeli@ecobite.test'],
            ['name' => 'Pembeli Demo', 'password' => bcrypt('password')]
        );

        // Nonaktifkan foreign key checks sementara agar truncate tidak error
        Schema::disableForeignKeyConstraints();
        FoodItem::truncate();
        Schema::enableForeignKeyConstraints();

        $items = [
            [
                'user_id' => $mitra->id,
                'title' => 'Dimsum Ayam Udang Mix (6 Pcs)',
                'description' => 'Dimsum kukus variasi original, mentai, dan nori. Higienis dan disajikan lengkap dengan chili oil.',
                'original_price' => 22000,
                'discounted_price' => 11000,
                'stock' => 3,
                'pickup_start' => '19:00',
                'pickup_end' => '21:00',
                'location' => 'Kedai Dimsum 88, Kelapa Dua, Depok',
                'status' => 'active',
            ],
            [
                'user_id' => $mitra->id,
                'title' => 'Bento Teriyaki + Nasi Japan',
                'description' => 'Paket bento ayam teriyaki lengkap dengan salad dan nasi hangat. Kondisi dibungkus rapi di akhir jam...',
                'original_price' => 28000,
                'discounted_price' => 14000,
                'stock' => 5,
                'pickup_start' => '20:00',
                'pickup_end' => '23:00',
                'location' => 'Bento Express, Margonda, Depok',
                'status' => 'active',
            ],
            [
                'user_id' => $mitra->id,
                'title' => 'Paket Pastry & Croissant Box (3 Pcs)',
                'description' => 'Kombinasi butter croissant, pain au chocolat, dan danish buah sisa display toko hari ini. Masih sangat...',
                'original_price' => 35000,
                'discounted_price' => 15000,
                'stock' => 6,
                'pickup_start' => '19:00',
                'pickup_end' => '21:00',
                'location' => 'Artisan Bakery, Kec. Serang, Kota Serang',
                'status' => 'active',
            ],
            [
                'user_id' => $mitra->id,
                'title' => 'Ayam Serundeng',
                'description' => 'Ayam goreng dengan toping serundeng kelapa gurih.',
                'original_price' => 20000,
                'discounted_price' => 19000,
                'stock' => 8,
                'pickup_start' => '18:00',
                'pickup_end' => '21:00',
                'location' => 'Serang, Banten, Indonesia',
                'status' => 'active',
            ],
            [
                'user_id' => $mitra->id,
                'title' => 'Paket Nasi Ayam Serundeng + Sayur',
                'description' => 'Sisa 5 porsi kondisi hangat dan higienis, cocok untuk makan malam.',
                'original_price' => 20000,
                'discounted_price' => 10000,
                'stock' => 4,
                'pickup_start' => '19:00',
                'pickup_end' => '21:00',
                'location' => 'Jl. Margonda Raya No. 45, Depok',
                'status' => 'active',
            ],
            [
                'user_id' => $mitra->id,
                'title' => 'Roti Manis Assorted (4 Pcs)',
                'description' => 'Paket roti manis bervariasi produksi segar hari ini.',
                'original_price' => 24000,
                'discounted_price' => 12000,
                'stock' => 2,
                'pickup_start' => '20:00',
                'pickup_end' => '22:00',
                'location' => 'Kawasan Kelapa Dua, Depok',
                'status' => 'active',
            ],
        ];

        foreach ($items as $item) {
            FoodItem::create($item);
        }
    }
}