<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Brand;
use App\Models\Category;
use App\Models\HomeSlider;
use App\Models\HomeSliderSourceBrand;
use App\Models\HomeSliderSourceCategory;
use App\Models\HomeSliderSourceSubCategory;
use App\Models\SubCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Config;

class HomeSliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $homeSliders = [
            [
                'id' => 1,
                'type' => Config::get('constants.homeSlider.MAIN'),
                'image' => 'slider-1.webp',
                'title' => 'Winter sale',
                'source_type' => Config::get('constants.sliderSourceType.CATEGORY'),
                'status' => Config::get('constants.status.PUBLIC'),
                'admin_id' => 1
            ],
            [
                'id' => 2,
                'type' => Config::get('constants.homeSlider.MAIN'),
                'image' => 'slider-2.webp',
                'title' => 'Flash 50 % off',
                'source_type' => Config::get('constants.sliderSourceType.CATEGORY'),
                'status' => Config::get('constants.status.PUBLIC'),
                'admin_id' => 1
            ],
            [
                'id' => 3,
                'type' => Config::get('constants.homeSlider.MAIN'),
                'image' => 'slider-3.webp',
                'title' => 'Black Friday Discount',
                'source_type' => Config::get('constants.sliderSourceType.CATEGORY'),
                'status' => Config::get('constants.status.PUBLIC'),
                'admin_id' => 1
            ],
            [
                'id' => 4,
                'type' => Config::get('constants.homeSlider.RIGHT_TOP'),
                'image' => 'slider-4.webp',
                'title' => 'Backpack for Men',
                'source_type' => Config::get('constants.sliderSourceType.SUB_CATEGORY'),
                'status' => Config::get('constants.status.PUBLIC'),
                'admin_id' => 1
            ],
            [
                'id' => 5,
                'type' => Config::get('constants.homeSlider.RIGHT_BOTTOM'),
                'image' => 'slider-5.webp',
                'title' => 'Puma Stylist Shoes',
                'source_type' => Config::get('constants.sliderSourceType.BRAND'),
                'status' => Config::get('constants.status.PUBLIC'),
                'admin_id' => 1
            ]
        ];


        $admin1 = Admin::where('id', 1)->first();



        if(!HomeSlider::first() && $admin1){
            foreach ($homeSliders as $i) {
                HomeSlider::create($i);
            }
        }



        $cat1 = Category::where('id', '63082111')->first();
        $cat2 = Category::where('id', '63082112')->first();
        $cat3 = Category::where('id', '72531153')->first();
        $cat4 = Category::where('id', '61952111')->first();

        $hs1 = HomeSlider::where('id', 1)->first();
        $hs2 = HomeSlider::where('id', 2)->first();
        $hs3 = HomeSlider::where('id', 3)->first();




        if($cat1 && $cat2 && $cat3 && $cat4 && $hs1 && $hs2 && $hs3){
            // Source seeders for main slider image
            $categorySource = [
                [
                    'category_id' => 63082111,
                    'home_slider_id' => 1
                ],
                [
                    'category_id' => 63082112,
                    'home_slider_id' => 1
                ],
                [
                    'category_id' => 72531153,
                    'home_slider_id' => 1
                ],
                [
                    'category_id' => 61952111,
                    'home_slider_id' => 2
                ],
                [
                    'category_id' => 72531153,
                    'home_slider_id' => 2
                ],
                [
                    'category_id' => 63082111,
                    'home_slider_id' => 3
                ],
                [
                    'category_id' => 61952111,
                    'home_slider_id' => 3
                ]
            ];



            if(!HomeSliderSourceCategory::first()){
                foreach ($categorySource as $i) {
                    HomeSliderSourceCategory::create($i);
                }
            }
        }



        $subCat1 = SubCategory::where('id', '97373117')->first();
        $subCat2 = SubCategory::where('id', '73294112')->first();
        $subCat3 = SubCategory::where('id', '96765129')->first();
        $subCat4 = SubCategory::where('id', '96765126')->first();


        $hs4 = HomeSlider::where('id', 4)->first();

        if($subCat1 && $subCat2 && $subCat3 && $subCat4 && $hs4){
            // Source seeders for slider image right top
            $subCategorySource = [
                [
                    'sub_category_id' => 97373117,
                    'home_slider_id' => 4
                ],
                [
                    'sub_category_id' => 73294112,
                    'home_slider_id' => 4
                ],
                [
                    'sub_category_id' => 96765129,
                    'home_slider_id' => 4
                ],
                [
                    'sub_category_id' => 96765126,
                    'home_slider_id' => 4
                ]
            ];



            if(!HomeSliderSourceSubCategory::first()){
                foreach ($subCategorySource as $i) {
                    HomeSliderSourceSubCategory::create($i);
                }
            }
        }


        $brand1 = Brand::where('id', '9442200')->first();
        $brand2 = Brand::where('id', '9442201')->first();
        $brand3 = Brand::where('id', '9442202')->first();
        $brand4 = Brand::where('id', '9442203')->first();


        $hs5 = HomeSlider::where('id', 5)->first();



        if($brand1 && $brand2 && $brand3 && $brand4 && $hs5){
            // Source seeders for slider image right top
            $bandSource = [
                [
                    'brand_id' => 9442200,
                    'home_slider_id' => 5
                ],
                [
                    'brand_id' => 9442201,
                    'home_slider_id' => 5
                ],
                [
                    'brand_id' => 9442202,
                    'home_slider_id' => 5
                ],
                [
                    'brand_id' => 9442203,
                    'home_slider_id' => 5
                ]
            ];




            if(!HomeSliderSourceBrand::first()){
                foreach ($bandSource as $i) {
                    HomeSliderSourceBrand::create($i);
                }
            }
        }




    }
}
