<?php

namespace Database\Seeders;

use App\Models\Payment;
use Illuminate\Database\Seeder;

class AddPaymentIyzicoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $payment = Payment::first();

        if($payment && !$payment->ip_base_url){

            Payment::where('id', $payment->id)->update([
                'iyzico_payment' => 1,
                'ip_api_key' => 'sandbox-QkCUIJZTMWlKIj7xkpgCuqGsKisGSWoT',
                'ip_secret_key' => 'sandbox-T4tiVhj18B24caQ6GWIYmFpkPBEr8Js7',
                'ip_base_url' => 'https://sandbox-api.iyzipay.com'
            ]);

        }
    }
}
