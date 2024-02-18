<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\CategoryLang;
use Illuminate\Database\Seeder;

class CategoryLangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $metaTitleFr = " Produits Achats en ligne";
        $metaDescriptionFr1 = "Acheter ";
        $metaDescriptionFr2 = " aux meilleurs prix de vente aujourd'hui!";

        $metaTitleHi = " उत्पाद ऑनलाइन शॉपिंग";
        $metaDescriptionHi1 = "खरीदना ";
        $metaDescriptionHi2 = " सबसे अच्छी बिक्री कीमतों पर आज!";


        $metaTitleAr = " المنتجات للتسوق عبر الإنترنت";
        $metaDescriptionAr1 = "يشتري ";
        $metaDescriptionAr2 = " بأفضل أسعار البيع اليوم!";


        $metaTitleTr = " Ürünler Çevrimiçi Alışveriş";
        $metaDescriptionTr1 = "Satın almak ";
        $metaDescriptionTr2 = " bugünün en iyi satış fiyatlarıyla!";


        $items = [
            [
                'category_id' => 63082111,
                'title' => 'Kadın Giyim',
                'meta_title' => 'Kadın Giyim' . $metaTitleTr,
                'meta_description' => $metaDescriptionTr1 . 'Kadın Giyim' . $metaDescriptionTr2,
                'lang' => 'tr',
            ],
            [
                'category_id' => 63082112,
                'title' => 'Güzellik ve Kişisel Bakım',
                'meta_title' => 'Güzellik ve Kişisel Bakım' . $metaTitleTr,
                'meta_description' => $metaDescriptionTr1 . 'Güzellik ve Kişisel Bakım' . $metaDescriptionTr2,
                'lang' => 'tr',
            ],
            [
                'category_id' => 72531155,
                'title' => "Bayan Çantaları",
                'meta_title' => "Bayan Çantaları" . $metaTitleTr,
                'meta_description' => $metaDescriptionTr1 . "Bayan Çantaları" . $metaDescriptionTr2,
                'lang' => 'tr',
            ],
            [
                'category_id' => 72531153,
                'title' => 'Takı ve Aksesuarlar',
                'meta_title' => "Takı ve Aksesuarlar" . $metaTitleTr,
                'meta_description' => $metaDescriptionTr1 . "Takı ve Aksesuarlar" . $metaDescriptionTr2,
                'lang' => 'tr',
            ],
            [
                'category_id' => 61952111,
                'title' => "erkek giyim",
                'meta_title' => "erkek giyim" . $metaTitleTr,
                'meta_description' => $metaDescriptionTr1 . "erkek giyim" . $metaDescriptionTr2,
                'lang' => 'tr',
            ],
            [
                'category_id' => 96522110,
                'title' => "Erkek Çantaları",
                'meta_title' => "Erkek Çantaları" . $metaTitleTr,
                'meta_description' => $metaDescriptionTr1 . "Erkek Çantaları" . $metaDescriptionTr2,
                'lang' => 'tr',
            ],
            [
                'category_id' => 72533143,
                'title' => 'Seyahat ve Bagaj',
                'meta_title' => "Seyahat ve Bagaj" . $metaTitleTr,
                'meta_description' => $metaDescriptionTr1 . "Seyahat ve Bagaj" . $metaDescriptionTr2,
                'lang' => 'tr',
            ],
            [
                'category_id' => 96674111,
                'title' => 'Oyuncaklar, Çocuklar ve Bebekler',
                'meta_title' => "Oyuncaklar, Çocuklar ve Bebekler" . $metaTitleTr,
                'meta_description' => $metaDescriptionTr1 . "Oyuncaklar, Çocuklar ve Bebekler" . $metaDescriptionTr2,
                'lang' => 'tr',
            ],
            [
                'category_id' => 91202114,
                'title' => "Erkek ayakkabıları",
                'meta_title' => "Erkek ayakkabıları" . $metaTitleTr,
                'meta_description' => $metaDescriptionTr1 . "Erkek ayakkabıları" .  $metaDescriptionTr2,
                'lang' => 'tr',
            ],
            [
                'category_id' => 92522115,
                'title' => 'Ev yaşantısı',
                'meta_title' => "Ev yaşantısı" . $metaTitleTr,
                'meta_description' => $metaDescriptionTr1 . "Ev yaşantısı" . $metaDescriptionTr2,
                'lang' => 'tr',
            ],
            [
                'category_id' => 96874118,
                'title' => 'Yiyecek ve İçecekler',
                'meta_title' => "Yiyecek ve İçecekler" . $metaTitleTr,
                'meta_description' => $metaDescriptionTr1 . "Yiyecek ve İçecekler" . $metaDescriptionTr2,
                'lang' => 'tr',
            ],
            [
                'category_id' => 91233119,
                'title' => 'Ev Aletleri',
                'meta_title' => "Ev Aletleri" . $metaTitleTr,
                'meta_description' => $metaDescriptionTr1 . "Ev Aletleri" . $metaDescriptionTr2,
                'lang' => 'tr',
            ],



            [
                'category_id' => 63082111,
                'title' => 'ملابس نسائية',
                'meta_title' => 'ملابس نسائية' . $metaTitleAr,
                'meta_description' => $metaDescriptionAr1 . 'ملابس نسائية' . $metaDescriptionAr2,
                'lang' => 'ar',
            ],
            [
                'category_id' => 63082112,
                'title' => 'الجمال والعناية الشخصية',
                'meta_title' => 'الجمال والعناية الشخصية' . $metaTitleAr,
                'meta_description' => $metaDescriptionAr1 . 'الجمال والعناية الشخصية' . $metaDescriptionAr2,
                'lang' => 'ar',
            ],
            [
                'category_id' => 72531155,
                'title' => "حقائب نسائية",
                'meta_title' => "حقائب نسائية" . $metaTitleAr,
                'meta_description' => $metaDescriptionAr1 . "حقائب نسائية" . $metaDescriptionAr2,
                'lang' => 'ar',
            ],
            [
                'category_id' => 72531153,
                'title' => 'المجوهرات والاكسسوارات',
                'meta_title' => "المجوهرات والاكسسوارات" . $metaTitleAr,
                'meta_description' => $metaDescriptionAr1 . "المجوهرات والاكسسوارات" . $metaDescriptionAr2,
                'lang' => 'ar',
            ],
            [
                'category_id' => 61952111,
                'title' => "ملابس رجالية",
                'meta_title' => "ملابس رجالية" . $metaTitleAr,
                'meta_description' => $metaDescriptionAr1 . "ملابس رجالية" . $metaDescriptionAr2,
                'lang' => 'ar',
            ],
            [
                'category_id' => 96522110,
                'title' => "حقائب رجالية",
                'meta_title' => "حقائب رجالية" . $metaTitleAr,
                'meta_description' => $metaDescriptionAr1 . "حقائب رجالية" . $metaDescriptionAr2,
                'lang' => 'ar',
            ],
            [
                'category_id' => 72533143,
                'title' => 'السفر والأمتعة',
                'meta_title' => "السفر والأمتعة" . $metaTitleAr,
                'meta_description' => $metaDescriptionAr1 . "السفر والأمتعة" . $metaDescriptionAr2,
                'lang' => 'ar',
            ],
            [
                'category_id' => 96674111,
                'title' => 'لعب الاطفال والرضع',
                'meta_title' => "لعب الاطفال والرضع" . $metaTitleAr,
                'meta_description' => $metaDescriptionAr1 . "لعب الاطفال والرضع" . $metaDescriptionAr2,
                'lang' => 'ar',
            ],
            [
                'category_id' => 91202114,
                'title' => "احذية رجالية",
                'meta_title' => "احذية رجالية" . $metaTitleAr,
                'meta_description' => $metaDescriptionAr1 . "احذية رجالية" . $metaDescriptionAr2,
                'lang' => 'ar',
            ],
            [
                'category_id' => 92522115,
                'title' => 'المعيشة المنزلية',
                'meta_title' => "المعيشة المنزلية" . $metaTitleAr,
                'meta_description' => $metaDescriptionAr1 . "المعيشة المنزلية" . $metaDescriptionAr2,
                'lang' => 'ar',
            ],
            [
                'category_id' => 96874118,
                'title' => 'مأكولات ومشروبات',
                'meta_title' => "مأكولات ومشروبات" . $metaTitleAr,
                'meta_description' => $metaDescriptionAr1 . "مأكولات ومشروبات" . $metaDescriptionAr2,
                'lang' => 'ar',
            ],
            [
                'category_id' => 91233119,
                'title' => 'أجهزة منزلية',
                'meta_title' => "أجهزة منزلية" . $metaTitleAr,
                'meta_description' => $metaDescriptionAr1 . "أجهزة منزلية" . $metaDescriptionAr2,
                'lang' => 'ar',
            ],




            [
                'category_id' => 63082111,
                'title' => 'महिला परिधान',
                'meta_title' => 'महिला परिधान' . $metaTitleHi,
                'meta_description' => $metaDescriptionHi1 . 'महिला परिधान' . $metaDescriptionHi2,
                'lang' => 'hi',
            ],
            [
                'category_id' => 63082112,
                'title' => 'सौंदर्य और व्यक्तिगत देखभाल',
                'meta_title' => 'सौंदर्य और व्यक्तिगत देखभाल' . $metaTitleHi,
                'meta_description' => $metaDescriptionHi1 . 'सौंदर्य और व्यक्तिगत देखभाल' . $metaDescriptionHi2,
                'lang' => 'hi',
            ],
            [
                'category_id' => 72531155,
                'title' => "महिलाओं के बैग",
                'meta_title' => "महिलाओं के बैग" . $metaTitleHi,
                'meta_description' => $metaDescriptionHi1 . "महिलाओं के बैग" . $metaDescriptionHi2,
                'lang' => 'hi',
            ],
            [
                'category_id' => 72531153,
                'title' => 'आभूषण और सहायक उपकरण',
                'meta_title' => "आभूषण और सहायक उपकरण" . $metaTitleHi,
                'meta_description' => $metaDescriptionHi1 . "आभूषण और सहायक उपकरण" . $metaDescriptionHi2,
                'lang' => 'hi',
            ],
            [
                'category_id' => 61952111,
                'title' => "पुरुषों के वस्त्र",
                'meta_title' => "पुरुषों के वस्त्र" . $metaTitleHi,
                'meta_description' => $metaDescriptionHi1 . "पुरुषों के वस्त्र" . $metaDescriptionHi2,
                'lang' => 'hi',
            ],
            [
                'category_id' => 96522110,
                'title' => "पुरुषों के बैग",
                'meta_title' => "पुरुषों के बैग" . $metaTitleHi,
                'meta_description' => $metaDescriptionHi1 . "पुरुषों के बैग" . $metaDescriptionHi2,
                'lang' => 'hi',
            ],
            [
                'category_id' => 72533143,
                'title' => 'यात्रा और सामान',
                'meta_title' => "यात्रा और सामान" . $metaTitleHi,
                'meta_description' => $metaDescriptionHi1 . "यात्रा और सामान" . $metaDescriptionHi2,
                'lang' => 'hi',
            ],
            [
                'category_id' => 96674111,
                'title' => 'खिलौने, बच्चे और बच्चे',
                'meta_title' => "खिलौने, बच्चे और बच्चे" . $metaTitleHi,
                'meta_description' => $metaDescriptionHi1 . "खिलौने, बच्चे और बच्चे" . $metaDescriptionHi2,
                'lang' => 'hi',
            ],
            [
                'category_id' => 91202114,
                'title' => "पुरुषों के जूते",
                'meta_title' => "पुरुषों के जूते" . $metaTitleHi,
                'meta_description' => $metaDescriptionHi1 . "पुरुषों के जूते" . $metaDescriptionHi2,
                'lang' => 'hi',
            ],
            [
                'category_id' => 92522115,
                'title' => 'घर में रहने वाले',
                'meta_title' => "घर में रहने वाले" . $metaTitleHi,
                'meta_description' => $metaDescriptionHi1 . "घर में रहने वाले" . $metaDescriptionHi2,
                'lang' => 'hi',
            ],
            [
                'category_id' => 96874118,
                'title' => 'खाद्य और पेय पदार्थ',
                'meta_title' => "खाद्य और पेय पदार्थ" . $metaTitleHi,
                'meta_description' => $metaDescriptionHi1 . "खाद्य और पेय पदार्थ" . $metaDescriptionHi2,
                'lang' => 'hi',
            ],
            [
                'category_id' => 91233119,
                'title' => 'घरेलू उपकरण',
                'meta_title' => "घरेलू उपकरण" . $metaTitleHi,
                'meta_description' => $metaDescriptionHi1 . "घरेलू उपकरण" . $metaDescriptionHi2,
                'lang' => 'hi',
            ],




            [
                'category_id' => 63082111,
                'title' => 'Vêtements pour femmes',
                'meta_title' => 'Vêtements pour femmes' . $metaTitleFr,
                'meta_description' => $metaDescriptionFr1 . 'Vêtements pour femmes' . $metaDescriptionFr2,
                'lang' => 'fr',
            ],
            [
                'category_id' => 63082112,
                'title' => 'Beauté et soins personnels',
                'meta_title' => 'Beauté et soins personnels' . $metaTitleFr,
                'meta_description' => $metaDescriptionFr1 . 'Beauté et soins personnels' . $metaDescriptionFr2,
                'lang' => 'fr',
            ],
            [
                'category_id' => 72531155,
                'title' => "Sacs femme",
                'meta_title' => "Sacs femme" . $metaTitleFr,
                'meta_description' => $metaDescriptionFr1 . "Sacs femme" . $metaDescriptionFr2,
                'lang' => 'fr',
            ],
            [
                'category_id' => 72531153,
                'title' => 'Bijoux & Accessoires',
                'meta_title' => "Bijoux & Accessoires" . $metaTitleFr,
                'meta_description' => $metaDescriptionFr1 . "Bijoux & Accessoires" . $metaDescriptionFr2,
                'lang' => 'fr',
            ],
            [
                'category_id' => 61952111,
                'title' => "Vêtements pour hommes",
                'meta_title' => "Vêtements pour hommes" . $metaTitleFr,
                'meta_description' => $metaDescriptionFr1 . "Vêtements pour hommes" . $metaDescriptionFr2,
                'lang' => 'fr',
            ],
            [
                'category_id' => 96522110,
                'title' => "Sacs pour hommes",
                'meta_title' => "Sacs pour hommes" . $metaTitleFr,
                'meta_description' => $metaDescriptionFr1 . "Sacs pour hommes" . $metaDescriptionFr2,
                'lang' => 'fr',
            ],
            [
                'category_id' => 72533143,
                'title' => 'Voyage & Bagages',
                'meta_title' => "Voyage & Bagages" . $metaTitleFr,
                'meta_description' => $metaDescriptionFr1 . "Voyage & Bagages" . $metaDescriptionFr2,
                'lang' => 'fr',
            ],
            [
                'category_id' => 96674111,
                'title' => 'Jouets, enfants et bébés',
                'meta_title' => "Jouets, enfants et bébés" . $metaTitleFr,
                'meta_description' => $metaDescriptionFr1 . "Jouets, enfants et bébés" . $metaDescriptionFr2,
                'lang' => 'fr',
            ],
            [
                'category_id' => 91202114,
                'title' => "Chaussures pour hommes",
                'meta_title' => "Chaussures pour hommes" . $metaTitleFr,
                'meta_description' => $metaDescriptionFr1 . "Chaussures pour hommes" . $metaDescriptionFr2,
                'lang' => 'fr',
            ],
            [
                'category_id' => 92522115,
                'title' => 'La vie domestique',
                'meta_title' => "La vie domestique" . $metaTitleFr,
                'meta_description' => $metaDescriptionFr1 . "La vie domestique" . $metaDescriptionFr2,
                'lang' => 'fr',
            ],
            [
                'category_id' => 96874118,
                'title' => 'Nourriture et boissons',
                'meta_title' => "Nourriture et boissons" . $metaTitleFr,
                'meta_description' => $metaDescriptionFr1 . "Nourriture et boissons" . $metaDescriptionFr2,
                'lang' => 'fr',
            ],
            [
                'category_id' => 91233119,
                'title' => 'Appareils ménagers',
                'meta_title' => "Appareils ménagers" . $metaTitleFr,
                'meta_description' => $metaDescriptionFr1 . "Appareils ménagers" . $metaDescriptionFr2,
                'lang' => 'fr',
            ]

        ];



        $cat1 = Category::where('id', 91233119)->first();
        $cat2 = Category::where('id', 91202114)->first();
        $cat3 = Category::where('id', 96522110)->first();


        if(!CategoryLang::first() && $cat1 && $cat2 && $cat3){
            foreach ($items as $i) {
                CategoryLang::create($i);
            }
        }
    }
}
