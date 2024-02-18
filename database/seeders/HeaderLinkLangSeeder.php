<?php

namespace Database\Seeders;

use App\Models\HeaderLink;
use App\Models\HeaderLinkLang;
use Illuminate\Database\Seeder;

class HeaderLinkLangSeeder extends Seeder
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
                'header_link_id' => 1,
                'title' => 'Ürünleri Keşfet',
                'lang' => 'tr'
            ],
            [
                'header_link_id' => 2,
                'title' => "Kategoriler",
                'lang' => 'tr'
            ],
            [
                'header_link_id' => 3,
                'title' => 'Markalar',
                'lang' => 'tr'
            ],
            [
                'header_link_id' => 4,
                'title' => 'Sıcak Fırsatlar',
                'lang' => 'tr'
            ],
            [
                'header_link_id' => 5,
                'title' => "Siparişi Takip Et",
                'lang' => 'tr'
            ],
            [
                'header_link_id' => 6,
                'title' => 'SSS',
                'lang' => 'tr'
            ],
            [
                'header_link_id' => 7,
                'title' => "Yardım",
                'lang' => 'tr'
            ],
            [
                'header_link_id' => 8,
                'title' => 'Bize ulaşın',
                'lang' => 'tr'
            ],




            [
                'header_link_id' => 1,
                'title' => 'उत्पादों की खोज करें',
                'lang' => 'hi'
            ],
            [
                'header_link_id' => 2,
                'title' => "श्रेणियाँ",
                'lang' => 'hi'
            ],
            [
                'header_link_id' => 3,
                'title' => 'ब्रांड्स',
                'lang' => 'hi'
            ],
            [
                'header_link_id' => 4,
                'title' => 'हॉट डील',
                'lang' => 'hi'
            ],
            [
                'header_link_id' => 5,
                'title' => "ट्रैक ऑर्डर",
                'lang' => 'hi'
            ],
            [
                'header_link_id' => 6,
                'title' => 'अक्सर पूछे जाने वाले प्रश्न',
                'lang' => 'hi'
            ],
            [
                'header_link_id' => 7,
                'title' => "सहायता",
                'lang' => 'hi'
            ],
            [
                'header_link_id' => 8,
                'title' => 'हमसे संपर्क करें',
                'lang' => 'hi'
            ],




            [
                'header_link_id' => 1,
                'title' => 'Découvrir les produits',
                'lang' => 'fr'
            ],
            [
                'header_link_id' => 2,
                'title' => "Catégories",
                'lang' => 'fr'
            ],
            [
                'header_link_id' => 3,
                'title' => 'Marques',
                'lang' => 'fr'
            ],
            [
                'header_link_id' => 4,
                'title' => 'Offres exceptionnelles',
                'lang' => 'fr'
            ],
            [
                'header_link_id' => 5,
                'title' => "Suivre la commande",
                'lang' => 'fr'
            ],
            [
                'header_link_id' => 6,
                'title' => 'FAQ',
                'lang' => 'fr'
            ],
            [
                'header_link_id' => 7,
                'title' => "Aide",
                'lang' => 'fr'
            ],
            [
                'header_link_id' => 8,
                'title' => 'Contactez-nous',
                'lang' => 'fr'
            ],



            [
                'header_link_id' => 1,
                'title' => 'اكتشف المنتجات',
                'lang' => 'ar'
            ],
            [
                'header_link_id' => 2,
                'title' => "الفئات",
                'lang' => 'ar'
            ],
            [
                'header_link_id' => 3,
                'title' => 'العلامات التجارية',
                'lang' => 'ar'
            ],
            [
                'header_link_id' => 4,
                'title' => 'عروض ساخنة',
                'lang' => 'ar'
            ],
            [
                'header_link_id' => 5,
                'title' => "تتبع الطلب",
                'lang' => 'ar'
            ],
            [
                'header_link_id' => 6,
                'title' => 'التعليمات',
                'lang' => 'ar'
            ],
            [
                'header_link_id' => 7,
                'title' => "مساعدة",
                'lang' => 'ar'
            ],
            [
                'header_link_id' => 8,
                'title' => 'اتصل بنا',
                'lang' => 'ar'
            ],




        ];


        $item1 = HeaderLink::where('id', 1)->first();
        $item2 = HeaderLink::where('id', 2)->first();
        $item3 = HeaderLink::where('id', 3)->first();
        $item5 = HeaderLink::where('id', 5)->first();
        $item7 = HeaderLink::where('id', 7)->first();
        $item8 = HeaderLink::where('id', 8)->first();


        if(!HeaderLinkLang::first() && $item1 && $item2 && $item3 && $item5 && $item7 && $item8){
            foreach ($items as $i) {
                HeaderLinkLang::create($i);
            }
        }
    }
}
