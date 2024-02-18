<?php

namespace App\Http\Controllers\MobileApi;

use App\Http\Controllers\Controller;
use App\Http\Resources\Mobile\UserCardResource;
use App\Http\Resources\Mobile\ShippingPlacesResource;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\GuestUser;
use App\Models\Helper\Response;
use App\Models\Helper\Validation;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\UpdatedInventory;
use App\Models\User;
use App\Models\Cart;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class CartsController extends Controller
{
    public function byUser(Request $request)
    {
        try {
            $lang = $request->header('language');

            $query = Cart::query();

            if ($lang) {

                $query = $query->with('flash_product.shipping_rule.shipping_places');


                $query = $query->with(['updated_inventory.inventory_attributes.attribute_value.attribute' =>
                    function ($query) use ($lang) {
                        $query->leftJoin('attribute_langs as al', function ($join) use ($lang) {
                            $join->on('al.attribute_id', '=', 'attributes.id');
                            $join->where('al.lang', $lang);
                        })
                            ->select('attributes.*', 'al.title');
                    }]);

                $query = $query->with(['updated_inventory.inventory_attributes.attribute_value' =>
                    function ($query) use ($lang) {

                        $query->leftJoin('attribute_value_langs as avl',
                            function ($join) use ($lang) {
                                $join->on('attribute_values.id', '=', 'avl.attribute_value_id');
                                $join->where('avl.lang', $lang);
                            })
                            ->select('attribute_values.*', 'avl.title');
                    }]);

                $query = $query->with(['flash_product' => function ($query) use ($lang) {

                    $query->leftJoin('product_langs as pl', function ($join) use ($lang) {

                        $join->on('pl.product_id', '=', 'products.id');
                        $join->where('pl.lang', $lang);

                    })
                        ->with(['bundle_deal' => function ($query) use ($lang) {

                            $query->leftJoin('bundle_deal_langs as pcl', function ($join) use ($lang) {
                                $join->on('pcl.bundle_deal_id', '=', 'bundle_deals.id');
                                $join->where('pcl.lang', $lang);
                            })
                                ->select('bundle_deals.*', 'pcl.title');

                        }])
                        ->select('products.id', 'products.bundle_deal_id', 'pl.title', 'products.slug',
                            'products.selling', 'products.offered', 'products.tax_rule_id',
                            'products.image', 'products.review_count', 'products.rating', 'products.shipping_rule_id',
                            'flash_sale_products.price',
                            'flash_sales.end_time');
                }]);

            } else {


                $query = $query->with('updated_inventory.inventory_attributes.attribute_value.attribute');
                $query = $query->with('flash_product.shipping_rule.shipping_places');

            }


            if ($request->user('user')) {

                $query = $query->where('user_id', $request->user('user')->id);

            } else if($request->user_token){

                $query = $query->where('user_token', $request->user_token);

            } else {

                return response()->json(Validation::errorLang($lang));

            }



            $query = $query->with('shipping_place');
            $query = $query->select('id', 'product_id', 'user_id', 'inventory_id', 'quantity',
                'selected', 'shipping_place_id', 'shipping_type');
            $data = $query->get();

            /*
                Add User Card Data to Resources in order to have Centralized Data
                and Make Sure user get price by selected Currency
            */
            $total = 0;
            $tax = 0;
            $taxSum = 0;
            $data = $data->map(function($object)use (&$total,$request,&$tax,&$taxSum){
                $flash_product = $object->flash_product;
                unset($object->flash_product);

                $object->flash_product = new \App\Http\Resources\Mobile\UserCardResource($flash_product);


                $quantity = intval($object->quantity);

                $taxSum += number_format((float)$object->flash_product->tax_rules->type == 2 ? ($object->flash_product->tax_rules->price / 100) *  $quantity * $object->flash_product->price($request)
                    : $object->flash_product->price($request) + $object->flash_product->tax_rules->price, 2, '.', '');

                $tax = $object->flash_product->tax_rules->type == 2 ? ($object->flash_product->tax_rules->price / 100) *  $quantity * $object->flash_product->price($request)
                    : $object->flash_product->price($request) + $object->flash_product->tax_rules->price;

                $total += ($object->flash_product->price($request) * $quantity) + $tax ;

                if(isset($object->shipping_place))
                {
                    $shipping_place = $object->shipping_place;
                    unset($object->shipping_place);
                    $object->shipping_place = new \App\Http\Resources\ShippingPlacesResource($shipping_place);
                }
                return $object;
            });

            $response['data'] = $data;
            $response['total'] = number_format((float)$total, 2, '.', '');
            $response['tax'] = $taxSum;
            $response['status'] = 200;
            $response['token'] = null;
            $response['message'] = "";
            return response()->json($response);


//            return response()->json(new Response($request->token, $data));



        } catch (\Exception $ex) {
            return $ex;
//            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }
    }



    public function buyNow(Request $request)
    {
        try {
            $lang = $request->header('language');

            $validate = Validation::cart($request);
            if ($validate) {
                return response()->json($validate);
            }

            $q = Cart::query();

            if ($request->user('user')) {

                $q = $q->where('user_id', $request->user('user')->id);

            } else if($request->user_token){

                $q = $q->where('user_token', $request->user_token);

            } else {

                return response()->json(Validation::errorLang($lang));

            }


            $q = $q->where('product_id', $request->product_id);
            $q = $q->where('inventory_id', $request->inventory_id);
            $existingCart = $q->first();

            if ($existingCart) {
                $inventory = UpdatedInventory::find($request->inventory_id);

                if ($request->quantity > $inventory->quantity) {
                    return response()->json(Validation::error($request->token,
                        __('lang.quantity_exceeds', [], $lang)
                    ));
                }
                Cart::where('id', $existingCart->id)->update([
                    'quantity' => $request->quantity,
                    'selected' => Config::get('constants.status.PUBLIC')
                ]);

                $existingCart->quantity = $request->quantity;
                $cart = $existingCart;

            } else {


                if ($request->user('user')) {

                    $request['user_id'] = $request->user('user')->id;

                } else if($request->user_token){

                    $guestUser = GuestUser::where('user_token', $request->user_token)
                        ->first();

                    if(!$guestUser){
                        GuestUser::create([
                            "user_token" => $request->user_token
                        ]);
                    }
                }



                $cart = Cart::create($request->all());
            }

            Cart::where('selected', Config::get('constants.status.PUBLIC'))
                ->where('id', '!=', $cart->id)
                ->update(['selected' => Config::get('constants.status.PRIVATE')]);

            return response()->json(new Response($request->token, $cart));


        } catch (\Exception $ex) {
            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }
    }


    public function action(Request $request)
    {
        try {

            $lang = $request->header('language');

            $validate = Validation::cart($request);
            if ($validate) {
                return response()->json($validate);
            }

            $q = Cart::query();


            if ($request->user('user')) {

                $q = $q->where('user_id', $request->user('user')->id);

            } else if($request->user_token){

                $q = $q->where('user_token', $request->user_token);

            } else {

                return response()->json(Validation::errorLang($lang));
            }


            $q = $q->where('product_id', $request->product_id);
            $q = $q->where('inventory_id', $request->inventory_id);
            $existingCart = $q->first();

            if ($existingCart) {

                $inventory = UpdatedInventory::find($request->inventory_id);

                if ($existingCart->quantity + $request->quantity > $inventory->quantity) {
                    return response()->json(Validation::error($request->token,
                        __('lang.quantity_exceeds', [], $lang)
                    ));
                }
                Cart::where('id', $existingCart->id)->update([
                    'quantity' => $existingCart->quantity + $request->quantity
                ]);

                $existingCart->quantity = $existingCart->quantity + $request->quantity;
                $cart = $existingCart;

            } else {


                if ($request->user('user')) {

                    $request['user_id'] = $request->user('user')->id;

                } else if($request->user_token){

                    $guestUser = GuestUser::where('user_token', $request->user_token)
                        ->first();

                    if(!$guestUser){
                        GuestUser::create([
                            "user_token" => $request->user_token
                        ]);
                    }
                }


                $cart = Cart::create($request->all());
            }

            return response()->json(new Response($request->token, $cart));

        } catch (\Exception $ex) {
            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }
    }


    public function updateShipping(Request $request)
    {
        try {

            $lang = $request->header('language');

            $validate = Validation::shippingCart($request);

            if ($validate){
                return response()->json($validate);
            }

            $cartArrz = [];

            $cartIds = [];

            foreach ($request->cart as $i) {
                array_push($cartIds, $i['cart']);
                $v['shipping_place_id'] = $i['shipping_place']['id'];
                $v['shipping_type'] = $i['shipping_type'];
                $v['cart'] = $i['cart'];
                array_push($cartArrz, $v);
            }

            $cartError = [];
            $carts = Cart::whereIn('id', $cartIds)
                ->where('selected', Config::get('constants.status.PUBLIC'))
                ->with('product')
                ->with('updated_inventory')
                ->get();

            foreach ($carts as $c) {
                $productErr = [];
                $error = false;

                if ($c->product->status != Config::get('constants.status.PUBLIC')) {
                    array_push($productErr,
                        $c->product->title . __('lang.uncheck_cart', [], $lang));
                    $error = true;
                }
                if ((int)$c->updated_inventory->quantity < 1) {
                    array_push($productErr,
                        $c->product->title . __('lang.stock_out', [], $lang));
                    $error = true;
                }
                if ($error) {
                    $cartError[$c->id] = $productErr;
                }
            }

            if (count($cartError) > 0) {
                return response()->json(Validation::error($request->token, $cartError, 'product'));
            }


            if($request->user('user')) {
                User::where('id', $request->user('user')->id)
                    ->update(['default_address' => $request->selected_address]);

            } else if($request->user_token){

                $userAddress = UserAddress::where('id', $request->selected_address)
                    ->first();


                GuestUser::where('user_token', $request->user_token)
                    ->update([
                        'name' => $userAddress->name,
                        'default_address' => $request->selected_address
                    ]);
            }


            \DB::transaction(function () use ($cartArrz) {
                foreach ($cartArrz as $key => $value) {
                    Cart::where('id', '=', $value['cart'])->update([
                            'shipping_place_id' => $value['shipping_place_id'],
                            'shipping_type' => $value['shipping_type']
                        ]
                    );
                }
            });



            $query = Cart::query();
            $query = $query->with('flash_product.shipping_rule.shipping_places');
            $query = $query->with('updated_inventory.inventory_attributes.attribute_value.attribute');
            $query = $query->with('shipping_place');
            $query = $query->select('id', 'product_id', 'user_id', 'inventory_id', 'quantity',
                'selected', 'shipping_place_id', 'shipping_type');


            if ($request->user('user')) {

                $query = $query->where('user_id', $request->user('user')->id);

            } else if($request->user_token){

                $query = $query->where('user_token', $request->user_token);

            } else {

                return response()->json(Validation::errorLang($lang));
            }



            $data = $query->get();


            $total = 0;
            $tax = 0;
            $taxSum = 0;
            $data = $data->map(function($object)use (&$total,$request,&$tax,&$taxSum){
                $flash_product = $object->flash_product;
                unset($object->flash_product);

                $object->flash_product = new UserCardResource($flash_product);

                $quantity = intval($object->quantity);

                $taxSum += number_format((float)$object->flash_product->tax_rules->type == 2 ? ($object->flash_product->tax_rules->price / 100) *  $quantity * $object->flash_product->price($request)
                    : $object->flash_product->price($request) + $object->flash_product->tax_rules->price, 2, '.', '');

                $tax = $object->flash_product->tax_rules->type == 2 ? ($object->flash_product->tax_rules->price / 100) *  $quantity * $object->flash_product->price($request)
                    : $object->flash_product->price($request) + $object->flash_product->tax_rules->price;

                $total += ($object->flash_product->price($request) * $quantity) + $tax ;
                if(isset($object->shipping_place))
                {
                    $shipping_place = $object->shipping_place;
                    unset($object->shipping_place);
                    $object->shipping_place = new ShippingPlacesResource($shipping_place);
                }
                return $object;
            });



            return response()->json(new Response($request->token, $data));


        } catch (\Exception $ex) {
            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }
    }


    public function changeSelected(Request $request)
    {
        try {

            Cart::whereIn('id', $request->checked)
                ->update(['selected' => 1]);

            Cart::whereIn('id', $request->unchecked)
                ->update(['selected' => 2]);

            return response()->json(new Response('', true));

        } catch (\Exception $ex) {
            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }
    }



    public function delete(Request $request, $id)
    {
        try {

            $lang = $request->header('language');
            $cart = Cart::find($id);

            if (is_null($cart)){
                return response()->json(Validation::nothingFoundLang($lang));
            }


            if ($cart->delete()) {
                return response()->json(new Response($request->token, $cart));
            }

            return response()->json(Validation::error($request->token, null, 'form', $lang));

        } catch (\Exception $ex) {
            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }
    }

}
