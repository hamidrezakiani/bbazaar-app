<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Withdrawal;
use App\Models\WithdrawalAccount;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Config;

class WithdrawalSeeder extends Seeder
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
                'amount' => '10',
                'withdrawal_account_id' => 1,
                'status' => Config::get('constants.status.PRIVATE'),
                'admin_id' => 2,
                'approved_by' => 1
            ],
            [
                'amount' => '10',
                'withdrawal_account_id' => 1,
                'status' => Config::get('constants.status.PUBLIC'),
                'admin_id' => 2,
                'approved_by' => 1
            ]
        ];


        $admin1 = Admin::where('id', 1)->first();
        $admin2 = Admin::where('id', 2)->first();

        $wa = WithdrawalAccount::where('id', 1)->first();

        if(!Withdrawal::first() && $admin1 && $admin2 && $wa){
            foreach ($items as $i) {
                Withdrawal::create($i);
            }
        }




    }
}
