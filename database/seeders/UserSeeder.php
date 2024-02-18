<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
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
                'name' => 'John Doe',
                'email' => 'john@mail.com',
                'password' => 'test',
                'google_id' => '453972431532227638935',
                'verified' => 1,
            ]
        ];


        if(!User::first()){
            foreach ($items as $i) {
                User::create($i);
            }
        }



    }
}
