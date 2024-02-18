<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Store;
use Illuminate\Database\Seeder;

class StoreSeeder extends Seeder
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
                'image' => 'logo-ishop.png',
                'name' => 'Ishop',
                'slug' => 'ishop',
                'meta_title' => 'Ishop Mega Mall | Ishop',
                'meta_description' => 'Shop online with Ishop Mega Mall now! Visit Ishop Mega Mall on Ishop.',
                'admin_id' => 1
            ],

            [
                'id' => 2,
                'image' => 'logo-jshop.png',
                'name' => 'Jshop',
                'slug' => 'jshop',
                'meta_title' => 'Jshop Mega Mall | Jshop',
                'meta_description' => 'Shop online with Jshop Mega Mall now! Visit Jshop Mega Mall on Jshop.',
                'admin_id' => 2
            ]
        ];

        $admin = Admin::where('id', 1)->first();

        if(!Store::first() && $admin){
            foreach ($items as $i) {
                Store::create($i);
            }
        }


    }

}
