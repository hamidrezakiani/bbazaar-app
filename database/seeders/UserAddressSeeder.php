<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Database\Seeder;

class UserAddressSeeder extends Seeder
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
                'country' => 'AF',
                'state' => 'BDS',
                'user_id' => 1,
                'city' => 'Khulna',
                'zip' => '9100',
                'address_1' => 'Address line 1',
                'address_2' => 'Address line 2',
                'name' => 'Roman Ahmed',
                'phone' => '3435676546',
                'default' => 2,
            ]
        ];


        $user = User::where('id', 1)->first();

        if(!UserAddress::first() && $user){
            foreach ($items as $i) {
                UserAddress::create($i);
            }
        }




    }
}
