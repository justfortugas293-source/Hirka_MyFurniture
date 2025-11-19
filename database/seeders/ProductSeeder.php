<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Jalankan seeder untuk tabel products.
     */
    public function run(): void
    {
        Product::truncate(); // bersihkan tabel agar tidak dobel saat seeding ulang

        Product::create([
            'name' => 'Side Table',
            'price' => 55000,
            'description' => 'Minimalist side table with solid wood legs and durable surface. Perfect for modern living spaces or bedrooms.',
            'image' => 'side_table.jpeg',
            'stock' => 150,
        ]);

        Product::create([
            'name' => 'Sofa Chair',
            'price' => 350000,
            'description' => 'Embodiment of modern comfort and sophisticated design. Plush velvet-feel fabric with a balanced aesthetic.',
            'image' => 'sofa_chair.jpeg',
            'stock' => 150,
        ]);

        Product::create([
            'name' => 'Sofa',
            'price' => 500000,
            'description' => 'Comfortable three-seat sofa designed with modern elegance and soft cushioning for maximum relaxation.',
            'image' => 'sofa.jpeg',
            'stock' => 150,
        ]);

        Product::create([
            'name' => 'Living Room Lamp',
            'price' => 150000,
            'description' => 'Stylish standing lamp with warm light tone, ideal for reading or cozy room atmosphere.',
            'image' => 'lamp.jpeg',
            'stock' => 150,
        ]);
    }
}

