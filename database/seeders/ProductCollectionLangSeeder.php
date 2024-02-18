<?php

namespace Database\Seeders;

use App\Models\ProductCollection;
use App\Models\ProductCollectionLang;
use Illuminate\Database\Seeder;

class ProductCollectionLangSeeder extends Seeder
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
                'title' => 'Özel Ürünler',
                'lang' => 'tr'
            ],
            [
                'product_collection_id' => 2,
                'title' => 'Trend olan ürünler',
                'lang' => 'tr'
            ],
            [
                'product_collection_id' => 3,
                'title' => 'En çok satan ürünler',
                'lang' => 'tr'
            ],



            [
                'product_collection_id' => 1,
                'title' => 'Produits populaires',
                'lang' => 'fr'
            ],
            [
                'product_collection_id' => 2,
                'title' => 'Produits tendance',
                'lang' => 'fr'
            ],
            [
                'product_collection_id' => 3,
                'title' => 'Produits les plus vendus',
                'lang' => 'fr'
            ],


            [
                'product_collection_id' => 1,
                'title' => 'विशेष रुप से प्रदर्शित प्रोडक्टस',
                'lang' => 'hi'
            ],
            [
                'product_collection_id' => 2,
                'title' => 'ट्रेंडिंग उत्पाद',
                'lang' => 'hi'
            ],
            [
                'product_collection_id' => 3,
                'title' => 'सबसे ज्यादा बिकने वाले उत्पाद',
                'lang' => 'hi'
            ],


            [
                'product_collection_id' => 1,
                'title' => 'منتجات مميزة',
                'lang' => 'ar'
            ],
            [
                'product_collection_id' => 2,
                'title' => 'المنتجات الرائجة',
                'lang' => 'ar'
            ],
            [
                'product_collection_id' => 3,
                'title' => 'المنتجات الأكثر مبيعًا',
                'lang' => 'ar'
            ]

        ];


        $pc1 = ProductCollection::where('id', 1)->first();
        $pc2 = ProductCollection::where('id', 2)->first();
        $pc3 = ProductCollection::where('id', 3)->first();

        if(!ProductCollectionLang::first() && $pc1 && $pc2 && $pc3){
            foreach ($items as $i) {
                ProductCollectionLang::create($i);
            }
        }
    }
}
