<?php

namespace Database\Seeders;

use App\Models\Payment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Config;

class PaymentSeeder extends Seeder
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
                'paypal' => 1,
                'paypal_key' => 'AVR2_ITELs7N2yfBG6CFcTFKCUFCiLQGn9ggrC6XgCOwCAAVPFjGXGUVu7UXHXH8eZ2ICwKuUB5M4CRt',
                'paypal_secret' => 'EJ0bHCYhFT5pr0vQlzcHNmuJx5FUZXlbRPozxDHn43Y10g6keGsTvjTtN3DNdI-BI3saAmq1hM7-vS6x',
                'cash_on_delivery' => 1,

                'razorpay_key' => 'rzp_test_vtdcqC3RtQu6Y3',
                'razorpay_secret' => 'BBFRuBHJiARuW5StLE80Z0jd',
                'stripe_key' => 'pk_test_51JRA6eFeoecS5e5Lm6m5mOCTOWxgtj5r0D19uHvgPRvwd0vayTx8bqKuaSJaJwVnwuhgahIQYP4M6Wfme9d9wpDG00VUVbACbg',
                'stripe_secret' => 'sk_test_51JRA6eFeoecS5e5LLuqYCPFttIi7YvZ65zrqoyp9VvmdoOemESn4UQreSjMgPa2dPX0RqCMknMbT9s3w1YPn3iGm00Eu0w3hFl',
                'admin_id' => 1,

                'razorpay' => 1,
                'stripe' => 1,
                'flutterwave' => 1,
                'fw_environment' => 'development',
                'fw_public_key' => 'FLWPUBK_TEST-7ceb4852c77efb1c4193180c82c5729d-X',
                'fw_secret_key' => 'FLWSECK_TEST-ff884473569b3c5aa37d8319f0af5398-X',
                'fw_encryption_key' => 'FLWSECK_TEST848e9dc518a2',
            ]
        ];

        if(!Payment::first()){
            foreach ($items as $i) {
                Payment::create($i);
            }
        }


    }
}
