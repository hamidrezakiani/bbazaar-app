<?php

namespace Database\Seeders;

use App\Models\Helper\Utils;
use App\Models\Order;
use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
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
                'status' => 1,
                'order_method' => 2,
                'user_address_id' => 1,
                'user_id' => 1,
                'currency' => 'USD',
                'payment_done' => 0,
                'total_amount' => 232.6,
                'cancelled' => 0
            ],
            [
                'id' => 2,
                'status' => 1,
                'order_method' => 2,
                'user_address_id' => 1,
                'user_id' => 1,
                'currency' => 'USD',
                'payment_done' => 0,
                'total_amount' => 111.3,
                'cancelled' => 0
            ]
        ];


        $user = User::where('id', 1)->first();
        $ua = UserAddress::where('id', 1)->first();


        if(!Order::first() && $user && $ua){
            foreach ($items as $i) {
                $i['order'] = Utils::generateTrackingId($i);
                Order::create($i);
            }
        }


    }
}
