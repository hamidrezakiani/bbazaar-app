<?php

namespace Database\Seeders;

use App\Models\FlashSale;
use App\Models\FlashSaleLang;
use Illuminate\Database\Seeder;

class FlashSaleLangSeeder extends Seeder
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
                'title' => 'Yeni Yıl İndirimi',
                'lang' => 'tr'
            ],

            [
                'title' => 'تخفيضات العام الجديد',
                'lang' => 'ar'
            ],

            [
                'title' => 'Vente du Nouvel An',
                'lang' => 'fr'
            ],


            [
                'title' => 'नए साल की बिक्री',
                'lang' => 'hi'
            ]
        ];


        $flashSale = FlashSale::first();

        if(!FlashSaleLang::first()){
            foreach ($items as $i) {
                $i['flash_sale_id'] = $flashSale->id;
                FlashSaleLang::create($i);
            }
        }
    }
}
