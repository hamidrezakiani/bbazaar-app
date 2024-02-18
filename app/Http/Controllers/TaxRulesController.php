<?php

namespace App\Http\Controllers;

use App\Models\Helper\ControllerHelper;
use App\Models\Helper\Response;
use App\Models\Helper\Utils;
use App\Models\Helper\Validation;
use App\Models\Product;
use App\Models\TaxRuleLang;
use App\Models\TaxRules;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class TaxRulesController extends ControllerHelper
{
    public function all(Request $request)
    {
        try {
            $lang = $request->header('language');

            if ($can = Utils::userCan($this->user, 'tax_rule.view')) {
                return $can;
            }

            $query = TaxRules::query();

            $query = $query->orderBy('tax_rules.' . $request->orderby, $request->type);

            if ($this->isVendor) {
                $query = $query->where('admin_id', $this->user->id);
            }



            if ($lang) {
                $query = $query->leftJoin('tax_rule_langs as trl', function ($join) use ($lang) {
                    $join->on('trl.tax_rule_id', '=', 'tax_rules.id');
                    $join->where('trl.lang', $lang);
                });
                $query = $query->select('tax_rules.*', 'trl.title');


                if ($request->q) {
                    $query = $query->where('trl.title', 'LIKE', "%{$request->q}%");
                }
            }else {

                if ($request->q) {
                    $query = $query->where('tax_rules.title', 'LIKE', "%{$request->q}%");
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


            $query = TaxRules::query();

            if ($lang) {
                $query = $query->leftJoin('tax_rule_langs as trl', function ($join) use ($lang) {
                    $join->on('trl.tax_rule_id', '=', 'tax_rules.id');
                    $join->where('trl.lang', $lang);
                });
                $query = $query->select('tax_rules.id', 'trl.title');

            } else {

                $query = $query->select('tax_rules.id', 'tax_rules.title');
            }

            $query = $query->orderBy('tax_rules.created_at');
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

            if ($can = Utils::userCan($this->user, 'tax_rule.view')) {
                return $can;
            }

            $query = TaxRules::query();
            if ($lang) {
                $query = $query->leftJoin('tax_rule_langs as trl', function ($join) use ($lang) {
                    $join->on('trl.tax_rule_id', '=', 'tax_rules.id');
                    $join->where('trl.lang', $lang);
                });
                $query = $query->select('tax_rules.*', 'trl.title');
            }
            $data = $query->find($id);

            if (!$this->isSuperAdmin && $isOwner = Utils::isDataOwner($this->user, $data)) {
                return $isOwner;
            }

            if (is_null($data)) {
                return response()->json(Validation::nothingFoundLang($lang));
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


            $validate = Validation::taxRules($request);
            if ($validate) {
                return response()->json($validate);
            }

            if ($id) {
                if ($can = Utils::userCan($this->user, 'tax_rule.edit')) {
                    return $can;
                }
                $existing = TaxRules::find($id);
                if (!$this->isSuperAdmin && $isOwner = Utils::isDataOwner($this->user, $existing)) {
                    return $isOwner;
                }

                $price = (int)$request->price;

                $filtered = array_filter($request->all(), function ($element) {
                    return '' !== trim($element);
                });

                if ($price == 0) {
                    $filtered['price'] = 0;
                }

                if ($lang) {
                    [$langData, $mainData] = Utils::seperateLangData($filtered, ['title']);
                    TaxRules::where('id', $id)->update($mainData);
                    $existingLang = TaxRuleLang::where('tax_rule_id', $id)->where('lang', $lang)->first();

                    if (!$existingLang) {
                        $langData['tax_rule_id'] = $id;
                        $langData['lang'] = $lang;
                        TaxRuleLang::create($langData);

                    } else {
                        TaxRuleLang::where('id', $existingLang->id)->update($langData);
                    }
                } else {
                    TaxRules::where('id', $id)->update($filtered);
                }



            } else {
                if ($can = Utils::userCan($this->user, 'tax_rule.create')) {
                    return $can;
                }

                $request['admin_id'] = $request->user()->id;



                if ($lang) {
                    [$langData, $mainData] = Utils::seperateLangData($request->all(), ['title']);
                    $taxRule = TaxRules::create($mainData);

                    $langData['tax_rule_id'] = $taxRule->id;
                    $langData['lang'] = $lang;
                    TaxRuleLang::create($langData);
                    $id = $taxRule->id;

                } else {
                    $taxRule = TaxRules::create($request->all());
                    $id = $taxRule->id;
                }
            }


            $query = TaxRules::query();
            if ($lang) {
                $query = $query->leftJoin('tax_rule_langs as trl', function ($join) use ($lang) {
                    $join->on('trl.tax_rule_id', '=', 'tax_rules.id');
                    $join->where('trl.lang', $lang);
                });
                $query = $query->select('tax_rules.*', 'trl.title');
            }
            $data = $query->find($id);



            return response()->json(new Response($request->token, $data));

        } catch (\Exception $ex) {
            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }
    }


    public function delete(Request $request, $id)
    {
        try {

            $lang = $request->header('language');

            if ($can = Utils::userCan($this->user, 'tax_rule.delete')) {
                return $can;
            }

            $taxRules = TaxRules::find($id);

            if (!$this->isSuperAdmin && $isOwner = Utils::isDataOwner($this->user, $taxRules)) {
                return $isOwner;
            }

            if (is_null($taxRules)) {
                return response()->json(Validation::noDataLang($lang));
            }

            $product = Product::where('tax_rule_id', $id)->get()->first();

            if ($product) {
                return response()->json(Validation::error($request->token,
                    __('lang.tax_used', [], $lang)
                ));
            }


            TaxRuleLang::where('tax_rule_id', $id)->delete();

            if ($taxRules->delete()) {
                return response()->json(new Response($request->token, $taxRules));
            }

            return response()->json(Validation::errorTokenLang($request->token, $lang));

        } catch (\Exception $ex) {
            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }


    }
}
