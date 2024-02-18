<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\BrandLang;
use Illuminate\Database\Seeder;

class BrandLangSeeder extends Seeder
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
                'brand_id' => 9442200,
                'title' => 'लेवी \' s',
                'lang' => 'hi'
            ],
            [
                'brand_id' => 9442201,
                'title' => 'अडीडास',
                'lang' => 'hi'
            ],
            [
                'brand_id' => 9442202,
                'title' => 'एच एंड एम',
                'lang' => 'hi'
            ],
            [
                'brand_id' => 9442203,
                'title' => 'रोलेक्स',
                'lang' => 'hi'
            ],

            [
                'brand_id' => 9442204,
                'title' => 'सेब',
                'lang' => 'hi'
            ],
            [
                'brand_id' => 9442205,
                'title' => 'गुच्ची',
                'lang' => 'hi'
            ],
            [
                'brand_id' => 9442206,
                'title' => 'श्नेल',
                'lang' => 'hi'
            ],
            [
                'brand_id' => 9442207,
                'title' => 'ज़ारा',
                'lang' => 'hi'
            ],
            [
                'brand_id' => 9442208,
                'title' => 'नाइके',
                'lang' => 'hi'
            ],
            [
                'brand_id' => 9442209,
                'title' => 'जिलेट',
                'lang' => 'hi'
            ],
            [
                'brand_id' => 9442210,
                'title' => 'एक्सेंचर',
                'lang' => 'hi'
            ],
            [
                'brand_id' => 9442211,
                'title' => 'नेस्कैफे',
                'lang' => 'hi'
            ],
            [
                'brand_id' => 9442212,
                'title' => 'लोरियल',
                'lang' => 'hi'
            ],


            [
                'brand_id' => 9442200,
                'title' => 'Levi \' s',
                'lang' => 'fr'
            ],
            [
                'brand_id' => 9442201,
                'title' => 'Addidas',
                'lang' => 'fr'
            ],
            [
                'brand_id' => 9442202,
                'title' => 'H&M',
                'lang' => 'fr'
            ],
            [
                'brand_id' => 9442203,
                'title' => 'Rolex',
                'lang' => 'fr'
            ],
            [
                'brand_id' => 9442204,
                'title' => 'Pomme',
                'lang' => 'fr'
            ],
            [
                'brand_id' => 9442205,
                'title' => 'Gucci',
                'lang' => 'fr'
            ],
            [
                'brand_id' => 9442206,
                'title' => 'Schnell',
                'lang' => 'fr'
            ],
            [
                'brand_id' => 9442207,
                'title' => 'Zara',
                'lang' => 'fr'
            ],
            [
                'brand_id' => 9442208,
                'title' => 'Nike',
                'lang' => 'fr'
            ],
            [
                'brand_id' => 9442209,
                'title' => 'Gillette',
                'lang' => 'fr'
            ],
            [
                'brand_id' => 9442210,
                'title' => 'Accenture',
                'lang' => 'fr'
            ],
            [
                'brand_id' => 9442211,
                'title' => 'Nescafé',
                'lang' => 'fr'
            ],
            [
                'brand_id' => 9442212,
                'title' => 'Loréal',
                'lang' => 'fr'
            ],


            [
                'brand_id' => 9442200,
                'title' => "Levi'ler",
                'lang' => 'tr'
            ],
            [
                'brand_id' => 9442201,
                'title' => 'Addidas',
                'lang' => 'tr'
            ],
            [
                'brand_id' => 9442202,
                'title' => 'H&M',
                'lang' => 'tr'
            ],
            [
                'brand_id' => 9442203,
                'title' => 'Rolex',
                'lang' => 'tr'
            ],
            [
                'brand_id' => 9442204,
                'title' => 'Elma',
                'lang' => 'tr'
            ],
            [
                'brand_id' => 9442205,
                'title' => 'Gucci',
                'lang' => 'tr'
            ],
            [
                'brand_id' => 9442206,
                'title' => 'Schnell',
                'lang' => 'tr'
            ],
            [
                'brand_id' => 9442207,
                'title' => 'Zara',
                'lang' => 'tr'
            ],
            [
                'brand_id' => 9442208,
                'title' => 'Nike',
                'lang' => 'tr'
            ],
            [
                'brand_id' => 9442209,
                'title' => 'Gillette',
                'lang' => 'tr'
            ],
            [
                'brand_id' => 9442210,
                'title' => 'Accenture',
                'lang' => 'tr'
            ],
            [
                'brand_id' => 9442211,
                'title' => 'Nescafe',
                'lang' => 'tr'
            ],
            [
                'brand_id' => 9442212,
                'title' => 'Loreal',
                'lang' => 'tr'
            ],



            [
                'brand_id' => 9442200,
                'title' => "ليفي",
                'lang' => 'ar'
            ],
            [
                'brand_id' => 9442201,
                'title' => 'شركة اديداس',
                'lang' => 'ar'
            ],
            [
                'brand_id' => 9442202,
                'title' => 'اتش اند ام',
                'lang' => 'ar'
            ],
            [
                'brand_id' => 9442203,
                'title' => 'رولكس',
                'lang' => 'ar'
            ],
            [
                'brand_id' => 9442204,
                'title' => 'إلما',
                'lang' => 'ar'
            ],
            [
                'brand_id' => 9442205,
                'title' => 'غوتشي',
                'lang' => 'ar'
            ],
            [
                'brand_id' => 9442206,
                'title' => 'شنيل',
                'lang' => 'ar'
            ],
            [
                'brand_id' => 9442207,
                'title' => 'زارا',
                'lang' => 'ar'
            ],
            [
                'brand_id' => 9442208,
                'title' => 'نايك',
                'lang' => 'ar'
            ],
            [
                'brand_id' => 9442209,
                'title' => 'جيليت',
                'lang' => 'ar'
            ],
            [
                'brand_id' => 9442210,
                'title' => 'أكسنتشر',
                'lang' => 'ar'
            ],
            [
                'brand_id' => 9442211,
                'title' => 'نسكافيه',
                'lang' => 'ar'
            ],
            [
                'brand_id' => 9442212,
                'title' => 'لوريال',
                'lang' => 'ar'
            ],

        ];


        $brand1 = Brand::where('id', '9442207')->first();
        $brand2 = Brand::where('id', '9442210')->first();
        $brand3 = Brand::where('id', '9442212')->first();


        if (!BrandLang::first() && $brand1 && $brand2 && $brand3) {
            foreach ($items as $i) {
                BrandLang::create($i);
            }
        }
    }
}
