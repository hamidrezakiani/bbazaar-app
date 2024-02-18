<?php

namespace App\Http\Controllers;

use App\Models\Helper\ControllerHelper;
use App\Models\Helper\Response;
use App\Models\Helper\Utils;
use App\Models\Helper\Validation;
use App\Models\OrderedProduct;
use App\Models\Product;
use App\Models\ShippingPlace;
use App\Models\ShippingRule;
use App\Models\ShippingRuleLang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class ShippingRulesController extends ControllerHelper
{
    public function all(Request $request)
    {
        try {
            $lang = $request->header('language');

            if ($can = Utils::userCan($this->user, 'shipping_rule.view')) {
                return $can;
            }

            $query = ShippingRule::with('shipping_places');
            $query = $query->orderBy('shipping_rules.' . $request->orderby, $request->type);

            if ($this->isVendor) {
                $query = $query->where('admin_id', $this->user->id);
            }


            if ($lang) {
                $query = $query->leftJoin('shipping_rule_langs as srl', function ($join) use ($lang) {
                    $join->on('srl.shipping_rule_id', '=', 'shipping_rules.id');
                    $join->where('srl.lang', $lang);
                });
                $query = $query->select('shipping_rules.*', 'srl.title');


                if ($request->q) {
                    $query = $query->where('srl.title', 'LIKE', "%{$request->q}%");
                }
            } else {

                if ($request->q) {
                    $query = $query->where('shipping_rules.title', 'LIKE', "%{$request->q}%");
                }
            }


            $data = $query->paginate(Config::get('constants.api.PAGINATION'));

            foreach ($data as $item) {
                $item['created'] = Utils::formatDate($item->created_at);
            }

            return response()->json(new Response($request->token, $data));

        } catch (\Exception $ex) {
            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }
    }

    public function allList(Request $request)
    {
        try {
            $lang = $request->header('language');


            $query = ShippingRule::query();

            if ($lang) {
                $query = $query->leftJoin('shipping_rule_langs as srl', function ($join) use ($lang) {
                    $join->on('srl.shipping_rule_id', '=', 'shipping_rules.id');
                    $join->where('srl.lang', $lang);
                });
                $query = $query->select('shipping_rules.id', 'srl.title');

            } else {

                $query = $query->select('shipping_rules.id', 'shipping_rules.title');
            }

            $query = $query->orderBy('shipping_rules.created_at');
            $data = $query->get();

            return response()->json(new Response($request->token, $data));

        } catch (\Exception $ex) {
            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }
    }

    public function find(Request $request, $id)
    {

        try {
            $lang = $request->header('language');


            if ($can = Utils::userCan($this->user, 'shipping_rule.view')) {
                return $can;
            }

            $query = ShippingRule::with('shipping_places');

            if ($lang) {
                $query = $query->leftJoin('shipping_rule_langs as srl', function ($join) use ($lang) {
                    $join->on('srl.shipping_rule_id', '=', 'shipping_rules.id');
                    $join->where('srl.lang', $lang);
                });
                $query = $query->select('shipping_rules.*', 'srl.title');
            }
            $data = $query->find($id);

            if (!$this->isSuperAdmin && $isOwner = Utils::isDataOwner($this->user, $data)) {
                return $isOwner;
            }

            if (is_null($data)) {
                return response()->json(Validation::noDataLang($lang));
            }

            return response()->json(new Response($request->token, $data));


        } catch (\Exception $ex) {
            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }
    }


    public function action(Request $request, $id = null)
    {

        try {

            $lang = $request->header('language');

            $validate = Validation::shippingRule($request);
            if ($validate) {
                return response()->json($validate);
            }

            $activeShippingRule = array_filter($request->shipping_places, function ($element) {
                return !key_exists('deleted', $element) || !$element['deleted'];
            });

            if (count($activeShippingRule) < 1) {
                return response()->json(Validation::error($request->token,
                    __('lang.shipping_least', [], $lang)
                ));
            }

            if ($id) {
                if ($can = Utils::userCan($this->user, 'shipping_rule.edit')) {
                    return $can;
                }

                $existing = ShippingRule::find($id);
                if (!$this->isSuperAdmin && $isOwner = Utils::isDataOwner($this->user, $existing)) {
                    return $isOwner;
                }

                $filtered = array_filter($request->all(), function ($element) {
                    return !is_array($element) && '' !== trim($element);
                });



                if ($lang) {
                    [$langData, $mainData] = Utils::seperateLangData($filtered, ['title']);
                    ShippingRule::where('id', $id)->update($mainData);
                    $existingLang = ShippingRuleLang::where('shipping_rule_id', $id)->where('lang', $lang)->first();

                    if (!$existingLang) {
                        $langData['shipping_rule_id'] = $id;
                        $langData['lang'] = $lang;
                        ShippingRuleLang::create($langData);

                    } else {
                        ShippingRuleLang::where('id', $existingLang->id)->update($langData);
                    }
                } else {
                    ShippingRule::where('id', $id)->update($filtered);
                }




            } else {
                if ($can = Utils::userCan($this->user, 'shipping_rule.create')) {
                    return $can;
                }

                $request['admin_id'] = $request->user()->id;


                if ($lang) {
                    [$langData, $mainData] = Utils::seperateLangData($request->all(), ['title']);
                    $shippingRule = ShippingRule::create($mainData);

                    $langData['shipping_rule_id'] = $shippingRule->id;
                    $langData['lang'] = $lang;
                    ShippingRuleLang::create($langData);
                    $id = $shippingRule->id;

                } else {
                    $shippingRule = ShippingRule::create($request->all());
                    $id = $shippingRule->id;
                }
            }

            $data = ['add' => [], 'delete' => []];
            foreach ($request->shipping_places as $value) {

                if (!key_exists('id', $value) || (key_exists('id', $value) && '' === trim($value['id']))) {
                    array_push($data['add'],
                        [
                            "country" => $value['country'],
                            "day_needed" => $value['day_needed'],
                            "pickup_point" => $value['pickup_point'],
                            "pickup_price" => $value['pickup_price'],
                            "price" => $value['price'],
                            "shipping_rule_id" => $id,
                            "state" => $value['state'],
                            'admin_id' => $request->user()->id
                        ]
                    );
                } else if ((key_exists('id', $value) && '' == !trim($value['id'])) &&
                    key_exists('deleted', $value) && $value['deleted']) {


                    $orderedProduct = OrderedProduct::where('shipping_place_id', $value['id'])->first();
                    if ($orderedProduct) {
                        return response()->json(Validation::error($request->token,
                            __('lang.place_delete', [], $lang)
                        ));
                    }


                    array_push($data['delete'], $value['id']);
                } else if (key_exists('id', $value)) {
                    ShippingPlace::where('id', $value['id'])
                        ->update([
                            "country" => $value['country'],
                            "day_needed" => $value['day_needed'],
                            "pickup_point" => $value['pickup_point'],
                            "pickup_price" => $value['pickup_price'],
                            "price" => $value['price'],
                            "state" => $value['state'],
                        ]);
                }
            }

            ShippingPlace::insert($data['add']);
            ShippingPlace::whereIn('id', $data['delete'])->delete();

            $query = ShippingRule::with('shipping_places');

            if ($lang) {
                $query = $query->leftJoin('shipping_rule_langs as srl', function ($join) use ($lang) {
                    $join->on('srl.shipping_rule_id', '=', 'shipping_rules.id');
                    $join->where('srl.lang', $lang);
                });
                $query = $query->select('shipping_rules.*', 'srl.title');
            }
            $attr = $query->find($id);

            return response()->json(new Response($request->token, $attr));

        } catch (\Exception $ex) {
            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }
    }

    public function delete(Request $request, $id)
    {

        try {

            $lang = $request->header('language');

            if ($can = Utils::userCan($this->user, 'shipping_rule.delete')) {
                return $can;
            }
            $shippingRules = ShippingRule::find($id);

            if (!$this->isSuperAdmin && $isOwner = Utils::isDataOwner($this->user, $shippingRules)) {
                return $isOwner;
            }

            if (is_null($shippingRules)) {
                return response()->json(Validation::nothingFoundLang($lang));
            }

            $product = Product::where('shipping_rule_id', $id)->get()->first();

            if ($product) {
                return response()->json(Validation::error($request->token,
                    __('lang.shipping_delete', [], $lang)
                ));
            }

            ShippingPlace::where('shipping_rule_id', $id)->delete();

            ShippingRuleLang::where('shipping_rule_id', $id)->delete();

            if ($shippingRules->delete()) {
                return response()->json(new Response($request->token, $shippingRules));
            }

            return response()->json(Validation::errorTokenLang($request->token, $lang));


        } catch (\Exception $ex) {
            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }


    }
}
