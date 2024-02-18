<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use App\Models\Helper\Response;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Inventory;
use App\Models\Helper\Validation;

class InventoriesController extends Controller
{

    public function find(Request $request, $productId)
    {

        $lang = $request->header('language');


        $all_attributes = Attribute::with('values')->orderBy('created_at')->get();

        $attr_arr = [];
        foreach ($all_attributes as $attr){
            foreach ($attr->values as $val){
                $attr_arr[$attr->id . '-' . $val->id] = $val->title;
            }
        }

        $inventory = Inventory::where('product_id', $productId)->get();

        if (is_null($inventory))
            return response()->json(Validation::nothingFoundLang($lang));


        if(count($inventory) > 0){
            foreach ($inventory as $inv){
                if($inv->attributes){
                    $title = [];
                    foreach (explode(',', $inv->attributes) as $attr_val){
                        if(array_key_exists($attr_val, $attr_arr)){
                            array_push($title, $attr_arr[$attr_val]);
                        }
                    }

                    $inv['title'] = join('+', $title);
                }
            }
        }

        $res['inventory'] = $inventory;
        $res['values'] = $attr_arr;
        $res['attributes'] = $all_attributes;

        return response()->json(new Response($request->token, $res));
    }

    public function action(Request $request)
    {
        $responseObj = [];

        if(isset($request['quantity'])){

            $validate = Validation::inventoryQuantity($request);
            if($validate)
                return response()->json($validate);

            $inventory = Inventory::where('product_id', request('product_id'))->get();

            foreach ($inventory as $i){
                Inventory::where('id', $i['id'])->delete();
            }

            $item['quantity'] = request('quantity');
            $item['admin_id'] = $request->user()->id;
            $item['product_id'] = request('product_id');

            Inventory::create($item);
            array_push($responseObj, $item);

        }else{

            $validate = Validation::inventoryValue($request);
            if($validate)
                return response()->json($validate);

            $inventory = Inventory::where('product_id', request('product_id'))->get();

            $inventoryArr = [];
            $duplicateInventoryArr = [];
            foreach ($inventory as $i){
                if(array_key_exists($i['attributes'], $inventoryArr))
                    array_push($duplicateInventoryArr, $i);
                else
                    $inventoryArr[$i['attributes']] = $i;
            }

            $attributesFromRequest = [];
            $invalid_attr = false;

            foreach (request('attributes') as $item){
                if(!$item['attributes']){
                    $invalid_attr = true;
                    continue;
                }

                if(in_array($item['attributes'], $attributesFromRequest))
                    continue;

                array_push($attributesFromRequest, $item['attributes']);
                array_push($responseObj, $item);

                $qtyValidate = Validation::quantityValidation($item, $request->token);
                if($qtyValidate)
                    return response()->json($qtyValidate);

                if(array_key_exists($item['attributes'], $inventoryArr)){

                    if ($item['quantity'] != $inventoryArr[$item['attributes']]['quantity']
                    || $item['price'] != $inventoryArr[$item['attributes']]['price']){

                        $update_obj['quantity'] = $item['quantity'];
                        $update_obj['price'] = $item['price'];
                        Inventory::where('id', $inventoryArr[$item['attributes']]['id'])->update($update_obj);
                    }
                    unset($inventoryArr[$item['attributes']]);

                } else {
                    $item['admin_id'] = $request->user()->id;
                    $item['product_id'] = request('product_id');
                    Inventory::create($item);
                }
            }

            if(!$invalid_attr){
                foreach ($inventoryArr as $i){
                    Inventory::where('product_id', $i['product_id'])->where('attributes', $i['attributes'])->delete();
                }

                foreach ($duplicateInventoryArr as $i){
                    Inventory::where('id', $i['id'])->delete();
                }
            }
        }


        if(request('product_id')){
            Product::where('id', request('product_id'))->update(array('attribute' => request('attribute_ids')));
        }

        return response()->json(new Response($request->token, $responseObj));
    }
}
