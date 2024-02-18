<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Banner;
use App\Models\BannerSourceBrand;
use App\Models\Brand;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Config;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $banners = [
            [
                'id' => 1,
                'type' => Config::get('constants.banner.BANNER_1'),
                'image' => 'banner-1.webp',
                'title' => 'Sale',
                'source_type' => Config::get('constants.sliderSourceType.BRAND'),
                'status' => Config::get('constants.status.PUBLIC'),
                'closable' => Config::get('constants.status.PRIVATE'),
                'admin_id' => 1
            ],
            [
                'id' => 2,
                'type' => Config::get('constants.banner.BANNER_2'),
                'image' => 'banner-2.webp',
                'title' => 'Voucher',
                'url' => '/homesick-new-home-reed-diffuser/product/88630161',
                'source_type' => Config::get('constants.sliderSourceType.URL'),
                'status' => Config::get('constants.status.PUBLIC'),
                'closable' => Config::get('constants.status.PRIVATE'),
                'admin_id' => 1
            ],
            [
                'id' => 3,
                'type' => Config::get('constants.banner.BANNER_3'),
                'image' => 'banner-3.webp',
                'title' => 'Discount',
                'source_type' => Config::get('constants.sliderSourceType.BRAND'),
                'status' => Config::get('constants.status.PUBLIC'),
                'closable' => Config::get('constants.status.PRIVATE'),
                'admin_id' => 1
            ],
            [
                'id' => 4,
                'type' => Config::get('constants.banner.BANNER_4'),
                'image' => 'banner-4.webp',
                'title' => 'Black friday',
                'source_type' => Config::get('constants.sliderSourceType.BRAND'),
                'status' => Config::get('constants.status.PUBLIC'),
                'closable' => Config::get('constants.status.PRIVATE'),
                'admin_id' => 1
            ],
            [
                'id' => 5,
                'type' => Config::get('constants.banner.BANNER_5'),
                'image' => 'banner-5.webp',
                'title' => 'Summer fashion',
                'source_type' => Config::get('constants.sliderSourceType.BRAND'),
                'status' => Config::get('constants.status.PUBLIC'),
                'closable' => Config::get('constants.status.PRIVATE'),
                'admin_id' => 1
            ],
            [
                'id' => 6,
                'type' => Config::get('constants.banner.BANNER_6'),
                'image' => 'banner-6.webp',
                'title' => 'Autumn Offer',
                'source_type' => Config::get('constants.sliderSourceType.BRAND'),
                'status' => Config::get('constants.status.PUBLIC'),
                'closable' => Config::get('constants.status.PRIVATE'),
                'admin_id' => 1
            ],
            [
                'id' => 7,
                'type' => Config::get('constants.banner.BANNER_7'),
                'image' => 'banner-7.webp',
                'title' => 'Christmas Offer',
                'source_type' => Config::get('constants.sliderSourceType.BRAND'),
                'status' => Config::get('constants.status.PUBLIC'),
                'closable' => Config::get('constants.status.PRIVATE'),
                'admin_id' => 1
            ],
            [
                'id' => 8,
                'type' => Config::get('constants.banner.BANNER_8'),
                'image' => 'banner-8.webp',
                'title' => '45% Off',
                'source_type' => Config::get('constants.sliderSourceType.BRAND'),
                'status' => Config::get('constants.status.PUBLIC'),
                'closable' => Config::get('constants.status.PUBLIC'),
                'admin_id' => 1
            ],
            [
                'id' => 9,
                'type' => Config::get('constants.banner.BANNER_9'),
                'image' => 'banner-9.png',
                'title' => 'Free shipping',
                'source_type' => Config::get('constants.sliderSourceType.BRAND'),
                'status' => Config::get('constants.status.PUBLIC'),
                'closable' => Config::get('constants.status.PUBLIC'),
                'admin_id' => 1
            ]
        ];

        $admin1 = Admin::where('id', 1)->first();

        if(!Banner::first() && $admin1){
            foreach ($banners as $i) {
                Banner::create($i);
            }
        }




        $brand1 = Brand::where('id', '9442200')->first();
        $brand2 = Brand::where('id', '9442201')->first();
        $brand3 = Brand::where('id', '9442202')->first();
        $brand4 = Brand::where('id', '9442203')->first();


        if($brand1 && $brand2 && $brand3 && $brand4){

            // Source seeders for slider image right top
            $bandSource = [
                [
                    'brand_id' => 9442200,
                    'banner_id' => 1
                ],
                [
                    'brand_id' => 9442201,
                    'banner_id' => 1
                ],
                [
                    'brand_id' => 9442202,
                    'banner_id' => 1
                ],
                [
                    'brand_id' => 9442203,
                    'banner_id' => 1
                ]
            ];

            if(!BannerSourceBrand::first()){
                foreach ($bandSource as $i) {
                    BannerSourceBrand::create($i);
                }
            }

        }





    }
}
