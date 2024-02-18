<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\HeaderLink;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Config;

class HeaderLinksSeeder extends Seeder
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
                'title' => 'DISCOVER PRODUCTS',
                'url' => '/discover/products',
                'type' => Config::get('constants.headerLinkType.LEFT'),
                'admin_id' => 1
            ],
            [
                'id' => 2,
                'title' => 'CATEGORIES',
                'url' => '/categories',
                'type' => Config::get('constants.headerLinkType.LEFT'),
                'admin_id' => 1
            ],
            [
                'id' => 3,
                'title' => 'BRANDS',
                'url' => '/brands',
                'type' => Config::get('constants.headerLinkType.LEFT'),
                'admin_id' => 1
            ],
            [
                'id' => 4,
                'title' => 'HOT DEALS',
                'url' => '/flash-sale',
                'type' => Config::get('constants.headerLinkType.LEFT'),
                'admin_id' => 1
            ],

            [
                'id' => 5,
                'title' => 'TRACK ORDER',
                'url' => '/track-order',
                'type' => Config::get('constants.headerLinkType.RIGHT'),
                'admin_id' => 1
            ],
            [
                'id' => 6,
                'title' => 'FAQ',
                'url' => '/page/faq',
                'type' => Config::get('constants.headerLinkType.RIGHT'),
                'admin_id' => 1
            ],
            [
                'id' => 7,
                'title' => 'HELP',
                'url' => '/page/help',
                'type' => Config::get('constants.headerLinkType.RIGHT'),
                'admin_id' => 1
            ],
            [
                'id' => 8,
                'title' => 'CONTACT US',
                'url' => '/page/contact',
                'type' => Config::get('constants.headerLinkType.RIGHT'),
                'admin_id' => 1
            ],
        ];

        $admin1 = Admin::where('id', 1)->first();

        if(!HeaderLink::first() && $admin1){
            foreach ($items as $i) {
                HeaderLink::create($i);
            }
        }
    }
}
