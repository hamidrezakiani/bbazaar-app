<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderedProduct;
use App\Models\Product;
use App\Models\ShippingPlace;
use Illuminate\Database\Seeder;

class OrderedProductSeeder extends Seeder
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
                'product_id' => 88630158,
                'inventory_id' => 48,
                'quantity' => 1,
                'shipping_place_id' => 1,
                'shipping_type' => 1,
                'purchased' => 90,
                'selling' => 110,
                'tax_price' => 1.3,
                'shipping_price' => 10,
                'order_id' => 1
            ],
            [
                'id' => 2,
                'product_id' => 88630162,
                'inventory_id' => 52,
                'quantity' => 1,
                'shipping_place_id' => 1,
                'shipping_type' => 1,
                'purchased' => 90,
                'selling' => 100,
                'tax_price' => 1.3,
                'shipping_price' => 10,
                'commission' => 20,
                'commission_amount' => 20,
                'order_id' => 1
            ],
            [
                'id' => 3,
                'product_id' => 88630163,
                'inventory_id' => 53,
                'quantity' => 1,
                'shipping_place_id' => 1,
                'shipping_type' => 1,
                'purchased' => 90,
                'selling' => 100,
                'tax_price' => 1.3,
                'shipping_price' => 10,
                'commission' => 20,
                'commission_amount' => 20,
                'order_id' => 2
            ]
        ];


        $prod1 = Product::where('id' , 88630162)->first();
        $prod2 = Product::where('id' , 88630163)->first();
        $prod3 = Product::where('id' , 88630158)->first();


        $order1 = Order::where('id' , 1)->first();
        $order2 = Order::where('id' , 2)->first();

        $sp = ShippingPlace::where('id' , 1)->first();

        $inv1 = ShippingPlace::where('id' , 53)->first();
        $inv2 = ShippingPlace::where('id' , 52)->first();
        $inv3 = ShippingPlace::where('id' , 48)->first();



        $op = OrderedProduct::first();



        $valid = $prod1 && $prod2 && $prod3 && $order1 && $order2 && $sp && $inv1 && $inv2 && $inv3;


        if(!$op && $valid){
            foreach ($items as $i) {
                OrderedProduct::create($i);
            }
        }
    }
}
