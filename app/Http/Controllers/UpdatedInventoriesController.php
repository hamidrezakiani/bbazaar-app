<?php

namespace App\Http\Controllers;

use App\Models\Helper\Response;
use App\Models\Helper\Validation;
use App\Models\InventoryAttribute;
use App\Models\OrderedProduct;
use App\Models\UpdatedInventory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Product;

class UpdatedInventoriesController extends Controller
{
    public function byProduct(Request $request, $productId)
    {
        try {
            $lang = $request->header('language');


            $query = UpdatedInventory::query();

            if($lang){
                $query = $query->with(['inventory_attributes.attribute_value'
                => function ($query) use ($lang) {
                        $query->leftJoin('attribute_value_langs as avl',
                            function ($join) use ($lang) {
                                $join->on('attribute_values.id', '=', 'avl.attribute_value_id');
                                $join->where('avl.lang', $lang);
                            })
                            ->select('attribute_values.*', 'avl.title');
                    }]);
            } else {
                $query = $query->with('inventory_attributes.attribute_value');
            }

            $data = $query->where('product_id', $productId)->get();

            return response()->json(new Response($request->token, $data));

        } catch (\Exception $ex) {
            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }
    }

    public function action(Request $request, $productId)
    {
        try{
            $lang = $request->header('language');


            $validate = Validation::updatedInventory($request, 'inventory');
            if($validate){
                return response()->json($validate);
            }

            $orderedProducts = OrderedProduct::where('product_id', $productId)->get('inventory_id');
            $opArr = array_unique(array_column($orderedProducts->toArray(), 'inventory_id'));

            $reqInventoryIds = array_filter(array_column($request->inventories, 'id'));

            foreach ($reqInventoryIds as $id) {
                $index = array_search($id, $opArr);
                if($index > -1) {
                    unset($opArr[$index]);
                }
            }

            if($opArr) {
                return response()->json(Validation::error(null,
                    __('lang.inventory_used', [], $lang),
                    'inventory'
                ));
            }


            $now = Carbon::now();
            $product = Product::where('id', $productId)->select(['offered', 'selling'])->first();
            $currentPrice = $product->offered > 0 ? $product->offered : $product->selling;

            $data = UpdatedInventory::with('inventory_attributes.attribute_value')
                ->where('product_id', $productId)->get();

            // Preparing the existing inventory attributes for checking
            $deletedInventories = [];
            $existingAttributes = [];
            foreach ($data as $i){
                array_push($deletedInventories, $i->id);
                if(!key_exists($i->id, $existingAttributes)){
                    $existingAttributes[$i->id] = [];
                }
                foreach ($i->inventory_attributes as $j){
                    array_push($existingAttributes[$i->id], $j->attribute_value['id']);
                }
            }

            // Add / edit / delete inventories
            foreach ($request->inventories as $i){

                $price = 0;
                if(count($i['values']) > 0){
                    $price = $currentPrice != $i['price'] ? $i['price'] : 0;
                }

                // Inventory updating
                if(key_exists('id', $i) && $i['id'] && key_exists($i['id'], $existingAttributes)){
                    UpdatedInventory::where('id',  $i['id'])->update([
                        'quantity' => $i['quantity'],
                        'price' => $price
                    ]);
                    // Add / edit / delete inventory attributes
                    $addedAttributes = [];
                    foreach ($i['values'] as $j){
                        // Checking if the attribute value already exists
                        if (($key = array_search($j['id'], $existingAttributes[$i['id']])) !== false) {
                            unset($existingAttributes[$i['id']][$key]);
                        } else {
                            array_push($addedAttributes, [
                                'inventory_id' => $i['id'],
                                'attribute_value_id' => $j['id'],
                                'updated_at' => $now,
                                'created_at' => $now
                            ]);
                        }
                    }

                    InventoryAttribute::whereIn('id', $existingAttributes[$i['id']])->delete();
                    InventoryAttribute::insert($addedAttributes);

                    // Removing the inventory from array to delete the inventory from database
                    if (($key = array_search($i['id'], $deletedInventories)) !== false) {
                        unset($deletedInventories[$key]);
                    }
                } else {
                    // Inventory adding
                    $addedInventory = UpdatedInventory::create([
                        'product_id' => $productId,
                        'quantity' => $i['quantity'],
                        'price' => $price
                    ]);
                    // Adding inventory attributes
                    $addedAttributes = [];
                    foreach ($i['values'] as $j){
                        array_push($addedAttributes, [
                            'inventory_id' => $addedInventory['id'],
                            'attribute_value_id' => $j['id'],
                            'updated_at' => $now,
                            'created_at' => $now
                        ]);
                    }

                    InventoryAttribute::insert($addedAttributes);
                }
            }

            // Deleting inventories
            InventoryAttribute::whereIn('inventory_id', $deletedInventories)->delete();
            UpdatedInventory::whereIn('id', $deletedInventories)->delete();

            $result = UpdatedInventory::with('inventory_attributes.attribute_value')
                ->where('product_id', $productId)
                ->get();

            return response()->json(new Response($request->token, $result));

        } catch (\Exception $ex) {
            return response()->json(Validation::error(null, explode('.', $ex->getMessage())[0], 'inventory'));
        }
    }
}
