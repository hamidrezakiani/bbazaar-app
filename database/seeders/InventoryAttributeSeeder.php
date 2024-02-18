<?php

namespace Database\Seeders;

use App\Models\InventoryAttribute;
use App\Models\UpdatedInventory;
use Illuminate\Database\Seeder;
use phpseclib3\File\ASN1\Maps\AttributeValue;

class InventoryAttributeSeeder extends Seeder
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
                'id' => 1,
                'inventory_id' => 1,
                'attribute_value_id' => 1
            ],
            [
                'id' => 2,
                'inventory_id' => 2,
                'attribute_value_id' => 1
            ],
            [
                'id' => 3,
                'inventory_id' => 3,
                'attribute_value_id' => 1
            ],
            [
                'id' => 4,
                'inventory_id' => 4,
                'attribute_value_id' => 1
            ],
            [
                'id' => 5,
                'inventory_id' => 5,
                'attribute_value_id' => 1
            ],
            [
                'id' => 6,
                'inventory_id' => 6,
                'attribute_value_id' => 1
            ],
            [
                'id' => 7,
                'inventory_id' => 7,
                'attribute_value_id' => 1
            ],
            [
                'id' => 8,
                'inventory_id' => 8,
                'attribute_value_id' => 1
            ],
            [
                'id' => 9,
                'inventory_id' => 9,
                'attribute_value_id' => 1
            ],
            [
                'id' => 10,
                'inventory_id' => 10,
                'attribute_value_id' => 1
            ],
            [
                'id' => 11,
                'inventory_id' => 11,
                'attribute_value_id' => 1
            ],
            [
                'id' => 12,
                'inventory_id' => 12,
                'attribute_value_id' => 1
            ],
                [
                'id' => 13,
                'inventory_id' => 13,
                'attribute_value_id' => 1
            ],
            [
                'id' => 14,
                'inventory_id' => 14,
                'attribute_value_id' => 1
            ],
            [
                'id' => 15,
                'inventory_id' => 15,
                'attribute_value_id' => 1
            ],
            [
                'id' => 16,
                'inventory_id' => 16,
                'attribute_value_id' => 1
            ],
            [
                'id' => 17,
                'inventory_id' => 17,
                'attribute_value_id' => 1
            ],
            [
                'id' => 18,
                'inventory_id' => 18,
                'attribute_value_id' => 1
            ],
            [
                'id' => 19,
                'inventory_id' => 19,
                'attribute_value_id' => 1
            ],
            [
                'id' => 20,
                'inventory_id' => 20,
                'attribute_value_id' => 1
            ],
            [
                'id' => 21,
                'inventory_id' => 21,
                'attribute_value_id' => 1
            ],
            [
                'id' => 22,
                'inventory_id' => 22,
                'attribute_value_id' => 1
            ],
            [
                'id' => 23,
                'inventory_id' => 23,
                'attribute_value_id' => 1
            ],
            [
                'id' => 24,
                'inventory_id' => 24,
                'attribute_value_id' => 1
            ],
            [
                'id' => 25,
                'inventory_id' => 25,
                'attribute_value_id' => 1
            ],
            [
                'id' => 26,
                'inventory_id' => 26,
                'attribute_value_id' => 1
            ],
            [
                'id' => 27,
                'inventory_id' => 27,
                'attribute_value_id' => 1
            ],
            [
                'id' => 28,
                'inventory_id' => 28,
                'attribute_value_id' => 1
            ],
            [
                'id' => 29,
                'inventory_id' => 29,
                'attribute_value_id' => 1
            ],
            [
                'id' => 30,
                'inventory_id' => 30,
                'attribute_value_id' => 1
            ],
            [
                'id' => 31,
                'inventory_id' => 31,
                'attribute_value_id' => 1
            ],
            [
                'id' => 32,
                'inventory_id' => 32,
                'attribute_value_id' => 1
            ],
            [
                'id' => 33,
                'inventory_id' => 33,
                'attribute_value_id' => 1
            ],
            [
                'id' => 34,
                'inventory_id' => 34,
                'attribute_value_id' => 1
            ],
            [
                'id' => 35,
                'inventory_id' => 35,
                'attribute_value_id' => 1
            ],
            [
                'id' => 36,
                'inventory_id' => 36,
                'attribute_value_id' => 1
            ],
            [
                'id' => 37,
                'inventory_id' => 37,
                'attribute_value_id' => 1
            ],
            [
                'id' => 38,
                'inventory_id' => 38,
                'attribute_value_id' => 1
            ],
            [
                'id' => 39,
                'inventory_id' => 39,
                'attribute_value_id' => 1
            ],
            [
                'id' => 40,
                'inventory_id' => 40,
                'attribute_value_id' => 1
            ],[
                'id' => 41,
                'inventory_id' => 41,
                'attribute_value_id' => 1
            ],
            [
                'id' => 42,
                'inventory_id' => 42,
                'attribute_value_id' => 1
            ],
            [
                'id' => 43,
                'inventory_id' => 43,
                'attribute_value_id' => 1
            ],
            [
                'id' => 44,
                'inventory_id' => 44,
                'attribute_value_id' => 1
            ],
            [
                'id' => 45,
                'inventory_id' => 45,
                'attribute_value_id' => 1
            ],
            [
                'id' => 46,
                'inventory_id' => 46,
                'attribute_value_id' => 1
            ],
            [
                'id' => 47,
                'inventory_id' => 47,
                'attribute_value_id' => 1
            ],
            [
                'id' => 48,
                'inventory_id' => 48,
                'attribute_value_id' => 1
            ],
            [
                'id' => 49,
                'inventory_id' => 49,
                'attribute_value_id' => 1
            ],
            [
                'id' => 50,
                'inventory_id' => 50,
                'attribute_value_id' => 1
            ],[
                'id' => 51,
                'inventory_id' => 51,
                'attribute_value_id' => 1
            ],
            [
                'id' => 52,
                'inventory_id' => 52,
                'attribute_value_id' => 1
            ],
            [
                'id' => 53,
                'inventory_id' => 53,
                'attribute_value_id' => 1
            ]
        ];



        $ui1 = UpdatedInventory::where('id', 1)->first();
        $ui2 = UpdatedInventory::where('id', 12)->first();
        $ui3 = UpdatedInventory::where('id', 18)->first();
        $ui4 = UpdatedInventory::where('id', 22)->first();
        $ui5 = UpdatedInventory::where('id', 46)->first();

        $av = \App\Models\AttributeValue::where('id', 1)->first();


        $ia = InventoryAttribute::first();


        if(!$ia && $ui1 && $ui2 && $ui3 && $ui4 && $ui5 && $av){
            foreach ($items as $i) {
                InventoryAttribute::create($i);
            }
        }



    }
}
