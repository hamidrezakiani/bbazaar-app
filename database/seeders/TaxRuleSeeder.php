<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\TaxRules;
use Illuminate\Database\Seeder;

class TaxRuleSeeder extends Seeder
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
                'id' => 1,
                'title' => 'Default',
                'type' => 2,
                'price' => 3,
                'admin_id' => 1
            ]
        ];

        $admin1 = Admin::where('id', 1)->first();


        if(!TaxRules::first() && $admin1){
            foreach ($items as $i) {
                TaxRules::create($i);
            }
        }
    }
}
