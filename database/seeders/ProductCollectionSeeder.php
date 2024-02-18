<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\ProductCollection;
use Illuminate\Database\Seeder;

class ProductCollectionSeeder extends Seeder
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
                'title' => 'Featured products',
                'status' => 1,
                'admin_id' => 1
            ],
            [
                'id' => 2,
                'title' => 'Trending products',
                'status' => 1,
                'admin_id' => 1
            ],
            [
                'id' => 3,
                'title' => 'Top selling products',
                'status' => 1,
                'admin_id' => 1
            ]
        ];


        $admin = Admin::where('id', 1)->first();


        if(!ProductCollection::first() && $admin){
            foreach ($items as $i) {
                ProductCollection::create($i);
            }
        }
    }
}
