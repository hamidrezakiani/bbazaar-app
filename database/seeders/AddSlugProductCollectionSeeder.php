<?php

namespace Database\Seeders;

use App\Models\ProductCollection;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AddSlugProductCollectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = ProductCollection::get();

        if(count($items) > 0 && (!$items[0]->slug || $items[0]->slug == '')){

            foreach ($items as $i) {

                $slug = Str::slug($i->title);

                $brandBySlug = ProductCollection::where('slug', $slug)->first();
                if($brandBySlug){
                    $slug = $slug . substr(str_shuffle('0123456789'),1, 5);
                }


                ProductCollection::where('id', $i->id)->update(['slug' => $slug]);
            }
        }
    }
}
