<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
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
                'currency' => 'USD',
                'currency_icon' => '$',

                'phone' => '4534345656',
                'email' => 'webzedcontact@gmail.com',
                'address_1' => 'House 4/3, Road: 34, Bronx, NY',
                'city' => 'New York',
                'state' => 'New York',
                'zip' => '78947',
                'country' => 'USA',
                'admin_id' => 1
            ]
        ];


        $admin = Admin::where('id', 1)->first();

        if(!Setting::first() && $admin){
            foreach ($items as $i) {
                Setting::create($i);
            }
        }


    }
}
