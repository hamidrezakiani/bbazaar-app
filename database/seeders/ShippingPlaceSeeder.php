<?php

namespace Database\Seeders;

use App\Models\ShippingPlace;
use App\Models\ShippingRule;
use Illuminate\Database\Seeder;

class ShippingPlaceSeeder extends Seeder
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
                'country' => 'ALL',
                'state' => '',
                'price' => 10,
                'day_needed' => 3,
                'admin_id' => 1,
                'pickup_price' => 5,
                'pickup_point' => true,
                'shipping_rule_id' => 1,
            ],
            [
                'id' => 2,
                'country' => 'AL',
                'state' => '09',
                'price' => 7,
                'day_needed' => 4,
                'admin_id' => 1,
                'pickup_price' => 5,
                'pickup_point' => false,
                'shipping_rule_id' => 1,
            ]
        ];



        $sr = ShippingRule::where('id', 1)->first();

        if(!ShippingPlace::first() && $sr){
            foreach ($items as $i) {
                ShippingPlace::create($i);
            }
        }


    }
}
