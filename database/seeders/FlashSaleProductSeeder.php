<?php

namespace Database\Seeders;

use App\Models\FlashSale;
use App\Models\FlashSaleProduct;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Config;

class FlashSaleProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $flashSale = FlashSale::first();
        $flashSaleProduct = FlashSaleProduct::first();

        if($flashSale && !$flashSaleProduct) {


            $products = Product::where('status', Config::get('constants.status.PUBLIC'))
                ->limit(18)
                ->select('id', 'selling', 'offered')
                ->get();


            foreach ($products as $i) {
                $flashProduct["admin_id"] = 1;
                $flashProduct["flash_sale_id"] = $flashSale->id;

                if($i->offered > 0) {
                    $price = $i->offered - 5;
                } else {
                    $price = $i->selling - 5;
                }

                $flashProduct["price"] = $price;
                $flashProduct["product_id"] = $i->id;


                FlashSaleProduct::create($flashProduct);
            }

        }


    }
}
