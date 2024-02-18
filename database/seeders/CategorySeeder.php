<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Category;
use App\Models\Helper\Utils;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $metaTitle1 = " Products Online Shopping";
        $metaDescription1 = "Buy ";
        $metaDescription2 = " at the best sale prices today!";


        $items = [
            [
                'id' => 63082111,
                'title' => 'Women Apparel',
                'slug' => 'women-apparel',
                'meta_title' => 'Women Apparel' . $metaTitle1,
                'meta_description' => $metaDescription1 . 'Women Apparel' .$metaDescription2,
                'image' => 'category-women-apparel.webp',
                'status' => 1,
                'admin_id' => 1
            ],
            [
                'id' => 63082112,
                'title' => 'Beauty & Personal Care',
                'slug' => 'beauty-personal-care',
                'meta_title' => 'Beauty & Personal Care' . $metaTitle1,
                'meta_description' => $metaDescription1 . 'Beauty & Personal Care' .$metaDescription2,
                'image' => 'category-beauty.webp',
                'status' => 1,
                'admin_id' => 1
            ],
            [
                'id' => 72531155,
                'title' => "Women's Bags",
                'slug' => "womens-bags",
                'meta_title' => "Women's Bags" . $metaTitle1,
                'meta_description' => $metaDescription1 . "Women's Bags" .$metaDescription2,
                'image' => 'category-women-bags.webp',
                'status' => 1,
                'admin_id' => 1
            ],
            [
                'id' => 72531153,
                'title' => 'Jewellery & Accessories',

                'slug' => "jewellery-ccessories",
                'meta_title' => "Jewellery & Accessories" . $metaTitle1,
                'meta_description' => $metaDescription1 . "Jewellery & Accessories" .$metaDescription2,

                'image' => 'category-jewellery-accessories.webp',
                'status' => 1,
                'admin_id' => 1
            ],
            [
                'id' => 61952111,
                'title' => "Men's Wear",

                'slug' => "mens-wear",
                'meta_title' => "Men's Wear" . $metaTitle1,
                'meta_description' => $metaDescription1 . "Men's Wear" .$metaDescription2,


                'image' => 'category-men.webp',
                'status' => 1,
                'admin_id' => 1
            ],
            [
                'id' => 96522110,
                'title' => "Men's Bags",

                'slug' => "mens-bags",
                'meta_title' => "Men's Bags" . $metaTitle1,
                'meta_description' => $metaDescription1 . "Men's Bags" .$metaDescription2,

                'image' => 'category-men-bags.webp',
                'status' => 1,
                'admin_id' => 1
            ],
            [
                'id' => 72533143,
                'title' => 'Travel & Luggage',

                'slug' => "travel-luggage",
                'meta_title' => "Travel & Luggage" . $metaTitle1,
                'meta_description' => $metaDescription1 . "Travel & Luggage" .$metaDescription2,

                'image' => 'category-travel-luggage.webp',
                'status' => 1,
                'admin_id' => 1
            ],
            [
                'id' => 96674111,
                'title' => 'Toys, Kids & Babies',

                'slug' => "toys-kids-babies",
                'meta_title' => "Toys, Kids & Babies" . $metaTitle1,
                'meta_description' => $metaDescription1 . "Toys, Kids & Babies" .$metaDescription2,


                'image' => 'category-toys-kids-babies.webp',
                'status' => 1,
                'admin_id' => 1
            ],
            [
                'id' => 91202114,
                'title' => "Men's Shoes",

                'slug' => "mens-shoes",
                'meta_title' => "Men's Shoes" . $metaTitle1,
                'meta_description' => $metaDescription1 . "Men's Shoes" .$metaDescription2,

                'image' => 'category-men-shoes.webp',
                'status' => 1,
                'admin_id' => 1
            ],
            [
                'id' => 92522115,
                'title' => 'Home & Living',

                'slug' => "home-living",
                'meta_title' => "Home & Living" . $metaTitle1,
                'meta_description' => $metaDescription1 . "Home & Living" .$metaDescription2,

                'image' => 'category-home.webp',
                'status' => 1,
                'admin_id' => 1
            ],
            [
                'id' => 96874118,
                'title' => 'Food & Beverages',

                'slug' => "food-beverages",
                'meta_title' => "Food & Beverages" . $metaTitle1,
                'meta_description' => $metaDescription1 . "Food & Beverages" .$metaDescription2,

                'image' => 'category-food.webp',
                'status' => 1,
                'admin_id' => 1
            ],
            [
                'id' => 91233119,
                'title' => 'Home Appliances',

                'slug' => "home-appliances",
                'meta_title' => "Home Appliances" . $metaTitle1,
                'meta_description' => $metaDescription1 . "Home Appliances" .$metaDescription2,

                'image' => 'category-home-appliances.webp',
                'status' => 1,
                'admin_id' => 1
            ]
        ];



        $admin1 = Admin::where('id', 1)->first();


        if(!Category::first() && $admin1){
            foreach ($items as $i) {
                Category::create($i);
            }
        }
    }
}
