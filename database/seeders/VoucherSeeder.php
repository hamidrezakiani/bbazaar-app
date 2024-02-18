<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Voucher;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class VoucherSeeder extends Seeder
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
                'title' => 'Black friday offer',
                'type' => 1,
                'status' => 1,
                'usage_limit' => 100,
                'limit_per_customer' => 100,
                'price' => 10,
                'code' => 'BLACKFRIDAY10',
                'start_time' => Carbon::now()->subDays(15),
                'end_time' =>  Carbon::now()->addDays(15),
                'min_spend' => 100,
                'admin_id' => 1
            ],
            [
                'id' => 2,
                'title' => '15% off special Christmas offer',
                'type' => 2,
                'status' => 1,
                'usage_limit' => 100,
                'limit_per_customer' => 100,
                'price' => 15,
                'capped_price' => 150,
                'code' => 'CHRISTMASOFFER15',
                'start_time' => Carbon::now()->subDays(15),
                'end_time' =>  Carbon::now()->addDays(15),
                'min_spend' => 100,
                'admin_id' => 1
            ],
            [
                'id' => 3,
                'title' => 'First order offer',
                'type' => 1,
                'status' => 1,
                'usage_limit' => 100,
                'limit_per_customer' => 1,
                'price' => 15,
                'code' => 'FIRSTOFFER',
                'start_time' => Carbon::now()->subDays(15),
                'end_time' =>  Carbon::now()->addDays(15),
                'min_spend' => 100,
                'admin_id' => 1
            ],
        ];

        $admin1 = Admin::where('id', 1)->first();


        if(!Voucher::first() && $admin1){
            foreach ($items as $i) {
                Voucher::create($i);
            }
        }


    }
}
