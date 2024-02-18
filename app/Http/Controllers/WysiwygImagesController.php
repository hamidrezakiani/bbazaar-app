<?php

namespace App\Http\Controllers;
use App\Models\CollectionWithProduct;
use App\Models\Helper\ControllerHelper;
use App\Models\Helper\FileHelper;
use App\Models\Helper\Response;
use App\Models\Helper\Utils;
use App\Models\Helper\Validation;
use App\Models\Product;
use App\Models\WysiwygImage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class WysiwygImagesController extends ControllerHelper
{

    public function upload(Request $request)
    {
        try{

            if($request['item_id']){
                if($can = Utils::userCan($this->user, 'product.edit')){
                    return $can;
                }
            }else{
                if($can = Utils::userCan($this->user, 'product.create')){
                    return $can;
                }
            }

            $validate = Validation::wysiwyg_image($request);
            if($validate){
                return response()->json($validate);
            }

            $imageInfo = FileHelper::uploadImage($request['photo'], 'wysiwyg-image', false);
            $url = FileHelper::imageFullUrl($imageInfo['name']);

            if(!is_null($request['product'])){
                $product = json_decode($request['product'], true);
                $productCollectionIds = $product['product_collections'];
                $product['admin_id'] = $request->user()->id;

                if($request['type'] == Config::get('constants.wysiwygImage.PRODUCT_OVERVIEW')){
                    $product['overview'] = $product['overview'] . "<img src='" . $url . "'>";
                }else if($request['type'] == Config::get('constants.wysiwygImage.PRODUCT_DESCRIPTION')){
                    $product['description'] = $product['description'] . "<img src='" . $url . "'>";
                }

                $filtered = array_filter($product, function ($element) {
                    return !is_array($element) && '' !== trim($element);
                });

                unset($filtered['status']);

                $product = Product::create($filtered);
                $request['item_id'] = $product['id'];
                $now = Carbon::now();
                $productCollections = [];
                foreach ($productCollectionIds as $i){
                    array_push($productCollections,
                        [
                            'product_collection_id' => $i,
                            'product_id' => $product['id'],
                            'updated_at' => $now,
                            'created_at' => $now
                        ]
                    );
                }

                CollectionWithProduct::insert($productCollections);

            }else if($request['item_id']){
                // Checking access
                $existing = Product::find($request['item_id']);
                if(!$this->isSuperAdmin && $isOwner = Utils::isDataOwner($this->user, $existing)) {
                    return $isOwner;
                }

                if($request['type'] == Config::get('constants.wysiwygImage.PRODUCT_OVERVIEW')){
                    $product['overview'] = $request['overview'] . "<img src='" . $url . "'>";
                }else if($request['type'] == Config::get('constants.wysiwygImage.PRODUCT_DESCRIPTION')){
                    $product['description'] = $request['description'] . "<img src='" . $url . "'>";
                }
                Product::where('id', $request['item_id'])->update($product);
            }

            $request['image'] = $imageInfo['name'];
            $request['admin_id'] = $request->user()->id;

            $wysiwygImage = WysiwygImage::create($request->all());
            $wysiwygImage['url'] =  $url;

            return response()->json(new Response($request->token, $wysiwygImage));

        } catch (\Exception $ex) {
            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }
    }

    public function delete(Request $request, $image_name)
    {
        try{
            if($can = Utils::userCan($this->user, 'product.edit')){
                return $can;
            }

            FileHelper::deleteFile($image_name);
            $wysiwygImage = WysiwygImage::where('image', $image_name)->get()->first();

            if ($wysiwygImage){
                if(!$this->isSuperAdmin && $isOwner = Utils::isDataOwner($this->user, $wysiwygImage)) {
                    return $isOwner;
                }
                WysiwygImage::where('image', $image_name)->delete();
            }

            return response()->json(new Response($request->token, $wysiwygImage));

        } catch (\Exception $ex) {
            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }




    }
}
