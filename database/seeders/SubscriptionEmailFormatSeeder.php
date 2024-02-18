<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\SubscriptionEmailFormat;
use Illuminate\Database\Seeder;

class SubscriptionEmailFormatSeeder extends Seeder
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
                'admin_id' => 1,
                'title' => 'Flash week',
                'subject' => 'Best deals for you',
                'body' => '<div style="padding: 30px 0;"><h4>Free shipping for you</h4>
                        <h1 style="margin: 20px 0;"><b>GET YOUR SHIPPING FREE PRODUCTS</b></h1>
                        <p style="padding: 0 0 30px;">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. </p>

                        <a style="background: #4380F3; padding: 15px 30px; color:#ffffff; text-decoration:none;" href="https://ishop.cholobangla.com/all-products/products" target="_blank">CLAIM SHIPPING FREE PRODUCTS</a>
                        </div>'
            ]
        ];



        $admin1 = Admin::where('id', 1)->first();

        if(!SubscriptionEmailFormat::first() && $admin1){
            foreach ($items as $i) {
                SubscriptionEmailFormat::create($i);
            }
        }



    }
}
