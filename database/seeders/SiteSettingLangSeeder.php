<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use App\Models\SiteSettingLang;
use Illuminate\Database\Seeder;

class SiteSettingLangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $metaTitleTr = "Erkekler, Elektronik, Giyim, Bilgisayar, Kitap, DVD ve daha fazlası için Online Alışveriş";
        $metaDescriptionTr = "ABD'nin bebek ve çocuk temel malzemeleri, oyuncakları, moda ve elektronik ürünleri ve daha fazlası için 1 numaralı alışveriş platformu! En Düşük Fiyat Garantisi | Geri Ödeme Fırsatları";

        $metaTitleFr = "Achats en ligne pour hommes, électronique, vêtements, ordinateurs, livres, DVD et plus";
        $metaDescriptionFr = "La plate-forme d'achat n°1 aux États-Unis pour les articles essentiels pour bébés et enfants, les jouets, la mode et les articles électroniques, et plus encore! Prix le plus bas garanti | Offres de remboursement";

        $metaTitleAr = "التسوق عبر الإنترنت للرجال والإلكترونيات والملابس وأجهزة الكمبيوتر والكتب وأقراص DVD والمزيد";
        $metaDescriptionAr = "منصة التسوق رقم 1 في الولايات المتحدة الأمريكية لمستلزمات الأطفال والرضع والألعاب والأزياء والأدوات الإلكترونية والمزيد! أقل سعر مضمون | صفقات استرداد النقود";

        $metaTitleHi = "पुरुषों, इलेक्ट्रॉनिक्स, परिधान, कंप्यूटर, किताबें, डीवीडी और बहुत कुछ के लिए ऑनलाइन खरीदारी";
        $metaDescriptionHi = "बच्चे और बच्चों के आवश्यक सामान, खिलौने, फैशन और इलेक्ट्रॉनिक आइटम, और बहुत कुछ के लिए यूएसए का #1 शॉपिंग प्लेटफॉर्म! सबसे कम कीमत की गारंटी | कैशबैक सौदे";



        $items = [
            [
                'site_setting_id' => 1,
                'site_name' => "Ishop",
                'meta_title' => $metaTitleTr,
                'meta_description' => $metaDescriptionTr,
                'copyright_text' => 'Tüm hakları saklıdır Ishop',
                'lang' => 'tr'
            ],


            [
                'site_setting_id' => 1,
                'site_name' => "Ishop",
                'meta_title' => $metaTitleFr,
                'meta_description' => $metaDescriptionFr,
                'copyright_text' => 'Tous droits réservés par Ishop',
                'lang' => 'fr'
            ],


            [
                'site_setting_id' => 1,
                'site_name' => "Ishop",
                'meta_title' => $metaTitleAr,
                'meta_description' => $metaDescriptionAr,
                'copyright_text' => 'Ishop جميع الحقوق محفوظة',
                'lang' => 'ar'
            ],


            [
                'site_setting_id' => 1,
                'site_name' => "Ishop",
                'meta_title' => $metaTitleHi,
                'meta_description' => $metaDescriptionHi,
                'copyright_text' => 'द्वारा सर्वाधिकार सुरक्षित Ishop',
                'lang' => 'hi'
            ]


        ];


        $ss = SiteSetting::where('id', 1)->first();


        if(!SiteSettingLang::first() && $ss){
            foreach ($items as $i) {
                SiteSettingLang::create($i);
            }
        }
    }
}
