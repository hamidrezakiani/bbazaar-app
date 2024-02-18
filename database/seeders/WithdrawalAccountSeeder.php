<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\WithdrawalAccount;
use Illuminate\Database\Seeder;

class WithdrawalAccountSeeder extends Seeder
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
                'account_number' => '1212334454',
                'account_name' => 'John Doe',
                'bank_name' => 'State Bank',
                'branch_name' => 'Quebec',
                'title' => 'Default',
                'default' => 1,
                'admin_id' => 2
            ]
        ];


        $admin2 = Admin::where('id', 2)->first();


        if(!WithdrawalAccount::first() && $admin2){
            foreach ($items as $i) {
                WithdrawalAccount::create($i);
            }
        }



    }
}
