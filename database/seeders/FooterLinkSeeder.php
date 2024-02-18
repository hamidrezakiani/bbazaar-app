<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\FooterLink;
use Illuminate\Database\Seeder;

class FooterLinkSeeder extends Seeder
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
                'page_id' => 1,
                'type' => 1,
                'admin_id' => 1
            ],
            [
                'page_id' => 2,
                'type' => 1,
                'admin_id' => 1
            ],
            [
                'page_id' => 3,
                'type' => 1,
                'admin_id' => 1
            ],
            [
                'page_id' => 4,
                'type' => 2,
                'admin_id' => 1
            ],
            [
                'page_id' => 5,
                'type' => 2,
                'admin_id' => 1
            ],
            [
                'page_id' => 6,
                'type' => 2,
                'admin_id' => 1
            ],
            [
                'page_id' => 7,
                'type' => 2,
                'admin_id' => 1
            ]
        ];

        $admin1 = Admin::where('id', 1)->first();

        if(!FooterLink::first() && $admin1){
            foreach ($items as $i) {
                FooterLink::create($i);
            }
        }
    }
}
