<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Category;
use App\Models\Helper\Utils;
use App\Models\SubCategory;
use App\Models\SubCategoryLang;
use Illuminate\Database\Seeder;

class SubCategorySeeder extends Seeder
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
                "id" => 64273111,
                "title" => "Tops",
                "status" => 1,
                "image" => "sub-cat-tops.webp",
                "featured" => 1,
                "admin_id" => 1,
                "category_id" => 63082111,
                "slug" => "tops",
                "meta_title" => "Tops" . $metaTitle1,
                "meta_description" => $metaDescription1 . "Tops" . $metaDescription2
            ],
            [
                "id" => 73294112,
                "title" => "Dresses",
                "status" => 1,
                "image" => "sub-cat-dresses.webp",
                "featured" => 1,
                "admin_id" => 1,
                "category_id" => 63082111,
                "slug" => "dresses",
                "meta_title" => "Dresses" . $metaTitle1,
                "meta_description" => $metaDescription1 . "Dresses" . $metaDescription2
            ],
            [
                "id" => 96323113,
                "title" => "Socks & Tights",
                "status" => 1,
                "image" => "sub-cat-socks-tights.webp",
                "featured" => 1,
                "admin_id" => 1,
                "category_id" => 63082111,
                "slug" => "socks--tights",
                "meta_title" => "Socks & Tights" . $metaTitle1,
                "meta_description" => $metaDescription1 . "Socks & Tights" . $metaDescription2
            ],
            [
                "id" => 96765114,
                "title" => "Pants & Leggings",
                "status" => 1,
                "image" => "sub-cat-pants-leggings.webp",
                "featured" => 1,
                "admin_id" => 1,
                "category_id" => 63082111,
                "slug" => "pants--leggings",
                "meta_title" => "Pants & Leggings" . $metaTitle1,
                "meta_description" => $metaDescription1 . "Pants & Leggings" . $metaDescription2
            ],

            [
                "id" => 97373115,
                "title" => "Women's Hair Care",
                "status" => 1,
                "image" => "sub-cat-women-hair-care.webp",
                "featured" => 1,
                "admin_id" => 1,
                "category_id" => 63082112,
                "slug" => "womens-hair-care",
                "meta_title" => "Women's Hair Care" . $metaTitle1,
                "meta_description" => $metaDescription1 . "Women's Hair Care" . $metaDescription2
            ],
            [
                "id" => 97373116,
                "title" => "Feminine Care",
                "status" => 1,
                "image" => "sub-cat-feminine-care.webp",
                "featured" => 1,
                "admin_id" => 1,
                "category_id" => 63082112,
                "slug" => "feminine-care",
                "meta_title" => "Feminine Care" . $metaTitle1,
                "meta_description" => $metaDescription1 . "Feminine Care" . $metaDescription2
            ],

            [
                "id" => 97373117,
                "title" => "Skincare",
                "status" => 1,
                "image" => "sub-cat-skincare.webp",
                "featured" => 1,
                "admin_id" => 1,
                "category_id" => 63082112,
                "slug" => "skincare",
                "meta_title" => "Skincare" . $metaTitle1,
                "meta_description" => $metaDescription1 . "Skincare" . $metaDescription2
            ],

            [
                "id" => 73294118,
                "title" => "Sling Bags",
                "status" => 1,
                "image" => "sub-cat-sling-bags.webp",
                "featured" => 1,
                "admin_id" => 1,
                "category_id" => 72531155,
                "slug" => "sling-bags",
                "meta_title" => "Sling Bags" . $metaTitle1,
                "meta_description" => $metaDescription1 . "Sling Bags" . $metaDescription2
            ],
            [
                "id" => 96323119,
                "title" => "Clutches & Mini Bags",
                "status" => 1,
                "image" => "sub-cat-clutches-mini-bags.webp",
                "featured" => 1,
                "admin_id" => 1,
                "category_id" => 72531155,
                "slug" => "clutches--mini-bags",
                "meta_title" => "Clutches & Mini Bags" . $metaTitle1,
                "meta_description" => $metaDescription1 . "Clutches & Mini Bags" . $metaDescription2
            ],
            [
                "id" => 96765110,
                "title" => "Handbags",
                "status" => 1,
                "image" => "sub-cat-handbags.webp",
                "featured" => 1,
                "admin_id" => 1,
                "category_id" => 72531155,
                "slug" => "handbags",
                "meta_title" => "Handbags" . $metaTitle1,
                "meta_description" => $metaDescription1 . "Handbags" . $metaDescription2
            ],
            [
                "id" => 97373121,
                "title" => "Key Chains",
                "status" => 1,
                "image" => "sub-cat-key-chains.webp",
                "featured" => 1,
                "admin_id" => 1,
                "category_id" => 72531153,
                "slug" => "key-chains",
                "meta_title" => "Key Chains" . $metaTitle1,
                "meta_description" => $metaDescription1 . "Key Chains" . $metaDescription2
            ],
            [
                "id" => 99585122,
                "title" => "Eyewear",
                "status" => 1,
                "image" => "sub-cat-eyewear.webp",
                "featured" => 1,
                "admin_id" => 1,
                "category_id" => 72531153,
                "slug" => "eyewear",
                "meta_title" => "Eyewear" . $metaTitle1,
                "meta_description" => $metaDescription1 . "Eyewear" . $metaDescription2
            ],
            [
                "id" => 96765123,
                "title" => "Hats & Caps",
                "status" => 1,
                "image" => "sub-cat-hats-caps.webp",
                "featured" => 1,
                "admin_id" => 1,
                "category_id" => 72531153,
                "slug" => "hats--caps",
                "meta_title" => "Hats & Caps" . $metaTitle1,
                "meta_description" => $metaDescription1 . "Hats & Caps" . $metaDescription2
            ],
            [
                "id" => 97373124,
                "title" => "Shirts",
                "status" => 1,
                "image" => "sub-cat-shirts.webp",
                "featured" => 1,
                "admin_id" => 1,
                "category_id" => 61952111,
                "slug" => "shirts",
                "meta_title" => "Shirts" . $metaTitle1,
                "meta_description" => $metaDescription1 . "Shirts" . $metaDescription2
            ],
            [
                "id" => 99585125,
                "title" => "Jackets & Coats",
                "status" => 1,
                "image" => "sub-cat-jackets-coats.webp",
                "featured" => 1,
                "admin_id" => 1,
                "category_id" => 61952111,
                "slug" => "jackets--coats",
                "meta_title" => "Jackets & Coats" . $metaTitle1,
                "meta_description" => $metaDescription1 . "Jackets & Coats" . $metaDescription2
            ],
            [
                "id" => 96765126,
                "title" => "Pants",
                "status" => 1,
                "image" => "sub-cat-pants.webp",
                "featured" => 1,
                "admin_id" => 1,
                "category_id" => 61952111,
                "slug" => "pants",
                "meta_title" => "Pants" . $metaTitle1,
                "meta_description" => $metaDescription1 . "Pants" . $metaDescription2
            ],
            [
                "id" => 99585127,
                "title" => "Men's Wallet",
                "status" => 1,
                "image" => "sub-cat-men-wallet.webp",
                "featured" => 1,
                "admin_id" => 1,
                "category_id" => 61952111,
                "slug" => "mens-wallet",
                "meta_title" => "Men's Wallet" . $metaTitle1,
                "meta_description" => $metaDescription1 . "Men's Wallet" . $metaDescription2
            ],
            [
                "id" => 99585128,
                "title" => "Backpacks",
                "status" => 1,
                "image" => "sub-cat-backpacks.webp",
                "featured" => 1,
                "admin_id" => 1,
                "category_id" => 61952111,
                "slug" => "backpacks",
                "meta_title" => "Backpacks" . $metaTitle1,
                "meta_description" => $metaDescription1 . "Backpacks" . $metaDescription2
            ],
            [
                "id" => 96765129,
                "title" => "Crossbody & Shoulder Bags",
                "status" => 1,
                "image" => "sub-cat-crossbody-shoulder-bags.webp",
                "featured" => 1,
                "admin_id" => 1,
                "category_id" => 61952111,
                "slug" => "crossbody--shoulder-bags",
                "meta_title" => "Crossbody & Shoulder Bags" . $metaTitle1,
                "meta_description" => $metaDescription1 . "Crossbody & Shoulder Bags" . $metaDescription2
            ],
            [
                "id" => 99585130,
                "title" => "Briefcases",
                "status" => 1,
                "image" => "sub-cat-briefcases.webp",
                "featured" => 1,
                "admin_id" => 1,
                "category_id" => 96522110,
                "slug" => "briefcases",
                "meta_title" => "Briefcases" . $metaTitle1,
                "meta_description" => $metaDescription1 . "Briefcases" . $metaDescription2
            ],
            [
                "id" => 99585131,
                "title" => "Suit Carriers",
                "status" => 1,
                "image" => "sub-cat-suit-carriers.webp",
                "featured" => 1,
                "admin_id" => 1,
                "category_id" => 96522110,
                "slug" => "suit-carriers",
                "meta_title" => "Suit Carriers" . $metaTitle1,
                "meta_description" => $metaDescription1 . "Suit Carriers" . $metaDescription2
            ],
            [
                "id" => 96765132,
                "title" => "Totes",
                "status" => 1,
                "image" => "sub-cat-totes.webp",
                "featured" => 1,
                "admin_id" => 1,
                "category_id" => 96522110,
                "slug" => "totes",
                "meta_title" => "Totes" . $metaTitle1,
                "meta_description" => $metaDescription1 . "Totes" . $metaDescription2
            ],
            [
                "id" => 99585133,
                "title" => "Travel Bags & Backpacks",
                "status" => 1,
                "image" => "sub-cat-travel-bags-backpacks.webp",
                "featured" => 1,
                "admin_id" => 1,
                "category_id" => 72533143,
                "slug" => "travel-bags--backpacks",
                "meta_title" => "Travel Bags & Backpacks" . $metaTitle1,
                "meta_description" => $metaDescription1 . "Travel Bags & Backpacks" . $metaDescription2
            ],
            [
                "id" => 99585134,
                "title" => "Travel Accessories",
                "status" => 1,
                "image" => "sub-cat-travel-accessories.webp",
                "featured" => 1,
                "admin_id" => 1,
                "category_id" => 72533143,
                "slug" => "travel-accessories",
                "meta_title" => "Travel Accessories" . $metaTitle1,
                "meta_description" => $metaDescription1 . "Travel Accessories" . $metaDescription2
            ],
            [
                "id" => 96765135,
                "title" => "Luggage",
                "status" => 1,
                "image" => "sub-cat-luggage.webp",
                "featured" => 1,
                "admin_id" => 1,
                "category_id" => 72533143,
                "slug" => "luggage",
                "meta_title" => "Luggage" . $metaTitle1,
                "meta_description" => $metaDescription1 . "Luggage" . $metaDescription2
            ],
            [
                "id" => 99585136,
                "title" => "Maternity Care",
                "status" => 1,
                "image" => "sub-cat-maternity-care.webp",
                "featured" => 1,
                "admin_id" => 1,
                "category_id" => 96674111,
                "slug" => "maternity-care",
                "meta_title" => "Maternity Care" . $metaTitle1,
                "meta_description" => $metaDescription1 . "Maternity Care" . $metaDescription2
            ],
            [
                "id" => 99585137,
                "title" => "Kid's Furniture",
                "status" => 1,
                "image" => "sub-cat-kid-furniture.webp",
                "featured" => 1,
                "admin_id" => 1,
                "category_id" => 96674111,
                "slug" => "kids-furniture",
                "meta_title" => "Kid's Furniture" . $metaTitle1,
                "meta_description" => $metaDescription1 . "Kid's Furniture" . $metaDescription2
            ],
            [
                "id" => 96765138,
                "title" => "Bath & Baby Care",
                "status" => 1,
                "image" => "sub-cat-bath-baby-care.webp",
                "featured" => 1,
                "admin_id" => 1,
                "category_id" => 96674111,
                "slug" => "bath--baby-care",
                "meta_title" => "Bath & Baby Care" . $metaTitle1,
                "meta_description" => $metaDescription1 . "Bath & Baby Care" . $metaDescription2
            ],
            [
                "id" => 99585139,
                "title" => "Sandals & Flip-Flops",
                "status" => 1,
                "image" => "sub-cat-sandals-flip-flops.webp",
                "featured" => 1,
                "admin_id" => 1,
                "category_id" => 91202114,
                "slug" => "sandals--flip-flops",
                "meta_title" => "Sandals & Flip-Flops" . $metaTitle1,
                "meta_description" => $metaDescription1 . "Sandals & Flip-Flops" . $metaDescription2
            ],
            [
                "id" => 99585140,
                "title" => "Sneakers",
                "status" => 1,
                "image" => "sub-cat-sneakers.webp",
                "featured" => 1,
                "admin_id" => 1,
                "category_id" => 91202114,
                "slug" => "sneakers",
                "meta_title" => "Sneakers" . $metaTitle1,
                "meta_description" => $metaDescription1 . "Sneakers" . $metaDescription2
            ],
            [
                "id" => 96765141,
                "title" => "Formal Shoes",
                "status" => 1,
                "image" => "sub-cat-formal-shoes.webp",
                "featured" => 1,
                "admin_id" => 1,
                "category_id" => 91202114,
                "slug" => "formal-shoes",
                "meta_title" => "Formal Shoes" . $metaTitle1,
                "meta_description" => $metaDescription1 . "Formal Shoes" . $metaDescription2
            ],
            [
                "id" => 99585142,
                "title" => "Tools, DIY & Outdoors",
                "status" => 1,
                "image" => "sub-cat-tools-diy-outdoors.webp",
                "featured" => 1,
                "admin_id" => 1,
                "category_id" => 92522115,
                "slug" => "tools-diy--outdoors",
                "meta_title" => "Tools, DIY & Outdoors" . $metaTitle1,
                "meta_description" => $metaDescription1 . "Tools, DIY & Outdoors" . $metaDescription2
            ],
            [
                "id" => 99585143,
                "title" => "Kitchen & Dining",
                "status" => 1,
                "image" => "sub-cat-kitchen-dining.webp",
                "featured" => 1,
                "admin_id" => 1,
                "category_id" => 92522115,
                "slug" => "kitchen--dining",
                "meta_title" => "Kitchen & Dining" . $metaTitle1,
                "meta_description" => $metaDescription1 . "Kitchen & Dining" . $metaDescription2
            ],
            [
                "id" => 96765144,
                "title" => "Home Decor",
                "status" => 1,
                "image" => "sub-cat-home-decor.webp",
                "featured" => 1,
                "admin_id" => 1,
                "category_id" => 92522115,
                "slug" => "home-decor",
                "meta_title" => "Home Decor" . $metaTitle1,
                "meta_description" => $metaDescription1 . "Home Decor" . $metaDescription2
            ],
            [
                "id" => 99585145,
                "title" => "Meat & Seafood",
                "status" => 1,
                "image" => "sub-cat-meat-Seafood.webp",
                "featured" => 1,
                "admin_id" => 1,
                "category_id" => 96874118,
                "slug" => "meat--seafood",
                "meta_title" => "Meat & Seafood" . $metaTitle1,
                "meta_description" => $metaDescription1 . "Meat & Seafood" . $metaDescription2
            ],
            [
                "id" => 96765147,
                "title" => "Snacks & Sweets",
                "status" => 1,
                "image" => "sub-cat-snacks-sweets.webp",
                "featured" => 1,
                "admin_id" => 1,
                "category_id" => 96874118,
                "slug" => "snacks--sweets",
                "meta_title" => "Snacks & Sweets" . $metaTitle1,
                "meta_description" => $metaDescription1 . "Snacks & Sweets" . $metaDescription2
            ],
            [
                "id" => 99585148,
                "title" => "TV Accessories",
                "status" => 1,
                "image" => "sub-cat-tv-accessories.webp",
                "featured" => 1,
                "admin_id" => 1,
                "category_id" => 91233119,
                "slug" => "tv-accessories",
                "meta_title" => "TV Accessories" . $metaTitle1,
                "meta_description" => $metaDescription1 . "TV Accessories" . $metaDescription2
            ],
            [
                "id" => 99585149,
                "title" => "Small Kitchen Appliances",
                "status" => 1,
                "image" => "sub-cat-small-kitchen-appliances.webp",
                "featured" => 1,
                "admin_id" => 1,
                "category_id" => 91233119,
                "slug" => "small-kitchen-appliances",
                "meta_title" => "Small Kitchen Appliances" . $metaTitle1,
                "meta_description" => $metaDescription1 . "Small Kitchen Appliances" . $metaDescription2
            ],
            [
                "id" => 96765150,
                "title" => "Housekeeping",
                "status" => 1,
                "image" => "sub-cat-housekeeping.webp",
                "featured" => 1,
                "admin_id" => 1,
                "category_id" => 91233119,
                "slug" => "housekeeping",
                "meta_title" => "Housekeeping" . $metaTitle1,
                "meta_description" => $metaDescription1 . "Housekeeping" . $metaDescription2
            ],


        ];


        $cat1 = Category::where('id', '96522110')->first();
        $cat2 = Category::where('id', '96874118')->first();
        $cat3 = Category::where('id', '91233119')->first();
        $cat4 = Category::where('id', '63082112')->first();

        $admin1 = Admin::where('id', 1)->first();

        $valid = $cat1 && $cat2 && $cat3 && $cat4 && $admin1;


        if(!SubCategory::first() && $valid){
            foreach ($items as $i) {
                SubCategory::create($i);
            }
        }


    }
}
