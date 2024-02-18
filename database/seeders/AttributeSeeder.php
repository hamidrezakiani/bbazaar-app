<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Attribute;
use Illuminate\Database\Seeder;

class AttributeSeeder extends Seeder
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
                'title' => 'Size',
                'admin_id' => 1
            ],
            [
                'id' => 2,
                'title' => 'Color',
                'admin_id' => 1
            ],
            [
                'id' => 3,
                'title' => 'Ram',
                'admin_id' => 1
            ]
        ];

        $admin1 = Admin::where('id', 1)->first();

        if(!Attribute::first() && $admin1){
            foreach ($items as $i) {
                Attribute::create($i);
            }
        }
    }
}
