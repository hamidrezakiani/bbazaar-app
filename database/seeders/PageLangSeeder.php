<?php

namespace Database\Seeders;

use App\Models\Page;
use App\Models\PageLang;
use Illuminate\Database\Seeder;

class PageLangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faqAr = file_get_contents(base_path() . "/database/seeders/pageData/faq_ar.ini");
        $aboutAr = file_get_contents(base_path() . "/database/seeders/pageData/about_ar.ini");
        $refundPolicyAr = file_get_contents(base_path() . "/database/seeders/pageData/refundPolicy_ar.ini");
        $privacyPolicyAr = file_get_contents(base_path() . "/database/seeders/pageData/privacyPolicy_ar.ini");
        $helpAr = file_get_contents(base_path() . "/database/seeders/pageData/help_ar.ini");



        $faqFr = file_get_contents(base_path() . "/database/seeders/pageData/faq_fr.ini");
        $aboutFr = file_get_contents(base_path() . "/database/seeders/pageData/about_fr.ini");
        $refundPolicyFr = file_get_contents(base_path() . "/database/seeders/pageData/refundPolicy_fr.ini");
        $privacyPolicyFr = file_get_contents(base_path() . "/database/seeders/pageData/privacyPolicy_fr.ini");
        $helpFr = file_get_contents(base_path() . "/database/seeders/pageData/help_fr.ini");


        $faqHi = file_get_contents(base_path() . "/database/seeders/pageData/faq_hi.ini");
        $aboutHi = file_get_contents(base_path() . "/database/seeders/pageData/about_hi.ini");
        $refundPolicyHi = file_get_contents(base_path() . "/database/seeders/pageData/refundPolicy_hi.ini");
        $privacyPolicyHi = file_get_contents(base_path() . "/database/seeders/pageData/privacyPolicy_hi.ini");
        $helpHi = file_get_contents(base_path() . "/database/seeders/pageData/help_hi.ini");


        $faqTr = file_get_contents(base_path() . "/database/seeders/pageData/faq_tr.ini");
        $aboutTr = file_get_contents(base_path() . "/database/seeders/pageData/about_tr.ini");
        $refundPolicyTr = file_get_contents(base_path() . "/database/seeders/pageData/refundPolicy_tr.ini");
        $privacyPolicyTr = file_get_contents(base_path() . "/database/seeders/pageData/privacyPolicy_tr.ini");
        $helpTr = file_get_contents(base_path() . "/database/seeders/pageData/help_tr.ini");

        $items = [
            [
                'page_id' => 1,
                'title' => 'عن',
                'description' => $aboutAr,
                'meta_title' => 'Ishop - عن',
                'meta_description' => 'عن',
                'lang' => 'ar'
            ],
            [
                'page_id' => 2,
                'title' => 'التعليمات',
                'description' => $faqAr,
                'meta_title' => 'Ishop - التعليمات',
                'meta_description' => 'التعليمات',
                'lang' => 'ar'
            ],
            [
                'page_id' => 3,
                'title' => 'اتصال',
                'description' => 'Contact',
                'meta_title' => 'Ishop - اتصال',
                'meta_description' => 'اتصال',
                'lang' => 'ar'
            ],

            [
                'page_id' => 4,
                'title' => 'سياسة الاسترجاع',
                'description' => $refundPolicyAr,
                'meta_title' => 'Ishop - سياسة الاسترجاع',
                'meta_description' => 'سياسة الاسترجاع',
                'lang' => 'ar'
            ],
            [
                'page_id' => 5,
                'title' => 'سياسة الخصوصية',
                'description' => $privacyPolicyAr,
                'meta_title' => 'Ishop - سياسة الخصوصية',
                'meta_description' => 'سياسة الخصوصية',
                'lang' => 'ar'
            ],
            [
                'page_id' => 6,
                'title' => 'يساعد',
                'description' => $helpAr,
                'meta_title' => 'Ishop - يساعد',
                'meta_description' => 'يساعد',
                'lang' => 'ar'
            ],
            [
                'page_id' => 7,
                'title' => 'خريطة الموقع',
                'description' => 'Sitemap',
                'meta_title' => 'Ishop - خريطة الموقع',
                'meta_description' => 'خريطة الموقع',
                'lang' => 'ar'
            ],




            [
                'page_id' => 1,
                'title' => 'Hakkında',
                'description' => $aboutTr,
                'meta_title' => 'Ishop - Hakkında',
                'meta_description' => 'Hakkında',
                'lang' => 'tr'
            ],
            [
                'page_id' => 2,
                'title' => 'SSS',
                'description' => $faqTr,
                'meta_title' => 'Ishop - SSS',
                'meta_description' => 'SSS',
                'lang' => 'tr'
            ],
            [
                'page_id' => 3,
                'title' => 'Temas etmek',
                'description' => 'Contact',
                'meta_title' => 'Ishop - Temas etmek',
                'meta_description' => 'Temas etmek',
                'lang' => 'tr'
            ],

            [
                'page_id' => 4,
                'title' => 'Geri ödeme politikası',
                'description' => $refundPolicyTr,
                'meta_title' => 'Ishop - Geri ödeme politikası',
                'meta_description' => 'Geri ödeme politikası',
                'lang' => 'tr'
            ],
            [
                'page_id' => 5,
                'title' => 'Gizlilik Politikası',
                'description' => $privacyPolicyTr,
                'meta_title' => 'Ishop - Gizlilik Politikası',
                'meta_description' => 'Gizlilik Politikası',
                'lang' => 'tr'
            ],
            [
                'page_id' => 6,
                'title' => 'Yardım',
                'description' => $helpTr,
                'meta_title' => 'Ishop - Yardım',
                'meta_description' => 'Yardım',
                'lang' => 'tr'
            ],
            [
                'page_id' => 7,
                'title' => 'site haritası',
                'description' => 'Sitemap',
                'meta_title' => 'Ishop - site haritası',
                'meta_description' => 'site haritası',
                'lang' => 'tr'
            ],



            [
                'page_id' => 1,
                'title' => 'À propos',
                'description' => $aboutFr,
                'meta_title' => 'Ishop - À propos',
                'meta_description' => 'À propos',
                'lang' => 'fr'
            ],
            [
                'page_id' => 2,
                'title' => 'FAQ',
                'description' => $faqFr,
                'meta_title' => 'Ishop - FAQ',
                'meta_description' => 'FAQ',
                'lang' => 'fr'
            ],
            [
                'page_id' => 3,
                'title' => 'Contact',
                'description' => 'Contact',
                'meta_title' => 'Ishop - Contact',
                'meta_description' => 'Contact',
                'lang' => 'fr'
            ],

            [
                'page_id' => 4,
                'title' => 'Politique de remboursement',
                'description' => $refundPolicyFr,
                'meta_title' => 'Ishop - Politique de remboursement',
                'meta_description' => 'Politique de remboursement',
                'lang' => 'fr'
            ],
            [
                'page_id' => 5,
                'title' => 'politique de confidentialité',
                'description' => $privacyPolicyFr,
                'meta_title' => 'Ishop - politique de confidentialité',
                'meta_description' => 'politique de confidentialité',
                'lang' => 'fr'
            ],
            [
                'page_id' => 6,
                'title' => 'Aider',
                'description' => $helpFr,
                'meta_title' => 'Ishop - Aider',
                'meta_description' => 'Aider',
                'lang' => 'fr'
            ],
            [
                'page_id' => 7,
                'title' => 'Plan du site',
                'description' => 'Sitemap',
                'meta_title' => 'Ishop - Plan du site',
                'meta_description' => 'Plan du site',
                'lang' => 'fr'
            ],




            [
                'page_id' => 1,
                'title' => 'के बारे में',
                'description' => $aboutHi,
                'meta_title' => 'Ishop - के बारे में',
                'meta_description' => 'के बारे में',
                'lang' => 'hi'
            ],
            [
                'page_id' => 2,
                'title' => 'सामान्य प्रश्न',
                'description' => $faqHi,
                'meta_title' => 'Ishop - सामान्य प्रश्न',
                'meta_description' => 'सामान्य प्रश्न',
                'lang' => 'hi'
            ],
            [
                'page_id' => 3,
                'title' => 'संपर्क',
                'description' => 'Contact',
                'meta_title' => 'Ishop - संपर्क',
                'meta_description' => 'संपर्क',
                'lang' => 'hi'
            ],

            [
                'page_id' => 4,
                'title' => 'भुगतान वापसी की नीति',
                'description' => $refundPolicyHi,
                'meta_title' => 'Ishop - भुगतान वापसी की नीति',
                'meta_description' => 'भुगतान वापसी की नीति',
                'lang' => 'hi'
            ],
            [
                'page_id' => 5,
                'title' => 'गोपनीयता नीति',
                'description' => $privacyPolicyHi,
                'meta_title' => 'Ishop - गोपनीयता नीति',
                'meta_description' => 'गोपनीयता नीति',
                'lang' => 'hi'
            ],
            [
                'page_id' => 6,
                'title' => 'मदद',
                'description' => $helpHi,
                'meta_title' => 'Ishop - मदद',
                'meta_description' => 'मदद',
                'lang' => 'hi'
            ],
            [
                'page_id' => 7,
                'title' => 'साइट मैप',
                'description' => 'Sitemap',
                'meta_title' => 'Ishop - साइट मैप',
                'meta_description' => 'साइट मैप',
                'lang' => 'hi'
            ]
        ];



        if(!PageLang::first()){
            foreach ($items as $i) {

                if(Page::where('id', $i['page_id'])->first()){
                    PageLang::create($i);
                }


            }
        }
    }
}
