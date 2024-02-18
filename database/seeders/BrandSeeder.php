<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Brand;
use App\Models\Helper\Utils;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
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
                'id' => 9442200,
                'title' => 'Levi\'s',
                'image' => 'levis.webp',
                'status' => 1,
                'featured' => 1,
                'admin_id' => 1
            ],
            [
                'id' => 9442201,
                'title' => 'Addidas',
                'image' => 'addidas.webp',
                'status' => 1,
                'featured' => 1,
                'admin_id' => 1
            ],
            [
                'id' => 9442202,
                'title' => 'H&M',
                'image' => 'hnm.webp',
                'status' => 1,
                'featured' => 1,
                'admin_id' => 1
            ],
            [
                'id' => 9442203,
                'title' => 'Rolex',
                'image' => 'rolex.webp',
                'status' => 1,
                'featured' => 1,
                'admin_id' => 1
            ],

            [
                'id' => 9442204,
                'title' => 'Apple',
                'image' => 'apple.webp',
                'status' => 1,
                'featured' => 1,
                'admin_id' => 1
            ],
            [
                'id' => 9442205,
                'title' => 'Gucci',
                'image' => 'gucci.webp',
                'status' => 1,
                'featured' => 1,
                'admin_id' => 1
            ],
            [
                'id' => 9442206,
                'title' => 'Schnell',
                'image' => 'schnell.webp',
                'status' => 1,
                'featured' => 1,
                'admin_id' => 1
            ],
            [
                'id' => 9442207,
                'title' => 'Zara',
                'image' => 'zara.webp',
                'status' => 1,
                'featured' => 1,
                'admin_id' => 1
            ],
            [
                'id' => 9442208,
                'title' => 'Nike',
                'image' => 'nike.webp',
                'status' => 1,
                'featured' => 1,
                'admin_id' => 1
            ],
            [
                'id' => 9442209,
                'title' => 'Gillette',
                'image' => 'gillette.webp',
                'status' => 1,
                'featured' => 1,
                'admin_id' => 1
            ],
            [
                'id' => 9442210,
                'title' => 'Accenture',
                'image' => 'accenture.webp',
                'status' => 1,
                'featured' => 1,
                'admin_id' => 1
            ],
            [
                'id' => 9442211,
                'title' => 'Nescafe',
                'image' => 'nescafe.webp',
                'status' => 1,
                'featured' => 1,
                'admin_id' => 1
            ],
            [
                'id' => 9442212,
                'title' => 'Loreal',
                'image' => 'loreal.webp',
                'status' => 1,
                'featured' => 1,
                'admin_id' => 1
            ]
        ];


        $admin1 = Admin::where('id', 1)->first();


        if (!Brand::first() && $admin1) {
            foreach ($items as $i) {
                Brand::create($i);
            }
        }


    }
}
