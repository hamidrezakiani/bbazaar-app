<?php

namespace Database\Seeders;

use App\Models\SubCategory;
use App\Models\SubCategoryLang;
use Illuminate\Database\Seeder;

class SubCategoryLangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $metaTitleFr = " Produits Achats en ligne";
        $metaDescriptionFr = "Acheter ";
        $metaDescriptionFr2 = " aux meilleurs prix de vente aujourd'hui!";

        $metaTitleHi = " उत्पाद ऑनलाइन शॉपिंग";
        $metaDescriptionHi = "खरीदना ";
        $metaDescriptionHi2 = " सबसे अच्छी बिक्री कीमतों पर आज!";


        $metaTitleAr = " المنتجات للتسوق عبر الإنترنت";
        $metaDescriptionAr = "يشتري ";
        $metaDescriptionAr2 = " بأفضل أسعار البيع اليوم!";


        $metaTitleTr = " Ürünler Çevrimiçi Alışveriş";
        $metaDescriptionTr = "Satın almak ";
        $metaDescriptionTr2 = " bugünün en iyi satış fiyatlarıyla!";






        $items = [

            [
                "sub_category_id" => 64273111,
                "title" => "Üstler",
                "meta_title" => "Üstler" . $metaTitleTr,
                "meta_description" => $metaDescriptionTr . "Üstler" . $metaDescriptionTr2,
                'lang' => 'tr',
            ],
            [
                "sub_category_id" => 73294112,
                "title" => "Elbiseler",
                "meta_title" => "Elbiseler" . $metaTitleTr,
                "meta_description" => $metaDescriptionTr . "Elbiseler" . $metaDescriptionTr2,
                'lang' => 'tr',
            ],
            [
                "sub_category_id" => 96323113,
                "title" => "Çorap ve Tayt",
                "meta_title" => "Çorap ve Tayt" . $metaTitleTr,
                "meta_description" => $metaDescriptionTr . "Çorap ve Tayt" . $metaDescriptionTr2,
                'lang' => 'tr',
            ],
            [
                "sub_category_id" => 96765114,
                "title" => "Pantolon ve Tayt",
                'lang' => 'tr',
                "meta_title" => "Pantolon ve Tayt" . $metaTitleTr,
                "meta_description" => $metaDescriptionTr . "Pantolon ve Tayt" . $metaDescriptionTr2
            ],

            [
                "sub_category_id" => 97373115,
                "title" => "Bayan Saç Bakımı",
                'lang' => 'tr',
                "meta_title" => "Bayan Saç Bakımı" . $metaTitleTr,
                "meta_description" => $metaDescriptionTr . "Bayan Saç Bakımı" . $metaDescriptionTr2
            ],
            [
                "sub_category_id" => 97373116,
                "title" => "Kadın Bakımı",
                'lang' => 'tr',
                "meta_title" => "Kadın Bakımı" . $metaTitleTr,
                "meta_description" => $metaDescriptionTr . "Kadın Bakımı" . $metaDescriptionTr2
            ],

            [
                "sub_category_id" => 97373117,
                "title" => "Cilt bakımı",
                'lang' => 'tr',
                "meta_title" => "Cilt bakımı" . $metaTitleTr,
                "meta_description" => $metaDescriptionTr . "Cilt bakımı" . $metaDescriptionTr2
            ],

            [
                "sub_category_id" => 73294118,
                "title" => "Askılı Çantalar",
                'lang' => 'tr',
                "meta_title" => "Askılı Çantalar" . $metaTitleTr,
                "meta_description" => $metaDescriptionTr . "Askılı Çantalar" . $metaDescriptionTr2
            ],
            [
                "sub_category_id" => 96323119,
                "title" => "Manşonlar ve Mini Çantalar",
                'lang' => 'tr',
                "meta_title" => "Manşonlar ve Mini Çantalar" . $metaTitleTr,
                "meta_description" => $metaDescriptionTr . "Manşonlar ve Mini Çantalar" . $metaDescriptionTr2
            ],
            [
                "sub_category_id" => 96765110,
                "title" => "Çantalar",
                'lang' => 'tr',
                "meta_title" => "Çantalar" . $metaTitleTr,
                "meta_description" => $metaDescriptionTr . "Çantalar" . $metaDescriptionTr2
            ],
            [
                "sub_category_id" => 97373121,
                "title" => "Anahtarlık",
                'lang' => 'tr',
                "meta_title" => "Anahtarlık" . $metaTitleTr,
                "meta_description" => $metaDescriptionTr . "Anahtarlık" . $metaDescriptionTr2
            ],
            [
                "sub_category_id" => 99585122,
                "title" => "gözlük",
                'lang' => 'tr',
                "meta_title" => "gözlük" . $metaTitleTr,
                "meta_description" => $metaDescriptionTr . "gözlük" . $metaDescriptionTr2
            ],
            [
                "sub_category_id" => 96765123,
                "title" => "Şapkalar ve Bereler",
                'lang' => 'tr',
                "meta_title" => "Şapkalar ve Bereler" . $metaTitleTr,
                "meta_description" => $metaDescriptionTr . "Şapkalar ve Bereler" . $metaDescriptionTr2
            ],
            [
                "sub_category_id" => 97373124,
                "title" => "gömlek",
                'lang' => 'tr',
                "meta_title" => "gömlek" . $metaTitleTr,
                "meta_description" => $metaDescriptionTr . "gömlek" . $metaDescriptionTr2
            ],
            [
                "sub_category_id" => 99585125,
                "title" => "ceketler ve kabanlar",
                'lang' => 'tr',
                "meta_title" => "ceketler ve kabanlar" . $metaTitleTr,
                "meta_description" => $metaDescriptionTr . "ceketler ve kabanlar" . $metaDescriptionTr2
            ],
            [
                "sub_category_id" => 96765126,
                "title" => "Pantolon",
                'lang' => 'tr',
                "meta_title" => "Pantolon" . $metaTitleTr,
                "meta_description" => $metaDescriptionTr . "Pantolon" . $metaDescriptionTr2
            ],
            [
                "sub_category_id" => 99585127,
                "title" => "Erkek Cüzdanı",
                'lang' => 'tr',
                "meta_title" => "Erkek Cüzdanı" . $metaTitleTr,
                "meta_description" => $metaDescriptionTr . "Erkek Cüzdanı" . $metaDescriptionTr2
            ],
            [
                "sub_category_id" => 99585128,
                "title" => "Sırt çantaları",
                'lang' => 'tr',
                "meta_title" => "Sırt çantaları" . $metaTitleTr,
                "meta_description" => $metaDescriptionTr . "Sırt çantaları" . $metaDescriptionTr2
            ],
            [
                "sub_category_id" => 96765129,
                "title" => "Crossbody ve Omuz Çantaları",
                'lang' => 'tr',
                "meta_title" => "Crossbody ve Omuz Çantaları" . $metaTitleTr,
                "meta_description" => $metaDescriptionTr . "Crossbody ve Omuz Çantaları" . $metaDescriptionTr2
            ],
            [
                "sub_category_id" => 99585130,
                "title" => "Evrak çantaları",
                'lang' => 'tr',
                "meta_title" => "Evrak çantaları" . $metaTitleTr,
                "meta_description" => $metaDescriptionTr . "Evrak çantaları" . $metaDescriptionTr2
            ],
            [
                "sub_category_id" => 99585131,
                "title" => "Takım Elbise Taşıyıcıları",
                'lang' => 'tr',
                "meta_title" => "Takım Elbise Taşıyıcıları" . $metaTitleTr,
                "meta_description" => $metaDescriptionTr . "Takım Elbise Taşıyıcıları" . $metaDescriptionTr2
            ],
            [
                "sub_category_id" => 96765132,
                "title" => "Çantalar",
                'lang' => 'tr',
                "meta_title" => "Çantalar" . $metaTitleTr,
                "meta_description" => $metaDescriptionTr . "Çantalar" . $metaDescriptionTr2
            ],
            [
                "sub_category_id" => 99585133,
                "title" => "Seyahat Çantaları & Sırt Çantaları",
                'lang' => 'tr',
                "meta_title" => "Seyahat Çantaları & Sırt Çantaları" . $metaTitleTr,
                "meta_description" => $metaDescriptionTr . "Seyahat Çantaları & Sırt Çantaları" . $metaDescriptionTr2
            ],
            [
                "sub_category_id" => 99585134,
                "title" => "Seyahat Aksesuarları",
                'lang' => 'tr',
                "meta_title" => "Seyahat Aksesuarları" . $metaTitleTr,
                "meta_description" => $metaDescriptionTr . "Seyahat Aksesuarları" . $metaDescriptionTr2
            ],
            [
                "sub_category_id" => 96765135,
                "title" => "Bagaj",
                'lang' => 'tr',
                "meta_title" => "Bagaj" . $metaTitleTr,
                "meta_description" => $metaDescriptionTr . "Bagaj" . $metaDescriptionTr2
            ],
            [
                "sub_category_id" => 99585136,
                "title" => "Doğum Bakımı",
                'lang' => 'tr',
                "meta_title" => "Maternity Care" . $metaTitleTr,
                "meta_description" => $metaDescriptionTr . "Doğum Bakımı" . $metaDescriptionTr2
            ],
            [
                "sub_category_id" => 99585137,
                "title" => "Çocuk Mobilyaları",
                'lang' => 'tr',
                "meta_title" => "Çocuk Mobilyaları" . $metaTitleTr,
                "meta_description" => $metaDescriptionTr . "Çocuk Mobilyaları" . $metaDescriptionTr2
            ],
            [
                "sub_category_id" => 96765138,
                "title" => "Banyo & Bebek Bakımı",
                'lang' => 'tr',
                "meta_title" => "Banyo & Bebek Bakımı" . $metaTitleTr,
                "meta_description" => $metaDescriptionTr . "Banyo & Bebek Bakımı" . $metaDescriptionTr2
            ],
            [
                "sub_category_id" => 99585139,
                "title" => "Sandalet ve Parmak Arası Terlik",
                'lang' => 'tr',
                "meta_title" => "Sandalet ve Parmak Arası Terlik" . $metaTitleTr,
                "meta_description" => $metaDescriptionTr . "Sandalet ve Parmak Arası Terlik" . $metaDescriptionTr2
            ],
            [
                "sub_category_id" => 99585140,
                "title" => "Spor ayakkabı",
                'lang' => 'tr',
                "meta_title" => "Spor ayakkabı" . $metaTitleTr,
                "meta_description" => $metaDescriptionTr . "Spor ayakkabı" . $metaDescriptionTr2
            ],
            [
                "sub_category_id" => 96765141,
                "title" => "Resmi Ayakkabı",
                'lang' => 'tr',
                "meta_title" => "Resmi Ayakkabı" . $metaTitleTr,
                "meta_description" => $metaDescriptionTr . "Resmi Ayakkabı" . $metaDescriptionTr2
            ],
            [
                "sub_category_id" => 99585142,
                "title" => "Aletler, Kendin Yap ve Dış Mekanlar",
                'lang' => 'tr',
                "meta_title" => "Aletler, Kendin Yap ve Dış Mekanlar" . $metaTitleTr,
                "meta_description" => $metaDescriptionTr . "Aletler, Kendin Yap ve Dış Mekanlar" . $metaDescriptionTr2
            ],
            [
                "sub_category_id" => 99585143,
                "title" => "Mutfak ve Yemek",
                'lang' => 'tr',
                "meta_title" => "Mutfak ve Yemek" . $metaTitleTr,
                "meta_description" => $metaDescriptionTr . "Mutfak ve Yemek" . $metaDescriptionTr2
            ],
            [
                "sub_category_id" => 96765144,
                "title" => "Ev dekoru",
                'lang' => 'tr',
                "meta_title" => "Ev dekoru" . $metaTitleTr,
                "meta_description" => $metaDescriptionTr . "Ev dekoru" . $metaDescriptionTr2
            ],
            [
                "sub_category_id" => 99585145,
                "title" => "Et ve Deniz Ürünleri",
                'lang' => 'tr',
                "meta_title" => "Et ve Deniz Ürünleri" . $metaTitleTr,
                "meta_description" => $metaDescriptionTr . "Et ve Deniz Ürünleri" . $metaDescriptionTr2
            ],
            [
                "sub_category_id" => 96765147,
                "title" => "Atıştırmalıklar ve Tatlılar",
                'lang' => 'tr',
                "meta_title" => "Atıştırmalıklar ve Tatlılar" . $metaTitleTr,
                "meta_description" => $metaDescriptionTr . "Atıştırmalıklar ve Tatlılar" . $metaDescriptionTr2
            ],
            [
                "sub_category_id" => 99585148,
                "title" => "Televizyon aksesuarları",
                'lang' => 'tr',
                "meta_title" => "Televizyon aksesuarları" . $metaTitleTr,
                "meta_description" => $metaDescriptionTr . "Televizyon aksesuarları" . $metaDescriptionTr2
            ],
            [
                "sub_category_id" => 99585149,
                "title" => "Küçük Mutfak Aletleri",
                'lang' => 'tr',
                "meta_title" => "Küçük Mutfak Aletleri" . $metaTitleTr,
                "meta_description" => $metaDescriptionTr . "Küçük Mutfak Aletleri" . $metaDescriptionTr2
            ],
            [
                "sub_category_id" => 96765150,
                "title" => "Kat hizmetleri",
                'lang' => 'tr',
                "meta_title" => "Kat hizmetleri" . $metaTitleTr,
                "meta_description" => $metaDescriptionTr . "Kat hizmetleri" . $metaDescriptionTr2
            ],





            [
                "sub_category_id" => 64273111,
                "title" => "सबसे ऊपर",
                "meta_title" => "सबसे ऊपर" . $metaTitleHi,
                "meta_description" => $metaDescriptionHi . "सबसे ऊपर" . $metaDescriptionHi2,
                'lang' => 'hi',
            ],
            [
                "sub_category_id" => 73294112,
                "title" => "कपड़े",
                "meta_title" => "कपड़े" . $metaTitleHi,
                "meta_description" => $metaDescriptionHi . "कपड़े" . $metaDescriptionHi2,
                'lang' => 'hi',
            ],
            [
                "sub_category_id" => 96323113,
                "title" => "मोज़े और चड्डी",
                "meta_title" => "मोज़े और चड्डी" . $metaTitleHi,
                "meta_description" => $metaDescriptionHi . "मोज़े और चड्डी" . $metaDescriptionHi2,
                'lang' => 'hi',
            ],
            [
                "sub_category_id" => 96765114,
                "title" => "पैंटोलन और लेगिंग्स",
                'lang' => 'hi',
                "meta_title" => "पैंटोलन और लेगिंग्स" . $metaTitleHi,
                "meta_description" => $metaDescriptionHi . "पैंटोलन और लेगिंग्स" . $metaDescriptionHi2
            ],

            [
                "sub_category_id" => 97373115,
                "title" => "महिलाओं के बालों की देखभाल",
                'lang' => 'hi',
                "meta_title" => "महिलाओं के बालों की देखभाल" . $metaTitleHi,
                "meta_description" => $metaDescriptionHi . "महिलाओं के बालों की देखभाल" . $metaDescriptionHi2
            ],
            [
                "sub_category_id" => 97373116,
                "title" => "स्त्री देखभाल",
                'lang' => 'hi',
                "meta_title" => "स्त्री देखभाल" . $metaTitleHi,
                "meta_description" => $metaDescriptionHi . "स्त्री देखभाल" . $metaDescriptionHi2
            ],

            [
                "sub_category_id" => 97373117,
                "title" => "त्वचा की देखभाल",
                'lang' => 'hi',
                "meta_title" => "त्वचा की देखभाल" . $metaTitleHi,
                "meta_description" => $metaDescriptionHi . "त्वचा की देखभाल" . $metaDescriptionHi2
            ],

            [
                "sub_category_id" => 73294118,
                "title" => "गोफन बैग",
                'lang' => 'hi',
                "meta_title" => "गोफन बैग" . $metaTitleHi,
                "meta_description" => $metaDescriptionHi . "गोफन बैग" . $metaDescriptionHi2
            ],
            [
                "sub_category_id" => 96323119,
                "title" => "चंगुल और मिनी बैग",
                'lang' => 'hi',
                "meta_title" => "चंगुल और मिनी बैग" . $metaTitleHi,
                "meta_description" => $metaDescriptionHi . "चंगुल और मिनी बैग" . $metaDescriptionHi2
            ],
            [
                "sub_category_id" => 96765110,
                "title" => "हैंडबैग",
                'lang' => 'hi',
                "meta_title" => "हैंडबैग" . $metaTitleHi,
                "meta_description" => $metaDescriptionHi . "हैंडबैग" . $metaDescriptionHi2
            ],
            [
                "sub_category_id" => 97373121,
                "title" => "कुंजी जंजीर",
                'lang' => 'hi',
                "meta_title" => "कुंजी जंजीर" . $metaTitleHi,
                "meta_description" => $metaDescriptionHi . "कुंजी जंजीर" . $metaDescriptionHi2
            ],
            [
                "sub_category_id" => 99585122,
                "title" => "चश्में",
                'lang' => 'hi',
                "meta_title" => "चश्में" . $metaTitleHi,
                "meta_description" => $metaDescriptionHi . "चश्में" . $metaDescriptionHi2
            ],
            [
                "sub_category_id" => 96765123,
                "title" => "टोपी और टोपियाँ",
                'lang' => 'hi',
                "meta_title" => "टोपी और टोपियाँ" . $metaTitleHi,
                "meta_description" => $metaDescriptionHi . "टोपी और टोपियाँ" . $metaDescriptionHi2
            ],
            [
                "sub_category_id" => 97373124,
                "title" => "शर्ट",
                'lang' => 'hi',
                "meta_title" => "शर्ट" . $metaTitleHi,
                "meta_description" => $metaDescriptionHi . "शर्ट" . $metaDescriptionHi2
            ],
            [
                "sub_category_id" => 99585125,
                "title" => "जैकेट और कोट",
                'lang' => 'hi',
                "meta_title" => "जैकेट और कोट" . $metaTitleHi,
                "meta_description" => $metaDescriptionHi . "जैकेट और कोट" . $metaDescriptionHi2
            ],
            [
                "sub_category_id" => 96765126,
                "title" => "पैजामा",
                'lang' => 'hi',
                "meta_title" => "पैजामा" . $metaTitleHi,
                "meta_description" => $metaDescriptionHi . "पैजामा" . $metaDescriptionHi2
            ],
            [
                "sub_category_id" => 99585127,
                "title" => "पुरुषों का बटुआ",
                'lang' => 'hi',
                "meta_title" => "पुरुषों का बटुआ" . $metaTitleHi,
                "meta_description" => $metaDescriptionHi . "पुरुषों का बटुआ" . $metaDescriptionHi2
            ],
            [
                "sub_category_id" => 99585128,
                "title" => "बैकपैक",
                'lang' => 'hi',
                "meta_title" => "बैकपैक" . $metaTitleHi,
                "meta_description" => $metaDescriptionHi . "बैकपैक" . $metaDescriptionHi2
            ],
            [
                "sub_category_id" => 96765129,
                "title" => "क्रॉसबॉडी और शोल्डर बैग",
                'lang' => 'hi',
                "meta_title" => "क्रॉसबॉडी और शोल्डर बैग" . $metaTitleHi,
                "meta_description" => $metaDescriptionHi . "क्रॉसबॉडी और शोल्डर बैग" . $metaDescriptionHi2
            ],
            [
                "sub_category_id" => 99585130,
                "title" => "ब्रीफ़केस",
                'lang' => 'hi',
                "meta_title" => "ब्रीफ़केस" . $metaTitleHi,
                "meta_description" => $metaDescriptionHi . "ब्रीफ़केस" . $metaDescriptionHi2
            ],
            [
                "sub_category_id" => 99585131,
                "title" => "सूट वाहक",
                'lang' => 'hi',
                "meta_title" => "सूट वाहक" . $metaTitleHi,
                "meta_description" => $metaDescriptionHi . "सूट वाहक" . $metaDescriptionHi2
            ],
            [
                "sub_category_id" => 96765132,
                "title" => "थैलियों",
                'lang' => 'hi',
                "meta_title" => "थैलियों" . $metaTitleHi,
                "meta_description" => $metaDescriptionHi . "थैलियों" . $metaDescriptionHi2
            ],
            [
                "sub_category_id" => 99585133,
                "title" => "यात्रा बैग और बैकपैक्स",
                'lang' => 'hi',
                "meta_title" => "यात्रा बैग और बैकपैक्स" . $metaTitleHi,
                "meta_description" => $metaDescriptionHi . "यात्रा बैग और बैकपैक्स" . $metaDescriptionHi2
            ],
            [
                "sub_category_id" => 99585134,
                "title" => "यात्रा सहायक उपकरण",
                'lang' => 'hi',
                "meta_title" => "यात्रा सहायक उपकरण" . $metaTitleHi,
                "meta_description" => $metaDescriptionHi . "यात्रा सहायक उपकरण" . $metaDescriptionHi2
            ],
            [
                "sub_category_id" => 96765135,
                "title" => "सामान",
                'lang' => 'hi',
                "meta_title" => "सामान" . $metaTitleHi,
                "meta_description" => $metaDescriptionHi . "सामान" . $metaDescriptionHi2
            ],
            [
                "sub_category_id" => 99585136,
                "title" => "मातृत्व देखभाल",
                'lang' => 'hi',
                "meta_title" => "मातृत्व देखभाल" . $metaTitleHi,
                "meta_description" => $metaDescriptionHi . "मातृत्व देखभाल" . $metaDescriptionHi2
            ],
            [
                "sub_category_id" => 99585137,
                "title" => "बच्चे का फर्नीचर",
                'lang' => 'hi',
                "meta_title" => "बच्चे का फर्नीचर" . $metaTitleHi,
                "meta_description" => $metaDescriptionHi . "बच्चे का फर्नीचर" . $metaDescriptionHi2
            ],
            [
                "sub_category_id" => 96765138,
                "title" => "स्नान और शिशु देखभाल",
                'lang' => 'hi',
                "meta_title" => "स्नान और शिशु देखभाल" . $metaTitleHi,
                "meta_description" => $metaDescriptionHi . "स्नान और शिशु देखभाल" . $metaDescriptionHi2
            ],
            [
                "sub_category_id" => 99585139,
                "title" => "सैंडल एवं फ़्लिप फ़्लॉप",
                'lang' => 'hi',
                "meta_title" => "सैंडल एवं फ़्लिप फ़्लॉप" . $metaTitleHi,
                "meta_description" => $metaDescriptionHi . "सैंडल एवं फ़्लिप फ़्लॉप" . $metaDescriptionHi2
            ],
            [
                "sub_category_id" => 99585140,
                "title" => "स्नीकर्स",
                'lang' => 'hi',
                "meta_title" => "स्नीकर्स" . $metaTitleHi,
                "meta_description" => $metaDescriptionHi . "स्नीकर्स" . $metaDescriptionHi2
            ],
            [
                "sub_category_id" => 96765141,
                "title" => "औपचारिक जूते",
                'lang' => 'hi',
                "meta_title" => "औपचारिक जूते" . $metaTitleHi,
                "meta_description" => $metaDescriptionHi . "औपचारिक जूते" . $metaDescriptionHi2
            ],
            [
                "sub_category_id" => 99585142,
                "title" => "उपकरण, DIY और आउटडोर",
                'lang' => 'hi',
                "meta_title" => "उपकरण, DIY और आउटडोर" . $metaTitleHi,
                "meta_description" => $metaDescriptionHi . "उपकरण, DIY और आउटडोर" . $metaDescriptionHi2
            ],
            [
                "sub_category_id" => 99585143,
                "title" => "रसोई और भोजन",
                'lang' => 'hi',
                "meta_title" => "रसोई और भोजन" . $metaTitleHi,
                "meta_description" => $metaDescriptionHi . "रसोई और भोजन" . $metaDescriptionHi2
            ],
            [
                "sub_category_id" => 96765144,
                "title" => "गृह सजावट",
                'lang' => 'hi',
                "meta_title" => "गृह सजावट" . $metaTitleHi,
                "meta_description" => $metaDescriptionHi . "गृह सजावट" . $metaDescriptionHi2
            ],
            [
                "sub_category_id" => 99585145,
                "title" => "मांस और समुद्री भोजन",
                'lang' => 'hi',
                "meta_title" => "मांस और समुद्री भोजन" . $metaTitleHi,
                "meta_description" => $metaDescriptionHi . "मांस और समुद्री भोजन" . $metaDescriptionHi2
            ],
            [
                "sub_category_id" => 96765147,
                "title" => "स्नैक्स और मिठाई",
                'lang' => 'hi',
                "meta_title" => "स्नैक्स और मिठाई" . $metaTitleHi,
                "meta_description" => $metaDescriptionHi . "स्नैक्स और मिठाई" . $metaDescriptionHi2
            ],
            [
                "sub_category_id" => 99585148,
                "title" => "टीवी सहायक उपकरण",
                'lang' => 'hi',
                "meta_title" => "टीवी सहायक उपकरण" . $metaTitleHi,
                "meta_description" => $metaDescriptionHi . "टीवी सहायक उपकरण" . $metaDescriptionHi2
            ],
            [
                "sub_category_id" => 99585149,
                "title" => "छोटे रसोई के उपकरण",
                'lang' => 'hi',
                "meta_title" => "छोटे रसोई के उपकरण" . $metaTitleHi,
                "meta_description" => $metaDescriptionHi . "छोटे रसोई के उपकरण" . $metaDescriptionHi2
            ],
            [
                "sub_category_id" => 96765150,
                "title" => "गृह व्यवस्था",
                'lang' => 'hi',
                "meta_title" => "गृह व्यवस्था" . $metaTitleHi,
                "meta_description" => $metaDescriptionHi . "गृह व्यवस्था" . $metaDescriptionHi2
            ],





            [
                "sub_category_id" => 64273111,
                "title" => "بلايز",
                "meta_title" => "بلايز" . $metaTitleAr,
                "meta_description" => $metaDescriptionAr . "بلايز" . $metaDescriptionAr2,
                'lang' => 'ar',
            ],
            [
                "sub_category_id" => 73294112,
                "title" => "فساتين",
                "meta_title" => "فساتين" . $metaTitleAr,
                "meta_description" => $metaDescriptionAr . "فساتين" . $metaDescriptionAr2,
                'lang' => 'ar',
            ],
            [
                "sub_category_id" => 96323113,
                "title" => "الجوارب والجوارب",
                "meta_title" => "الجوارب والجوارب" . $metaTitleAr,
                "meta_description" => $metaDescriptionAr . "الجوارب والجوارب" . $metaDescriptionAr2,
                'lang' => 'ar',
            ],
            [
                "sub_category_id" => 96765114,
                "title" => "بانتولون وطماق",
                'lang' => 'ar',
                "meta_title" => "بانتولون وطماق" . $metaTitleAr,
                "meta_description" => $metaDescriptionAr . "بانتولون وطماق" . $metaDescriptionAr2
            ],

            [
                "sub_category_id" => 97373115,
                "title" => "العناية بالشعر للنساء",
                'lang' => 'ar',
                "meta_title" => "العناية بالشعر للنساء" . $metaTitleAr,
                "meta_description" => $metaDescriptionAr . "العناية بالشعر للنساء" . $metaDescriptionAr2
            ],
            [
                "sub_category_id" => 97373116,
                "title" => "العناية الأنثوية",
                'lang' => 'ar',
                "meta_title" => "العناية الأنثوية" . $metaTitleAr,
                "meta_description" => $metaDescriptionAr . "العناية الأنثوية" . $metaDescriptionAr2
            ],

            [
                "sub_category_id" => 97373117,
                "title" => "العناية بالبشرة",
                'lang' => 'ar',
                "meta_title" => "العناية بالبشرة" . $metaTitleAr,
                "meta_description" => $metaDescriptionAr . "العناية بالبشرة" . $metaDescriptionAr2
            ],

            [
                "sub_category_id" => 73294118,
                "title" => "أكياس حبال",
                'lang' => 'ar',
                "meta_title" => "أكياس حبال" . $metaTitleAr,
                "meta_description" => $metaDescriptionAr . "أكياس حبال" . $metaDescriptionAr2
            ],
            [
                "sub_category_id" => 96323119,
                "title" => "حقائب اليد والحقائب الصغيرة",
                'lang' => 'ar',
                "meta_title" => "حقائب اليد والحقائب الصغيرة" . $metaTitleAr,
                "meta_description" => $metaDescriptionAr . "حقائب اليد والحقائب الصغيرة" . $metaDescriptionAr2
            ],
            [
                "sub_category_id" => 96765110,
                "title" => "حقائب اليد",
                'lang' => 'ar',
                "meta_title" => "حقائب اليد" . $metaTitleAr,
                "meta_description" => $metaDescriptionAr . "حقائب اليد" . $metaDescriptionAr2
            ],
            [
                "sub_category_id" => 97373121,
                "title" => "سلاسل المفاتيح",
                'lang' => 'ar',
                "meta_title" => "سلاسل المفاتيح" . $metaTitleAr,
                "meta_description" => $metaDescriptionAr . "سلاسل المفاتيح" . $metaDescriptionAr2
            ],
            [
                "sub_category_id" => 99585122,
                "title" => "نظارات",
                'lang' => 'ar',
                "meta_title" => "نظارات" . $metaTitleAr,
                "meta_description" => $metaDescriptionAr . "نظارات" . $metaDescriptionAr2
            ],
            [
                "sub_category_id" => 96765123,
                "title" => "القبعات والقبعات",
                'lang' => 'ar',
                "meta_title" => "القبعات والقبعات" . $metaTitleAr,
                "meta_description" => $metaDescriptionAr . "القبعات والقبعات" . $metaDescriptionAr2
            ],
            [
                "sub_category_id" => 97373124,
                "title" => "قميص",
                'lang' => 'ar',
                "meta_title" => "قميص" . $metaTitleAr,
                "meta_description" => $metaDescriptionAr . "قميص" . $metaDescriptionAr2
            ],
            [
                "sub_category_id" => 99585125,
                "title" => "السترات والمعاطف",
                'lang' => 'ar',
                "meta_title" => "السترات والمعاطف" . $metaTitleAr,
                "meta_description" => $metaDescriptionAr . "السترات والمعاطف" . $metaDescriptionAr2
            ],
            [
                "sub_category_id" => 96765126,
                "title" => "بنطلون",
                'lang' => 'ar',
                "meta_title" => "بنطلون" . $metaTitleAr,
                "meta_description" => $metaDescriptionAr . "بنطلون" . $metaDescriptionAr2
            ],
            [
                "sub_category_id" => 99585127,
                "title" => "محفظة رجالية",
                'lang' => 'ar',
                "meta_title" => "محفظة رجالية" . $metaTitleAr,
                "meta_description" => $metaDescriptionAr . "محفظة رجالية" . $metaDescriptionAr2
            ],
            [
                "sub_category_id" => 99585128,
                "title" => "حقائب ظهر",
                'lang' => 'ar',
                "meta_title" => "حقائب ظهر" . $metaTitleAr,
                "meta_description" => $metaDescriptionAr . "حقائب ظهر" . $metaDescriptionAr2
            ],
            [
                "sub_category_id" => 96765129,
                "title" => "حقائب الكتف والكتف",
                'lang' => 'ar',
                "meta_title" => "حقائب الكتف والكتف" . $metaTitleAr,
                "meta_description" => $metaDescriptionAr . "حقائب الكتف والكتف" . $metaDescriptionAr2
            ],
            [
                "sub_category_id" => 99585130,
                "title" => "حقائب",
                'lang' => 'ar',
                "meta_title" => "حقائب" . $metaTitleAr,
                "meta_description" => $metaDescriptionAr . "حقائب" . $metaDescriptionAr2
            ],
            [
                "sub_category_id" => 99585131,
                "title" => "حاملات البدلة",
                'lang' => 'ar',
                "meta_title" => "حاملات البدلة" . $metaTitleAr,
                "meta_description" => $metaDescriptionAr . "حاملات البدلة" . $metaDescriptionAr2
            ],
            [
                "sub_category_id" => 96765132,
                "title" => "أكياس",
                'lang' => 'ar',
                "meta_title" => "أكياس" . $metaTitleAr,
                "meta_description" => $metaDescriptionAr . "أكياس" . $metaDescriptionAr2
            ],
            [
                "sub_category_id" => 99585133,
                "title" => "حقائب السفر وحقائب الظهر",
                'lang' => 'ar',
                "meta_title" => "حقائب السفر وحقائب الظهر" . $metaTitleAr,
                "meta_description" => $metaDescriptionAr . "حقائب السفر وحقائب الظهر" . $metaDescriptionAr2
            ],
            [
                "sub_category_id" => 99585134,
                "title" => "اكسسوارات السفر",
                'lang' => 'ar',
                "meta_title" => "اكسسوارات السفر" . $metaTitleAr,
                "meta_description" => $metaDescriptionAr . "اكسسوارات السفر" . $metaDescriptionAr2
            ],
            [
                "sub_category_id" => 96765135,
                "title" => "أمتعة السفر",
                'lang' => 'ar',
                "meta_title" => "أمتعة السفر" . $metaTitleAr,
                "meta_description" => $metaDescriptionAr . "أمتعة السفر" . $metaDescriptionAr2
            ],
            [
                "sub_category_id" => 99585136,
                "title" => "رعاية الأمومة",
                'lang' => 'ar',
                "meta_title" => "رعاية الأمومة" . $metaTitleAr,
                "meta_description" => $metaDescriptionAr . "رعاية الأمومة" . $metaDescriptionAr2
            ],
            [
                "sub_category_id" => 99585137,
                "title" => "أثاث الأطفال",
                'lang' => 'ar',
                "meta_title" => "أثاث الأطفال" . $metaTitleAr,
                "meta_description" => $metaDescriptionAr . "أثاث الأطفال" . $metaDescriptionAr2
            ],
            [
                "sub_category_id" => 96765138,
                "title" => "العناية بالطفل والاستحمام",
                'lang' => 'ar',
                "meta_title" => "العناية بالطفل والاستحمام" . $metaTitleAr,
                "meta_description" => $metaDescriptionAr . "العناية بالطفل والاستحمام" . $metaDescriptionAr2
            ],
            [
                "sub_category_id" => 99585139,
                "title" => "زحافات",
                'lang' => 'ar',
                "meta_title" => "زحافات" . $metaTitleAr,
                "meta_description" => $metaDescriptionAr . "زحافات" . $metaDescriptionAr2
            ],
            [
                "sub_category_id" => 99585140,
                "title" => "أحذية رياضية",
                'lang' => 'ar',
                "meta_title" => "أحذية رياضية" . $metaTitleAr,
                "meta_description" => $metaDescriptionAr . "أحذية رياضية" . $metaDescriptionAr2
            ],
            [
                "sub_category_id" => 96765141,
                "title" => "أحذية رسمية",
                'lang' => 'ar',
                "meta_title" => "أحذية رسمية" . $metaTitleAr,
                "meta_description" => $metaDescriptionAr . "أحذية رسمية" . $metaDescriptionAr2
            ],
            [
                "sub_category_id" => 99585142,
                "title" => "أدوات ، اصنعها بنفسك وخارجها",
                'lang' => 'ar',
                "meta_title" => "أدوات ، اصنعها بنفسك وخارجها" . $metaTitleAr,
                "meta_description" => $metaDescriptionAr . "أدوات ، اصنعها بنفسك وخارجها" . $metaDescriptionAr2
            ],
            [
                "sub_category_id" => 99585143,
                "title" => "المطبخ والطعام",
                'lang' => 'ar',
                "meta_title" => "المطبخ والطعام" . $metaTitleAr,
                "meta_description" => $metaDescriptionAr . "المطبخ والطعام" . $metaDescriptionAr2
            ],
            [
                "sub_category_id" => 96765144,
                "title" => "ديكور المنزل",
                'lang' => 'ar',
                "meta_title" => "ديكور المنزل" . $metaTitleAr,
                "meta_description" => $metaDescriptionAr . "ديكور المنزل" . $metaDescriptionAr2
            ],
            [
                "sub_category_id" => 99585145,
                "title" => "اللحوم والمأكولات البحرية",
                'lang' => 'ar',
                "meta_title" => "اللحوم والمأكولات البحرية" . $metaTitleAr,
                "meta_description" => $metaDescriptionAr . "اللحوم والمأكولات البحرية" . $metaDescriptionAr2
            ],
            [
                "sub_category_id" => 96765147,
                "title" => "سناكس وحلويات",
                'lang' => 'ar',
                "meta_title" => "سناكس وحلويات" . $metaTitleAr,
                "meta_description" => $metaDescriptionAr . "سناكس وحلويات" . $metaDescriptionAr2
            ],
            [
                "sub_category_id" => 99585148,
                "title" => "ملحقات التلفزيون",
                'lang' => 'ar',
                "meta_title" => "ملحقات التلفزيون" . $metaTitleAr,
                "meta_description" => $metaDescriptionAr . "ملحقات التلفزيون" . $metaDescriptionAr2
            ],
            [
                "sub_category_id" => 99585149,
                "title" => "أجهزة مطبخ صغيرة",
                'lang' => 'ar',
                "meta_title" => "أجهزة مطبخ صغيرة" . $metaTitleAr,
                "meta_description" => $metaDescriptionAr . "أجهزة مطبخ صغيرة" . $metaDescriptionAr2
            ],
            [
                "sub_category_id" => 96765150,
                "title" => "التدبير المنزلي",
                'lang' => 'ar',
                "meta_title" => "التدبير المنزلي" . $metaTitleAr,
                "meta_description" => $metaDescriptionAr . "التدبير المنزلي" . $metaDescriptionAr2
            ],







            [
                "sub_category_id" => 64273111,
                "title" => "Hauts",
                "meta_title" => "Hauts" . $metaTitleFr,
                "meta_description" => $metaDescriptionFr . "Hauts" . $metaDescriptionFr2,
                'lang' => 'fr',
            ],
            [
                "sub_category_id" => 73294112,
                "title" => "Robes",
                "meta_title" => "Robes" . $metaTitleFr,
                "meta_description" => $metaDescriptionFr . "Robes" . $metaDescriptionFr2,
                'lang' => 'fr',
            ],
            [
                "sub_category_id" => 96323113,
                "title" => "Chaussettes & Collants",
                "meta_title" => "Chaussettes & Collants" . $metaTitleFr,
                "meta_description" => $metaDescriptionFr . "Chaussettes & Collants" . $metaDescriptionFr2,
                'lang' => 'fr',
            ],
            [
                "sub_category_id" => 96765114,
                "title" => "Pantalon & Leggings",
                'lang' => 'fr',
                "meta_title" => "Pantalon & Leggings" . $metaTitleFr,
                "meta_description" => $metaDescriptionFr . "Pantalon & Leggings" . $metaDescriptionFr2
            ],

            [
                "sub_category_id" => 97373115,
                "title" => "Soins des cheveux pour femmes",
                'lang' => 'fr',
                "meta_title" => "Soins des cheveux pour femmes" . $metaTitleFr,
                "meta_description" => $metaDescriptionFr . "Soins des cheveux pour femmes" . $metaDescriptionFr2
            ],
            [
                "sub_category_id" => 97373116,
                "title" => "Soins féminins",
                'lang' => 'fr',
                "meta_title" => "Soins féminins" . $metaTitleFr,
                "meta_description" => $metaDescriptionFr . "Soins féminins" . $metaDescriptionFr2
            ],

            [
                "sub_category_id" => 97373117,
                "title" => "Soins de la peau",
                'lang' => 'fr',
                "meta_title" => "Soins de la peau" . $metaTitleFr,
                "meta_description" => $metaDescriptionFr . "Soins de la peau" . $metaDescriptionFr2
            ],

            [
                "sub_category_id" => 73294118,
                "title" => "Sacs à bandoulière",
                'lang' => 'fr',
                "meta_title" => "Sacs à bandoulière" . $metaTitleFr,
                "meta_description" => $metaDescriptionFr . "Sacs à bandoulière" . $metaDescriptionFr2
            ],
            [
                "sub_category_id" => 96323119,
                "title" => "Pochettes et mini sacs",
                'lang' => 'fr',
                "meta_title" => "Pochettes et mini sacs" . $metaTitleFr,
                "meta_description" => $metaDescriptionFr . "Pochettes et mini sacs" . $metaDescriptionFr2
            ],
            [
                "sub_category_id" => 96765110,
                "title" => "Sacs à main",
                'lang' => 'fr',
                "meta_title" => "Sacs à main" . $metaTitleFr,
                "meta_description" => $metaDescriptionFr . "Sacs à main" . $metaDescriptionFr2
            ],
            [
                "sub_category_id" => 97373121,
                "title" => "Porte-clés",
                'lang' => 'fr',
                "meta_title" => "Porte-clés" . $metaTitleFr,
                "meta_description" => $metaDescriptionFr . "Porte-clés" . $metaDescriptionFr2
            ],
            [
                "sub_category_id" => 99585122,
                "title" => "Lunettes",
                'lang' => 'fr',
                "meta_title" => "Lunettes" . $metaTitleFr,
                "meta_description" => $metaDescriptionFr . "Lunettes" . $metaDescriptionFr2
            ],
            [
                "sub_category_id" => 96765123,
                "title" => "Chapeaux et Bérets",
                'lang' => 'fr',
                "meta_title" => "Chapeaux et Bérets" . $metaTitleFr,
                "meta_description" => $metaDescriptionFr . "Chapeaux et Bérets" . $metaDescriptionFr2
            ],
            [
                "sub_category_id" => 97373124,
                "title" => "Chemise",
                'lang' => 'fr',
                "meta_title" => "Chemise" . $metaTitleFr,
                "meta_description" => $metaDescriptionFr . "Chemise" . $metaDescriptionFr2
            ],
            [
                "sub_category_id" => 99585125,
                "title" => "Vestes et manteaux",
                'lang' => 'fr',
                "meta_title" => "Vestes et manteaux" . $metaTitleFr,
                "meta_description" => $metaDescriptionFr . "Vestes et manteaux" . $metaDescriptionFr2
            ],
            [
                "sub_category_id" => 96765126,
                "title" => "Pantalon",
                'lang' => 'fr',
                "meta_title" => "Pantalon" . $metaTitleFr,
                "meta_description" => $metaDescriptionFr . "Pantalon" . $metaDescriptionFr2
            ],
            [
                "sub_category_id" => 99585127,
                "title" => "Portefeuille homme",
                'lang' => 'fr',
                "meta_title" => "Portefeuille homme" . $metaTitleFr,
                "meta_description" => $metaDescriptionFr . "Portefeuille homme" . $metaDescriptionFr2
            ],
            [
                "sub_category_id" => 99585128,
                "title" => "sacs à dos",
                'lang' => 'fr',
                "meta_title" => "sacs à dos" . $metaTitleFr,
                "meta_description" => $metaDescriptionFr . "sacs à dos" . $metaDescriptionFr2
            ],
            [
                "sub_category_id" => 96765129,
                "title" => "Sacs à bandoulière et à bandoulière",
                'lang' => 'fr',
                "meta_title" => "Sacs à bandoulière et à bandoulière" . $metaTitleFr,
                "meta_description" => $metaDescriptionFr . "Sacs à bandoulière et à bandoulière" . $metaDescriptionFr2
            ],
            [
                "sub_category_id" => 99585130,
                "title" => "Porte-documents",
                'lang' => 'fr',
                "meta_title" => "Porte-documents" . $metaTitleFr,
                "meta_description" => $metaDescriptionFr . "Porte-documents" . $metaDescriptionFr2
            ],
            [
                "sub_category_id" => 99585131,
                "title" => "Porte-costumes",
                'lang' => 'fr',
                "meta_title" => "Porte-costumes" . $metaTitleFr,
                "meta_description" => $metaDescriptionFr . "Porte-costumes" . $metaDescriptionFr2
            ],
            [
                "sub_category_id" => 96765132,
                "title" => "Sacs",
                'lang' => 'fr',
                "meta_title" => "Sacs" . $metaTitleFr,
                "meta_description" => $metaDescriptionFr . "Sacs" . $metaDescriptionFr2
            ],
            [
                "sub_category_id" => 99585133,
                "title" => "Sacs de voyage et sacs à dos",
                'lang' => 'fr',
                "meta_title" => "Sacs de voyage et sacs à dos" . $metaTitleFr,
                "meta_description" => $metaDescriptionFr . "Sacs de voyage et sacs à dos" . $metaDescriptionFr2
            ],
            [
                "sub_category_id" => 99585134,
                "title" => "Accessoires de voyage",
                'lang' => 'fr',
                "meta_title" => "Accessoires de voyage" . $metaTitleFr,
                "meta_description" => $metaDescriptionFr . "Accessoires de voyage" . $metaDescriptionFr2
            ],
            [
                "sub_category_id" => 96765135,
                "title" => "Bagage",
                'lang' => 'fr',
                "meta_title" => "Bagage" . $metaTitleFr,
                "meta_description" => $metaDescriptionFr . "Bagage" . $metaDescriptionFr2
            ],
            [
                "sub_category_id" => 99585136,
                "title" => "Soins de maternité",
                'lang' => 'fr',
                "meta_title" => "Soins de maternité" . $metaTitleFr,
                "meta_description" => $metaDescriptionFr . "Soins de maternité" . $metaDescriptionFr2
            ],
            [
                "sub_category_id" => 99585137,
                "title" => "Meubles pour enfants",
                'lang' => 'fr',
                "meta_title" => "Meubles pour enfants" . $metaTitleFr,
                "meta_description" => $metaDescriptionFr . "Meubles pour enfants" . $metaDescriptionFr2
            ],
            [
                "sub_category_id" => 96765138,
                "title" => "Soins du bain et du bébé",
                'lang' => 'fr',
                "meta_title" => "Soins du bain et du bébé" . $metaTitleFr,
                "meta_description" => $metaDescriptionFr . "Soins du bain et du bébé" . $metaDescriptionFr2
            ],
            [
                "sub_category_id" => 99585139,
                "title" => "Sandales et tongs",
                'lang' => 'fr',
                "meta_title" => "Sandales et tongs" . $metaTitleFr,
                "meta_description" => $metaDescriptionFr . "Sandales et tongs" . $metaDescriptionFr2
            ],
            [
                "sub_category_id" => 99585140,
                "title" => "Baskets",
                'lang' => 'fr',
                "meta_title" => "Baskets" . $metaTitleFr,
                "meta_description" => $metaDescriptionFr . "Baskets" . $metaDescriptionFr2
            ],
            [
                "sub_category_id" => 96765141,
                "title" => "Chaussures formelles",
                'lang' => 'fr',
                "meta_title" => "Chaussures formelles" . $metaTitleFr,
                "meta_description" => $metaDescriptionFr . "Chaussures formelles" . $metaDescriptionFr2
            ],
            [
                "sub_category_id" => 99585142,
                "title" => "Outils, bricolage et plein air",
                'lang' => 'fr',
                "meta_title" => "Outils, bricolage et plein air" . $metaTitleFr,
                "meta_description" => $metaDescriptionFr . "Outils, bricolage et plein air" . $metaDescriptionFr2
            ],
            [
                "sub_category_id" => 99585143,
                "title" => "Cuisine et salle à manger",
                'lang' => 'fr',
                "meta_title" => "Cuisine et salle à manger" . $metaTitleFr,
                "meta_description" => $metaDescriptionFr . "Cuisine et salle à manger" . $metaDescriptionFr2
            ],
            [
                "sub_category_id" => 96765144,
                "title" => "Décoration de maison",
                'lang' => 'fr',
                "meta_title" => "Décoration de maison" . $metaTitleFr,
                "meta_description" => $metaDescriptionFr . "Décoration de maison" . $metaDescriptionFr2
            ],
            [
                "sub_category_id" => 99585145,
                "title" => "Viande & Fruits de mer",
                'lang' => 'fr',
                "meta_title" => "Viande & Fruits de mer" . $metaTitleFr,
                "meta_description" => $metaDescriptionFr . "Viande & Fruits de mer" . $metaDescriptionFr2
            ],
            [
                "sub_category_id" => 96765147,
                "title" => "Collations et sucreries",
                'lang' => 'fr',
                "meta_title" => "Collations et sucreries" . $metaTitleFr,
                "meta_description" => $metaDescriptionFr . "Collations et sucreries" . $metaDescriptionFr2
            ],
            [
                "sub_category_id" => 99585148,
                "title" => "Accessoires pour téléviseurs",
                'lang' => 'fr',
                "meta_title" => "Accessoires pour téléviseurs" . $metaTitleFr,
                "meta_description" => $metaDescriptionFr . "Accessoires pour téléviseurs" . $metaDescriptionFr2
            ],
            [
                "sub_category_id" => 99585149,
                "title" => "Petits appareils de cuisine",
                'lang' => 'fr',
                "meta_title" => "Petits appareils de cuisine" . $metaTitleFr,
                "meta_description" => $metaDescriptionFr . "Petits appareils de cuisine" . $metaDescriptionFr2
            ],
            [
                "sub_category_id" => 96765150,
                "title" => "Entretien ménager",
                'lang' => 'fr',
                "meta_title" => "Entretien ménager" . $metaTitleFr,
                "meta_description" => $metaDescriptionFr . "Entretien ménager" . $metaDescriptionFr2
            ],


        ];

        $sc1 = SubCategory::where('id', '96765150')->first();
        $sc2 = SubCategory::where('id', '99585143')->first();
        $sc3 = SubCategory::where('id', '99585136')->first();
        $sc4 = SubCategory::where('id', '99585133')->first();



        if (!SubCategoryLang::first() && $sc1 && $sc2 && $sc3 && $sc4) {
            foreach ($items as $i) {
                SubCategoryLang::create($i);
            }
        }


    }
}
