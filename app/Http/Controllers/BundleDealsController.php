<?php

namespace App\Http\Controllers;

use App\Models\BundleDeal;
use App\Models\BundleDealLang;
use App\Models\Helper\ControllerHelper;
use App\Models\Helper\Response;
use App\Models\Helper\Utils;
use App\Models\Helper\Validation;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class BundleDealsController extends ControllerHelper
{
    public function all(Request $request)
    {

        try {
            $lang = $request->header('language');

            if ($can = Utils::userCan($this->user, 'bundle_deal.view')) {
                return $can;
            }


            $query = BundleDeal::query();
            $query = $query->orderBy('bundle_deals.' . $request->orderby, $request->type);


            if ($this->isVendor) {
                $query = $query->where('admin_id', $this->user->id);
            }


            if ($lang) {
                $query = $query->leftJoin('bundle_deal_langs as pcl', function ($join) use ($lang) {
                    $join->on('pcl.bundle_deal_id', '=', 'bundle_deals.id');
                    $join->where('pcl.lang', $lang);
                });
                $query = $query->select('bundle_deals.*', 'pcl.title');

                if ($request->q) {
                    $query = $query->where('pcl.title', 'LIKE', "%{$request->q}%");
                }

            } else {
                if ($request->q) {
                    $query = $query->where('bundle_deals.title', 'LIKE', "%{$request->q}%");
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


            $query = BundleDeal::query();

            if ($lang) {
                $query = $query->leftJoin('bundle_deal_langs as trl', function ($join) use ($lang) {
                    $join->on('trl.bundle_deal_id', '=', 'bundle_deals.id');
                    $join->where('trl.lang', $lang);
                });
                $query = $query->select('bundle_deals.id', 'trl.title');

            } else {

                $query = $query->select('bundle_deals.id', 'bundle_deals.title');
            }

            $query = $query->orderBy('bundle_deals.created_at');
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

            if ($can = Utils::userCan($this->user, 'bundle_deal.view')) {
                return $can;
            }

            $query = BundleDeal::query();
            if ($lang) {
                $query = $query->leftJoin('bundle_deal_langs as trl', function ($join) use ($lang) {
                    $join->on('trl.bundle_deal_id', '=', 'bundle_deals.id');
                    $join->where('trl.lang', $lang);
                });
                $query = $query->select('bundle_deals.*', 'trl.title');
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

            $validate = Validation::bundleDeals($request);
            if ($validate) {
                return response()->json($validate);
            }

            if ($id) {
                if ($can = Utils::userCan($this->user, 'bundle_deal.edit')) {
                    return $can;
                }

                $existing = BundleDeal::find($id);
                if (!$this->isSuperAdmin && $isOwner = Utils::isDataOwner($this->user, $existing)) {
                    return $isOwner;
                }

                $filtered = array_filter($request->all(), function ($element) {
                    return '' !== trim($element);
                });


                if ($lang) {
                    [$langData, $mainData] = Utils::seperateLangData($filtered, ['title']);
                    BundleDeal::where('id', $id)->update($mainData);
                    $existingLang = BundleDealLang::where('bundle_deal_id', $id)
                        ->where('lang', $lang)->first();

                    if (!$existingLang) {
                        $langData['bundle_deal_id'] = $id;
                        $langData['lang'] = $lang;
                        BundleDealLang::create($langData);

                    } else {

                        BundleDealLang::where('id', $existingLang->id)->update($langData);
                    }
                } else {
                    BundleDeal::where('id', $id)->update($filtered);
                }


            } else {
                if ($can = Utils::userCan($this->user, 'bundle_deal.create')) {
                    return $can;
                }
                $request['admin_id'] = $request->user()->id;



                if ($lang) {
                    [$langData, $mainData] = Utils::seperateLangData($request->all(), ['title']);
                    $bundleDeal = BundleDeal::create($mainData);

                    $langData['bundle_deal_id'] = $bundleDeal->id;
                    $langData['lang'] = $lang;
                    BundleDealLang::create($langData);
                    $id = $bundleDeal->id;

                } else {
                    $bundleDeal = BundleDeal::create($request->all());
                    $id = $bundleDeal->id;
                }
            }


            $query = BundleDeal::query();
            if ($lang) {
                $query = $query->leftJoin('bundle_deal_langs as trl', function ($join) use ($lang) {
                    $join->on('trl.bundle_deal_id', '=', 'bundle_deals.id');
                    $join->where('trl.lang', $lang);
                });
                $query = $query->select('bundle_deals.*', 'trl.title');
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
            if ($can = Utils::userCan($this->user, 'bundle_deal.delete')) {
                return $can;
            }
            $bundleDeal = BundleDeal::find($id);

            if (!$this->isSuperAdmin && $isOwner = Utils::isDataOwner($this->user, $bundleDeal)) {
                return $isOwner;
            }

            if (is_null($bundleDeal)) {
                return response()->json(Validation::noDataLang($lang));
            }

            $product = Product::where('bundle_deal_id', $id)->get()->first();

            if ($product) {
                return response()->json(Validation::error($request->token,
                    __('lang.unable_delete', ['message' => __('lang.deal_used', [], $lang)], $lang)
                ));
            }

            BundleDealLang::where('bundle_deal_id', $id)->delete();

            if ($bundleDeal->delete()) {
                return response()->json(new Response($request->token, $bundleDeal));
            }


            return response()->json(Validation::error($request->token, null, 'form', $lang));


        } catch (\Exception $ex) {
            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }


    }
}
