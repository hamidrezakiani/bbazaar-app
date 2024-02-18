<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\FooterImageLink;
use Illuminate\Database\Seeder;

class FooterImageLinkSeeder extends Seeder
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
                'title' => 'Paypal',
                'link' => 'https://www.paypal.com',
                'image' => 'paypal.png',
                'type' => 1,
                'status' => 1,
                'admin_id' => 1
            ],
            [
                'title' => 'MasterCard',
                'image' => 'master-card.png',
                'link' => 'https://mastercard.com',
                'type' => 1,
                'status' => 1,
                'admin_id' => 1
            ],
            [
                'title' => 'VisaCard',
                'image' => 'visa-card.png',
                'link' => 'https://visa.com',
                'type' => 1,
                'status' => 1,
                'admin_id' => 1
            ],
            [
                'title' => 'AmericanExpress',
                'image' => 'american-express.png',
                'link' => 'https://americanexpress.com',
                'type' => 1,
                'status' => 1,
                'admin_id' => 1
            ],
            [
                'title' => 'Discover',
                'image' => 'discover.png',
                'link' => 'https://discover.com',
                'type' => 1,
                'status' => 1,
                'admin_id' => 1
            ],
            [
                'title' => 'Instagram',
                'image' => 'instagram.png',
                'link' => 'https://instagram.com',
                'type' => 2,
                'status' => 1,
                'admin_id' => 1
            ],
            [
                'title' => 'Facebook',
                'image' => 'facebook.png',
                'link' => 'https://facebook.com',
                'type' => 2,
                'status' => 1,
                'admin_id' => 1
            ],
            [
                'title' => 'Twitter',
                'image' => 'twitter.png',
                'link' => 'https://twitter.com',
                'type' => 2,
                'status' => 1,
                'admin_id' => 1
            ],
            [
                'title' => 'Linkedin',
                'image' => 'linkedin.png',
                'link' => 'https://linkedin.com',
                'type' => 2,
                'status' => 1,
                'admin_id' => 1
            ]
        ];

        $admin1 = Admin::where('id', 1)->first();

        if(!FooterImageLink::first() && $admin1){
            foreach ($items as $i) {
                FooterImageLink::create($i);
            }
        }

    }
}
