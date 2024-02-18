<?php

namespace Database\Seeders;

use App\Models\TaxRuleLang;
use App\Models\TaxRules;
use Illuminate\Database\Seeder;

class TaxRuleLangSeeder extends Seeder
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
                'tax_rule_id' => 1,
                'title' => 'Varsayılan',
                'lang' => 'tr',
            ],

            [
                'tax_rule_id' => 1,
                'title' => 'تقصير',
                'lang' => 'ar',
            ],


            [
                'tax_rule_id' => 1,
                'title' => 'Défaut',
                'lang' => 'fr',
            ],

            [
                'tax_rule_id' => 1,
                'title' => 'गलती करना',
                'lang' => 'hi',
            ]
        ];



        $tr1 = TaxRules::where('id', 1)->first();


        if (!TaxRuleLang::first() && $tr1) {
            foreach ($items as $i) {
                TaxRuleLang::create($i);
            }
        }
    }
}
