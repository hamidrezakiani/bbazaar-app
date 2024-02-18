<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\AttributeValue;
use Illuminate\Database\Seeder;

class AttributeValueSeeder extends Seeder
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
                'title' => 'XL',
                'attribute_id' => 1,
                'admin_id' => 1
            ],
            [
                'id' => 2,
                'title' => 'L',
                'attribute_id' => 1,
                'admin_id' => 1
            ],
            [
                'id' => 3,
                'title' => 'M',
                'attribute_id' => 1,
                'admin_id' => 1
            ],
            [
                'id' => 4,
                'title' => 'S',
                'attribute_id' => 1,
                'admin_id' => 1
            ],
            [
                'id' => 5,
                'title' => 'XS',
                'attribute_id' => 1,
                'admin_id' => 1
            ],
            [
                'id' => 6,
                'title' => 'White',
                'attribute_id' => 2,
                'admin_id' => 1
            ],
            [
                'id' => 7,
                'title' => 'Blue',
                'attribute_id' => 2,
                'admin_id' => 1
            ],
            [
                'id' => 8,
                'title' => 'Ash',
                'attribute_id' => 2,
                'admin_id' => 1
            ],
            [
                'id' => 9,
                'title' => 'Orange',
                'attribute_id' => 2,
                'admin_id' => 1
            ],
            [
                'id' => 10,
                'title' => 'Green',
                'attribute_id' => 2,
                'admin_id' => 1
            ],
            [
                'id' => 11,
                'title' => '1GB',
                'attribute_id' => 3,
                'admin_id' => 1
            ],
            [
                'id' => 12,
                'title' => '2GB',
                'attribute_id' => 3,
                'admin_id' => 1
            ]
        ];



        $admin1 = Admin::where('id', 1)->first();

        if(!AttributeValue::first() && $admin1){
            foreach ($items as $i) {
                AttributeValue::create($i);
            }
        }
    }
}
