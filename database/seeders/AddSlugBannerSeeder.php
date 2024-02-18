<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AddSlugBannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $banner = Banner::get();

        if(count($banner) > 0 && (!$banner[0]->slug || $banner[0]->slug == '')){



            foreach ($banner as $i) {

                $slug = Str::slug($i->title);

                $brandBySlug = Banner::where('slug', $slug)->first();
                if($brandBySlug){
                    $slug = $slug . substr(str_shuffle('0123456789'),1, 5);
                }


                Banner::where('id', $i->id)->update(['slug' => $slug]);
            }
        }
    }
}
