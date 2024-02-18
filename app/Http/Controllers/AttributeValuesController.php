<?php

namespace App\Http\Controllers;

use App\Models\Helper\ControllerHelper;
use App\Models\InventoryAttribute;
use Illuminate\Http\Request;
use App\Models\AttributeValue;
use App\Models\Helper\Response;
use App\Models\Helper\Utils;
use App\Models\Helper\Validation;
use Illuminate\Support\Facades\Config;


class AttributeValuesController extends ControllerHelper
{
    public function all(Request $request)
    {
        try {

            if($can = Utils::userCan($this->user, 'attribute.view')){
                return $can;
            }

            $query = AttributeValue::query()
                ->orderBy($request->orderby, $request->type);

            if($request->q){
                $query = $query->where('title', 'LIKE', "%{$request->q}%");
            }

            if($this->isVendor) {
                $query = $query->where('admin_id', $this->user->id);
            }
            $data = $query->paginate(Config::get('constants.api.PAGINATION'));


            foreach ($data as $item){
                $item['created'] = Utils::formatDate($item->created_at);
            }
            return response()->json(new Response($request->token, $data));


        } catch (\Exception $ex) {
            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }
    }



    public function find(Request $request, $id)
    {
        try {

            $lang = $request->header('language');

            if($can = Utils::userCan($this->user, 'attribute.view')){
                return $can;
            }

            $attributeValue = AttributeValue::find($id);


            if(!$this->isSuperAdmin && $isOwner = Utils::isDataOwner($this->user, $attributeValue)) {
                return $isOwner;
            }

            if (is_null($attributeValue)){
                return response()->json(Validation::nothingFoundLang($lang));
            }

            $attributeValue['created'] = Utils::formatDate($attributeValue->created_at);

            return response()->json(new Response($request->token, $attributeValue));


        } catch (\Exception $ex) {
            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }
    }


    public function action(Request $request, AttributeValue $attributeValue)
    {
        try {


            $validate = Validation::attributeValue($request);
            if($validate){
                return response()->json($validate);
            }

            if($attributeValue->id){
                if($can = Utils::userCan($this->user, 'attribute.edit')){
                    return $can;
                }

                $existing = AttributeValue::find($attributeValue->id);
                if(!$this->isSuperAdmin && $isOwner = Utils::isDataOwner($this->user, $existing)) {
                    return $isOwner;
                }


                $filtered = array_filter($request->all(), function ($element) {
                    return '' !== trim($element);
                });

                $attributeValue->update(array_filter($filtered));

            }else{
                if($can = Utils::userCan($this->user, 'attribute.create')){
                    return $can;
                }

                $request['image'] = Config::get('constants.media.DEFAULT_IMAGE');
                $request['admin_id'] = $request->user()->id;
                $attributeValue = AttributeValue::create($request->all());
            }

            $attributeValue['created'] = Utils::formatDate($attributeValue->created_at);

            return response()->json(new Response($request->token, $attributeValue));


        } catch (\Exception $ex) {
            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }
    }



    public function delete(Request $request, $id)
    {
        try {

            $lang = $request->header('language');


            if($can = Utils::userCan($this->user, 'attribute.delete')){
                return $can;
            }

            $attributeValue = AttributeValue::find($id);

            if(!$this->isSuperAdmin && $isOwner = Utils::isDataOwner($this->user, $attributeValue)) {
                return $isOwner;
            }

            if (is_null($attributeValue)){
                return response()->json(Validation::nothingFoundLang());
            }

            $inventoryAttribute = InventoryAttribute::where('attribute_value_id', $attributeValue->id)
                ->get()->first();;

            if($inventoryAttribute){
                return response()->json(Validation::error($request->token,
                    __('lang.unable_delete', ['message'=> __('lang.delete_attribute', [], $lang)], $lang)
                ));
            }

            if ($attributeValue->delete()){
                return response()->json(new Response($request->token, $attributeValue));
            }

            return response()->json(Validation::error($request->token, null, 'form', $lang));

        } catch (\Exception $ex) {
            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }



    }
}
