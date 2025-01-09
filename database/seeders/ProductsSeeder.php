<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Brands;
use App\Models\Product;
class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $brands = [
            ['name' => 'Prince', 'logo' => 'brands/Prince.png'],
            ['name' => 'Gala', 'logo' => 'brands/Gala.png'],
            ['name' => 'Oreo', 'logo' => 'brands/Oreo.png'],
            ['name' => 'Milco', 'logo' => 'brands/Milcolu.png'],
            ['name' => 'TUC', 'logo' => 'brands/Tuc.png'],
            ['name' => 'Candi', 'logo' => 'brands/Candi.png'],
            ['name' => 'Zeera', 'logo' => 'brands/Zeera.png'],
            ['name' => 'NanKhatai', 'logo' => 'brands/Bakeri.png'],
            ['name' => 'Tiger', 'logo' => 'brands/Tiger.png'],
            ['name' => 'Wheatable', 'logo' => 'brands/Wheatable.png'],
        ];

        foreach ($brands as $brandData) {
            $brand = Brands::create($brandData);

            // Distribute $100 million across 10 products
            $totalAmount = 100_000_000; // 100 million
            $productValue = $totalAmount / 10;

            for ($i = 1; $i <= 10; $i++) {
                Product::create([
                    'brand_id' => $brand->id,
                    'name' => "{$brand->name} Product {$i}",
                    'image' => "products/{$brand->name}_product_{$i}.png",
                    'quantity' => rand(50, 500),
                    'price' => $productValue,
                ]);
            }
        }
    }
}
