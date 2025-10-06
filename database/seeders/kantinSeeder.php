<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\kantinProduk;

class kantinSeeder extends Seeder
{
    public function run()
    {
        kantinProduk::create([
            'name' => 'Nasi Goreng',
            'description' => 'Nasi goreng spesial dengan telur dan ayam.',
            'price' => 15000,
            'category' => 'makanan',
        ]);

        kantinProduk::create([
            'name' => 'Es Teh Manis',
            'description' => 'Teh manis dingin menyegarkan.',
            'price' => 5000,
            'category' => 'minuman',
        ]);
    }
}
