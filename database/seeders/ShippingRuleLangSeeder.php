<?php

namespace Database\Seeders;

use App\Models\ShippingRule;
use App\Models\ShippingRuleLang;
use Illuminate\Database\Seeder;

class ShippingRuleLangSeeder extends Seeder
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
                'shipping_rule_id' => 1,
                'title' => 'Varsayılan',
                'lang' => 'tr',
            ],

            [
                'shipping_rule_id' => 1,
                'title' => 'تقصير',
                'lang' => 'ar',
            ],


            [
                'shipping_rule_id' => 1,
                'title' => 'Défaut',
                'lang' => 'fr',
            ],

            [
                'shipping_rule_id' => 1,
                'title' => 'गलती करना',
                'lang' => 'hi',
            ]

        ];


        $sr = ShippingRule::where('id', 1)->first();


        if (!ShippingRuleLang::first() && $sr) {
            foreach ($items as $i) {
                ShippingRuleLang::create($i);
            }
        }
    }
}
