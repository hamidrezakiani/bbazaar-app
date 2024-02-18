<?php

namespace Database\Seeders;

use App\Models\AttributeLang;
use App\Models\AttributeValueLang;
use Illuminate\Database\Seeder;

class AttributeValueLangSeeder extends Seeder
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
                'attribute_value_id' => 1,
                'title' => 'एक्स्ट्रा लार्ज',
                'lang' => 'hi'
            ],
            [
                'attribute_value_id' => 2,
                'title' => 'एल',
                'lang' => 'hi'
            ],
            [
                'attribute_value_id' => 3,
                'title' => 'एम',
                'lang' => 'hi'
            ],
            [
                'attribute_value_id' => 4,
                'title' => 'एस',
                'lang' => 'hi'
            ],
            [
                'attribute_value_id' => 5,
                'title' => 'एक्सएस',
                'lang' => 'hi'
            ],
            [
                'attribute_value_id' => 6,
                'title' => 'सफ़ेद',
                'lang' => 'hi'
            ],
            [
                'attribute_value_id' => 7,
                'title' => 'नीला',
                'lang' => 'hi'
            ],
            [
                'attribute_value_id' => 8,
                'title' => 'राख',
                'lang' => 'hi'
            ],
            [
                'attribute_value_id' => 9,
                'title' => 'नारंगी',
                'lang' => 'hi'
            ],
            [
                'attribute_value_id' => 10,
                'title' => 'हरा',
                'lang' => 'hi'
            ],
            [
                'attribute_value_id' => 11,
                'title' => '1 जीबी',
                'lang' => 'hi'
            ],
            [
                'attribute_value_id' => 12,
                'title' => '2 जीबी',
                'lang' => 'hi'
            ],



            [
                'attribute_value_id' => 1,
                'title' => 'XL',
                'lang' => 'fr'
            ],
            [
                'attribute_value_id' => 2,
                'title' => 'L',
                'lang' => 'fr'
            ],
            [
                'attribute_value_id' => 3,
                'title' => 'M',
                'lang' => 'fr'
            ],
            [
                'attribute_value_id' => 4,
                'title' => 'S',
                'lang' => 'fr'
            ],
            [
                'attribute_value_id' => 5,
                'title' => 'XS',
                'lang' => 'fr'
            ],
            [
                'attribute_value_id' => 6,
                'title' => 'Blanc',
                'lang' => 'fr'
            ],
            [
                'attribute_value_id' => 7,
                'title' => 'Bleue',
                'lang' => 'fr'
            ],
            [
                'attribute_value_id' => 8,
                'title' => 'Cendre',
                'lang' => 'fr'
            ],
            [
                'attribute_value_id' => 9,
                'title' => 'Orange',
                'lang' => 'fr'
            ],
            [
                'attribute_value_id' => 10,
                'title' => 'Vert',
                'lang' => 'fr'
            ],
            [
                'attribute_value_id' => 11,
                'title' => '1 Go',
                'lang' => 'fr'
            ],
            [
                'attribute_value_id' => 12,
                'title' => '2 Go',
                'lang' => 'fr'
            ],



            [
                'attribute_value_id' => 1,
                'title' => 'XL',
                'lang' => 'ar'
            ],
            [
                'attribute_value_id' => 2,
                'title' => 'L',
                'lang' => 'ar'
            ],
            [
                'attribute_value_id' => 3,
                'title' => 'M',
                'lang' => 'ar'
            ],
            [
                'attribute_value_id' => 4,
                'title' => 'S',
                'lang' => 'ar'
            ],
            [
                'attribute_value_id' => 5,
                'title' => 'XS',
                'lang' => 'ar'
            ],
            [
                'attribute_value_id' => 6,
                'title' => 'أبيض',
                'lang' => 'ar'
            ],
            [
                'attribute_value_id' => 7,
                'title' => 'أزرق',
                'lang' => 'ar'
            ],
            [
                'attribute_value_id' => 8,
                'title' => 'رماد',
                'lang' => 'ar'
            ],
            [
                'attribute_value_id' => 9,
                'title' => 'البرتقالي',
                'lang' => 'ar'
            ],
            [
                'attribute_value_id' => 10,
                'title' => 'أخضر',
                'lang' => 'ar'
            ],
            [
                'attribute_value_id' => 11,
                'title' => '1 جيجابايت',
                'lang' => 'ar'
            ],
            [
                'attribute_value_id' => 12,
                'title' => '2 جيجابايت',
                'lang' => 'ar'
            ],



            [
                'attribute_value_id' => 1,
                'title' => 'XL',
                'lang' => 'tr'
            ],
            [
                'attribute_value_id' => 2,
                'title' => 'L',
                'lang' => 'tr'
            ],
            [
                'attribute_value_id' => 3,
                'title' => 'M',
                'lang' => 'tr'
            ],
            [
                'attribute_value_id' => 4,
                'title' => 'S',
                'lang' => 'tr'
            ],
            [
                'attribute_value_id' => 5,
                'title' => 'XS',
                'lang' => 'tr'
            ],
            [
                'attribute_value_id' => 6,
                'title' => 'Beyaz',
                'lang' => 'tr'
            ],
            [
                'attribute_value_id' => 7,
                'title' => 'Mavi',
                'lang' => 'tr'
            ],
            [
                'attribute_value_id' => 8,
                'title' => 'Kül',
                'lang' => 'tr'
            ],
            [
                'attribute_value_id' => 9,
                'title' => 'Turuncu',
                'lang' => 'tr'
            ],
            [
                'attribute_value_id' => 10,
                'title' => 'Yeşil',
                'lang' => 'tr'
            ],
            [
                'attribute_value_id' => 11,
                'title' => '1GB',
                'lang' => 'tr'
            ],
            [
                'attribute_value_id' => 12,
                'title' => '2GB',
                'lang' => 'tr'
            ]
        ];


        $attrVal1 = AttributeLang::where('id', 1)->first();
        $attrVal8 = AttributeLang::where('id', 8)->first();
        $attrVal2 = AttributeLang::where('id', 2)->first();


        if(!AttributeValueLang::first() && $attrVal1 && $attrVal8 && $attrVal2){
            foreach ($items as $i) {
                AttributeValueLang::create($i);
            }
        }
    }
}
