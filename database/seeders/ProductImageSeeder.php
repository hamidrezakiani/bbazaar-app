<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Seeder;

class ProductImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            [
                'id' => 1,
                'image' => 'product-14-2.webp',
                'product_id' => 88630114,
                'admin_id' => 1
            ],
            [
                'id' => 2,
                'image' => 'product-14-3.webp',
                'product_id' => 88630114,
                'admin_id' => 1
            ],
            [
                'id' => 3,
                'image' => 'product-14-4.webp',
                'product_id' => 88630114,
                'admin_id' => 1
            ],

            [
                'id' => 4,
                'image' => 'product-16-2.webp',
                'product_id' => 88630116,
                'admin_id' => 1
            ],
            [
                'id' => 5,
                'image' => 'product-16-3.webp',
                'product_id' => 88630116,
                'admin_id' => 1
            ],
            [
                'id' => 6,
                'image' => 'product-16-4.webp',
                'product_id' => 88630116,
                'admin_id' => 1
            ],
            [
                'id' => 7,
                'image' => 'product-18-2.webp',
                'product_id' => 88630118,
                'admin_id' => 1
            ],
            [
                'id' => 8,
                'image' => 'product-18-3.webp',
                'product_id' => 88630118,
                'admin_id' => 1
            ],
            [
                'id' => 9,
                'image' => 'product-21-2.webp',
                'product_id' => 88630121,
                'admin_id' => 1
            ],
            [
                'id' => 10,
                'image' => 'product-21-3.webp',
                'product_id' => 88630121,
                'admin_id' => 1
            ],
        ];



        $prod1 = Product::where('id', '88630116')->first();
        $prod2 = Product::where('id', '88630114')->first();
        $prod3 = Product::where('id', '88630121')->first();


        if(!ProductImage::first() && $prod1 && $prod2 && $prod3){
            foreach ($items as $i) {
                ProductImage::create($i);
            }
        }
    }
}
