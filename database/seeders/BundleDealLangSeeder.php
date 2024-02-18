<?php

namespace Database\Seeders;

use App\Models\BundleDeal;
use App\Models\BundleDealLang;
use Illuminate\Database\Seeder;

class BundleDealLangSeeder extends Seeder
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
                'bundle_deal_id' => 1,
                'title' => 'أشتري 1 و أحصل على 1',
                'lang' => 'ar'
            ],


            [
                'bundle_deal_id' => 1,
                'title' => 'एक खरीदें, दूसरी मुफ़्त पाएं',
                'lang' => 'hi'
            ],


            [
                'bundle_deal_id' => 1,
                'title' => '1 Al 1 Al',
                'lang' => 'tr'
            ],


            [
                'bundle_deal_id' => 1,
                'title' => 'Acheter 1 obtenez 1',
                'lang' => 'fr'
            ]
        ];


        $bundleDeal = BundleDeal::where('id', 1)->first();


        if(!BundleDealLang::first() && $bundleDeal){
            foreach ($items as $i) {
                BundleDealLang::create($i);
            }
        }
    }
}
