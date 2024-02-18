<?php

namespace Database\Seeders;

use App\Models\HomeSlider;
use App\Models\HomeSliderLang;
use Illuminate\Database\Seeder;

class HomeSliderLangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $homeSliders = [
            [
                'home_slider_id' => 1,
                'title' => 'Kış indirimi',
                'lang' => 'tr'
            ],
            [
                'home_slider_id' => 2,
                'title' => 'Flaş %50 indirimli',
                'lang' => 'tr'
            ],
            [
                'home_slider_id' => 3,
                'title' => 'Kara Cuma İndirimi',
                'lang' => 'tr'
            ],
            [
                'home_slider_id' => 4,
                'title' => 'Erkekler için sırt çantası',
                'lang' => 'tr'
            ],
            [
                'home_slider_id' => 5,
                'title' => 'Puma Stilist Ayakkabı',
                'lang' => 'tr'
            ],


            [
                'home_slider_id' => 1,
                'title' => 'تنزيلات الشتاء',
                'lang' => 'ar'
            ],
            [
                'home_slider_id' => 2,
                'title' => 'فلاش 50٪ خصم',
                'lang' => 'ar'
            ],
            [
                'home_slider_id' => 3,
                'title' => 'خصم الجمعة السوداء',
                'lang' => 'ar'
            ],
            [
                'home_slider_id' => 4,
                'title' => 'حقيبة ظهر للرجال',
                'lang' => 'ar'
            ],
            [
                'home_slider_id' => 5,
                'title' => 'أحذية المصمم بوما',
                'lang' => 'ar'
            ],


            [
                'home_slider_id' => 1,
                'title' => "Soldes d'hiver",
                'lang' => 'fr'
            ],
            [
                'home_slider_id' => 2,
                'title' => 'Flash 50% de réduction',
                'lang' => 'fr'
            ],
            [
                'home_slider_id' => 3,
                'title' => 'Remise Black Friday',
                'lang' => 'fr'
            ],
            [
                'home_slider_id' => 4,
                'title' => 'Sac à dos pour hommes',
                'lang' => 'fr'
            ],
            [
                'home_slider_id' => 5,
                'title' => 'Puma Styliste Chaussures',
                'lang' => 'fr'
            ],


            [
                'home_slider_id' => 1,
                'title' => 'सर्दी की सेल',
                'lang' => 'hi'
            ],
            [
                'home_slider_id' => 2,
                'title' => 'फ्लैश 50% बंद',
                'lang' => 'hi'
            ],
            [
                'home_slider_id' => 3,
                'title' => 'ब्लैक फ्राइडे डिस्काउंट',
                'lang' => 'hi'
            ],
            [
                'home_slider_id' => 4,
                'title' => 'पुरुषों के लिए बैकपैक',
                'lang' => 'hi'
            ],
            [
                'home_slider_id' => 5,
                'title' => 'प्यूमा स्टाइलिस्ट जूते',
                'lang' => 'hi'
            ]
        ];



        $homeSlider1 = HomeSlider::where('id', 1)->first();
        $homeSlider2 = HomeSlider::where('id', 2)->first();
        $homeSlider3 = HomeSlider::where('id', 3)->first();
        $homeSlider4 = HomeSlider::where('id', 4)->first();
        $homeSlider5 = HomeSlider::where('id', 5)->first();


        if (!HomeSliderLang::first() && $homeSlider1 && $homeSlider2 && $homeSlider3 && $homeSlider4 && $homeSlider5) {
            foreach ($homeSliders as $i) {
                HomeSliderLang::create($i);
            }
        }
    }
}
