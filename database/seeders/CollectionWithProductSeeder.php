<?php

namespace Database\Seeders;

use App\Models\CollectionWithProduct;
use App\Models\Product;
use App\Models\ProductCollection;
use Illuminate\Database\Seeder;

class
CollectionWithProductSeeder extends Seeder
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
                'product_collection_id' => 1,
                'product_id' => 88630111
            ],
            [
                'product_collection_id' => 2,
                'product_id' => 88630112
            ],
            [
                'product_collection_id' => 3,
                'product_id' => 88630113
            ],
            [
                'product_collection_id' => 1,
                'product_id' => 88630114
            ],
            [
                'product_collection_id' => 2,
                'product_id' => 88630115
            ],
            [
                'product_collection_id' => 3,
                'product_id' => 88630116
            ],
            [
                'product_collection_id' => 1,
                'product_id' => 88630117
            ],
            [
                'product_collection_id' => 3,
                'product_id' => 88630119
            ],
            [
                'product_collection_id' => 1,
                'product_id' => 88630120
            ],
            [
                'product_collection_id' => 2,
                'product_id' => 88630121
            ],
            [
                'product_collection_id' => 3,
                'product_id' => 88630122
            ],
            [
                'product_collection_id' => 1,
                'product_id' => 88630123
            ],
            [
                'product_collection_id' => 2,
                'product_id' => 88630124
            ],
            [
                'product_collection_id' => 3,
                'product_id' => 88630125
            ],
            [
                'product_collection_id' => 1,
                'product_id' => 88630126
            ],
            [
                'product_collection_id' => 2,
                'product_id' => 88630127
            ],
            [
                'product_collection_id' => 3,
                'product_id' => 88630128
            ],
            [
                'product_collection_id' => 1,
                'product_id' => 88630129
            ],
            [
                'product_collection_id' => 2,
                'product_id' => 88630130
            ],
            [
                'product_collection_id' => 3,
                'product_id' => 88630131
            ],
            [
                'product_collection_id' => 1,
                'product_id' => 88630132
            ],
            [
                'product_collection_id' => 2,
                'product_id' => 88630133
            ],
            [
                'product_collection_id' => 3,
                'product_id' => 88630134
            ],
            [
                'product_collection_id' => 1,
                'product_id' => 88630135
            ],
            [
                'product_collection_id' => 2,
                'product_id' => 88630136
            ],
            [
                'product_collection_id' => 3,
                'product_id' => 88630137
            ]
        ];



        $prod1 = Product::where('id', '88630137')->first();
        $prod2 = Product::where('id', '88630136')->first();
        $prod3 = Product::where('id', '88630135')->first();
        $prod4 = Product::where('id', '88630133')->first();
        $prod5 = Product::where('id', '88630127')->first();
        $prod6 = Product::where('id', '88630111')->first();

        $pc1 = ProductCollection::where('id', 1)->first();
        $pc2 = ProductCollection::where('id', 2)->first();
        $pc3 = ProductCollection::where('id', 3)->first();


        $valid = $prod1 && $prod2 && $prod3 && $prod4 && $prod5 && $prod6 && $pc1 && $pc2 && $pc3;


        if (!CollectionWithProduct::first() && $valid) {
            foreach ($items as $i) {
                CollectionWithProduct::create($i);
            }
        }
    }
}
