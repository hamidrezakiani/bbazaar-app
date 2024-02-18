<?php

namespace Database\Seeders;

use App\Models\AttributeLang;
use Illuminate\Database\Seeder;
use App\Models\Attribute;

class AttributeLangSeeder extends Seeder
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
                'attribute_id' => 1,
                'title' => 'Boyut',
                'lang' => 'tr'
            ],
            [
                'attribute_id' => 2,
                'title' => 'Renk',
                'lang' => 'tr'
            ],
            [
                'attribute_id' => 3,
                'title' => 'Veri deposu',
                'lang' => 'tr'
            ],



            [
                'attribute_id' => 1,
                'title' => 'Taille',
                'lang' => 'fr'
            ],
            [
                'attribute_id' => 2,
                'title' => 'Couleur',
                'lang' => 'fr'
            ],
            [
                'attribute_id' => 3,
                'title' => 'RAM',
                'lang' => 'fr'
            ],



            [
                'attribute_id' => 1,
                'title' => 'مقاس',
                'lang' => 'ar'
            ],
            [
                'attribute_id' => 2,
                'title' => 'لون',
                'lang' => 'ar'
            ],
            [
                'attribute_id' => 3,
                'title' => 'كبش',
                'lang' => 'ar'
            ],



            [
                'attribute_id' => 1,
                'title' => 'आकार',
                'lang' => 'hi'
            ],
            [
                'attribute_id' => 2,
                'title' => 'रंग',
                'lang' => 'hi'
            ],
            [
                'attribute_id' => 3,
                'title' => 'टक्कर मारना',
                'lang' => 'hi'
            ]
        ];



        $attr1 = Attribute::where('id', 1)->first();
        $attr2 = Attribute::where('id', 2)->first();
        $attr3 = Attribute::where('id', 3)->first();

        if(!AttributeLang::first() && $attr1 && $attr2 && $attr3){
            foreach ($items as $i) {
                AttributeLang::create($i);
            }
        }
    }
}
