<?php

namespace Database\Seeders;

use App\Models\BannerLang;
use Illuminate\Database\Seeder;

class BannerLangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $banners = [
            [
                'banner_id' => 1,
                'title' => 'Satış',
                'lang' => 'tr'
            ],
            [
                'banner_id' => 2,
                'title' => 'Fiş',
                'lang' => 'tr'
            ],
            [
                'banner_id' => 3,
                'title' => 'İndirim',
                'lang' => 'tr'
            ],
            [
                'banner_id' => 4,
                'title' => 'Kara Cuma',
                'lang' => 'tr'
            ],
            [
                'banner_id' => 5,
                'title' => 'Yaz modası',
                'lang' => 'tr'
            ],
            [
                'banner_id' => 6,
                'title' => 'Sonbahar Teklifi',
                'lang' => 'tr'
            ],
            [
                'banner_id' => 7,
                'title' => 'Noel Teklifi',
                'lang' => 'tr'
            ],
            [
                'banner_id' => 8,
                'title' => '%45 İndirim',
                'lang' => 'tr'
            ],
            [
                'banner_id' => 9,
                'title' => 'Ücretsiz kargo',
                'lang' => 'tr'
            ],


            [
                'banner_id' => 1,
                'title' => 'बिक्री',
                'lang' => 'hi'
            ],
            [
                'banner_id' => 2,
                'title' => 'वाउचर',
                'lang' => 'hi'
            ],
            [
                'banner_id' => 3,
                'title' => 'छूट',
                'lang' => 'hi'
            ],
            [
                'banner_id' => 4,
                'title' => 'ब्लैक फ्राइडे',
                'lang' => 'hi'
            ],
            [
                'banner_id' => 5,
                'title' => 'ग्रीष्मकालीन फैशन',
                'lang' => 'hi'
            ],
            [
                'banner_id' => 6,
                'title' => 'ऑटम ऑफर',
                'lang' => 'hi'
            ],
            [
                'banner_id' => 7,
                'title' => 'क्रिसमस ऑफर',
                'lang' => 'hi'
            ],
            [
                'banner_id' => 8,
                'title' => '45% की छूट',
                'lang' => 'hi'
            ],
            [
                'banner_id' => 9,
                'title' => 'मुफ़्त शिपिंग',
                'lang' => 'hi'
            ],



            [
                'banner_id' => 1,
                'title' => 'Vente',
                'lang' => 'fr'
            ],
            [
                'banner_id' => 2,
                'title' => 'Bon',
                'lang' => 'fr'
            ],
            [
                'banner_id' => 3,
                'title' => 'Réduction',
                'lang' => 'fr'
            ],
            [
                'banner_id' => 4,
                'title' => 'Vendredi noir',
                'lang' => 'fr'
            ],
            [
                'banner_id' => 5,
                'title' => "Mode d'été",
                 'lang' => 'fr'
             ],
             [
                 'banner_id' => 6,
                 'title' => 'Offre Automne',
                 'lang' => 'fr'
             ],
             [
                 'banner_id' => 7,
                 'title' => 'Offre de Noël',
                 'lang' => 'fr'
             ],
             [
                 'banner_id' => 8,
                 'title' => '45% de réduction',
                 'lang' => 'fr'
             ],
             [
                 'banner_id' => 9,
                 'title' => 'Livraison gratuite',
                 'lang' => 'fr'
             ],



            [
                "banner_id" => 1,
                'title' => 'أُوكَازيُون',
                'lang' => 'ar'
            ],
            [
                "banner_id" => 2,
                "title" => "القسيمة",
                'lang' => 'ar'
            ],
            [
                "banner_id" => 3,
                "title" => "الخصم",
                'lang' => 'ar'
            ],
            [
                "banner_id" => 4,
                "title" => "الجمعة السوداء",
                'lang' => 'ar'
            ],
            [
                "banner_id" => 5,
                "title" => "أزياء الصيف",
                'lang' => 'ar'
            ],
            [
                "banner_id" => 6,
                "title" => "عرض الخريف",
                'lang' => 'ar'
            ],
            [
                "banner_id" => 7,
                "title" => "عرض عيد الميلاد",
                'lang' => 'ar'
            ],
            [
                "banner_id" => 8,
                "title" => "خصم 45٪",
                'lang' => 'ar'
            ],
            [
                "banner_id" => 9,
                "title" => "شحن مجاني",
                'lang' => 'ar'
            ]
        ];


        if (is_null(BannerLang::first())) {
            foreach ($banners as $i) {
                BannerLang::create($i);
            }
        }

    }
}
