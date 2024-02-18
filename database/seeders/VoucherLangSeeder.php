<?php

namespace Database\Seeders;

use App\Models\Voucher;
use App\Models\VoucherLang;
use Illuminate\Database\Seeder;

class VoucherLangSeeder extends Seeder
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
                'voucher_id' => 1,
                'title' => 'kara cuma teklifi',
                'lang' => 'tr'
            ],
            [
                'voucher_id' => 2,
                'title' => "Noel'e özel %15 indirim fırsatı",
                'lang' => 'tr'
            ],
            [
                'voucher_id' => 3,
                'title' => 'İlk sipariş teklifi',
                'lang' => 'tr'
            ],



            [
                'voucher_id' => 1,
                'title' => 'Offre Black Friday',
                'lang' => 'fr'
            ],
            [
                'voucher_id' => 2,
                'title' => "15% de réduction sur l'offre spéciale Noël",
                'lang' => 'fr'
            ],
            [
                'voucher_id' => 3,
                'title' => "Offre de première commande",
                'lang' => 'fr'
            ],



            [
                'voucher_id' => 1,
                'title' => 'ब्लैक फ्राइडे ऑफर',
                'lang' => 'hi'
            ],
            [
                'voucher_id' => 2,
                'title' => 'विशेष क्रिसमस ऑफर पर 15% की छूट',
                'lang' => 'hi'
            ],
            [
                'voucher_id' => 3,
                'title' => 'पहला ऑर्डर ऑफर',
                'lang' => 'hi'
            ],


            [
                'voucher_id' => 1,
                'title' => 'عرض الجمعة السوداء',
                'lang' => 'ar'
            ],
            [
                'voucher_id' => 2,
                'title' => 'خصم 15٪ على عرض الكريسماس الخاص',
                'lang' => 'ar'
            ],
            [
                'voucher_id' => 3,
                'title' => 'عرض من الدرجة الأولى',
                'lang' => 'ar'
            ],
        ];


        $voucher1 = Voucher::where('id', 1)->first();
        $voucher2 = Voucher::where('id', 2)->first();
        $voucher3 = Voucher::where('id', 3)->first();


        if(!VoucherLang::first() && $voucher1 && $voucher2 && $voucher3){
            foreach ($items as $i) {
                VoucherLang::create($i);
            }
        }
    }
}
