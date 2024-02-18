<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Currency::create([
           'name' => 'Dollar',
           'code' => 'USD',
           'position' => 1,
           'symbol' => '$',
           'price' => 69.938328
        ]);
    }
}
