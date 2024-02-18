<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\FlashSale;
use Illuminate\Database\Seeder;

class FlashSaleSeeder extends Seeder
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
                'title' => 'New Year Sale',
                'status' => 1,
                'start_time' => '2022-02-01 03:32:00',
                'end_time' => '2024-03-21 03:32:00',
                'admin_id' => 1
            ]
        ];


        $admin1 = Admin::where('id', 1)->first();


        if(!FlashSale::first() && $admin1){
            foreach ($items as $i) {
                FlashSale::create($i);
            }
        }
    }
}
