<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Language;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
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
                'name' => 'English',
                'code' => 'en',
                'default' => true,
                'predefined' => true,
                'status' => 1,
                'admin_id' => 1
            ],
            [
                'name' => 'Turkish',
                'code' => 'tr',
                'status' => 1,
                'predefined' => true,
                'admin_id' => 1
            ],
            [
                'name' => 'Hindi',
                'code' => 'hi',
                'status' => 1,
                'predefined' => true,
                'admin_id' => 1
            ],
            [
                'name' => 'Arabic',
                'code' => 'ar',
                'direction' => 'rtl',
                'status' => 1,
                'predefined' => true,
                'admin_id' => 1
            ],
            [
                'name' => 'French',
                'code' => 'fr',
                'status' => 1,
                'predefined' => true,
                'admin_id' => 1
            ],
        ];


        $admin1 = Admin::where('id', 1)->first();


        if(!Language::first() && $admin1){
            foreach ($items as $i) {
                Language::create($i);
            }
        }



    }
}
