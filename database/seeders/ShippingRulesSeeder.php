<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\ShippingRule;
use Illuminate\Database\Seeder;

class ShippingRulesSeeder extends Seeder
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
                'admin_id' => 1
            ]
        ];


        $admin = Admin::where('id', 1)->first();

        if(!ShippingRule::first() && $admin){
            foreach ($items as $i) {
                ShippingRule::create($i);
            }
        }


    }
}
