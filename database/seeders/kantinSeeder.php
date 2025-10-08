<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class kantinSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('_product')->insert([
            [
                'name' => 'Nasi Goreng Spesial',
                'price' => 20000,
                'stock' => 10,
                'category' => 'makanan',
                'image' => 'images/EoYUodrTN7JOosvcVk9QUHlgJy2qbYJJIn5row9b.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Ayam Bakar Madu',
                'price' => 25000,
                'stock' => 8,
                'category' => 'makanan',
                'image' => 'images/EoYUodrTN7JOosvcVk9QUHlgJy2qbYJJIn5row9b.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Teh Manis Dingin',
                'price' => 7000,
                'stock' => 15,
                'category' => 'minuman',
                'image' => 'images/EoYUodrTN7JOosvcVk9QUHlgJy2qbYJJIn5row9b.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Es Jeruk Segar',
                'price' => 8000,
                'stock' => 12,
                'category' => 'minuman',
                'image' => 'images/EoYUodrTN7JOosvcVk9QUHlgJy2qbYJJIn5row9b.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
