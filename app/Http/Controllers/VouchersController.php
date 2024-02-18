<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Helper\ControllerHelper;
use App\Models\Helper\Response;
use App\Models\Helper\Utils;
use App\Models\Helper\Validation;
use App\Models\Order;
use App\Models\Setting;
use App\Models\Voucher;
use App\Models\VoucherLang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use function Webmozart\Assert\Tests\StaticAnalysis\float;

class VouchersController extends ControllerHelper
{
    public function validity(Request $request)
    {
        try {
            $lang = $request->header('language');
            $currency = $request->header('currency');
            $validate = Validation::voucherValidity($request);
            if ($validate) {
                return response()->json($validate);
            }

            $voucher = Voucher::where('code', $request->voucher)
                ->where('status', Config::get('constants.status.PUBLIC'))
                ->first();

            if (is_null($voucher)) {
                return response()->json(Validation::noDataLang($lang));
            }

            $q = Cart::with('product_inner');
            if ($request->user('user')) {

                $q = $q->where('user_id', $request->user('user')->id);

            } else if($request->user_token){

                $q = $q->where('user_token', $request->user_token);

            } else {

                return response()->json(Validation::errorLang($lang));
            }

            $existingCart = $q->with('shipping_place')
                ->where('selected', Config::get('constants.status.PUBLIC'))
                ->with('updated_inventory')
                ->get();

            $totalPriceWithoutShipping = 0;
            foreach ($existingCart as $key => $cart) {
                if ($cart->shipping_place_id && !is_null($cart->product_inner)) {
                    // Selling price calculation
                    $inventoryPrice = (float)$cart->updated_inventory->price;
                    $selling = (float)$cart->product_inner->selling;
                    $offered = (float)$cart->product_inner->offered;
                    $flashPrice = 0;
                    if (!is_null($cart->product_inner->end_time)) {
                        $flashPrice = (float)$cart->product_inner->price;
                    }
                    if ($inventoryPrice > 0) {
                        $currentPrice = $inventoryPrice;
                    } else if ($flashPrice > 0) {
                        $currentPrice = $flashPrice;
                    } else if ($flashPrice > 0) {
                        $currentPrice = $offered;
                    } else {
                        $currentPrice = $selling;
                    }
                    // Bundle calculation
                    $bundleQtyOffer = 0;
                    $bundleDeal = $cart->product_inner->bundle_deal;
                    if ($bundleDeal) {
                        if ($cart->quantity >= $bundleDeal->buy) {
                            $bundleQtyOffer = $bundleDeal->free;
                        }
                    }
                    $totalPriceWithoutShipping +=
                        (float)$currentPrice * ((int)$cart->quantity - $bundleQtyOffer);
                }
            }
            $totalPriceWithoutShipping = $request->header('currency') == "AFN" ? $totalPriceWithoutShipping
                : floatval(number_format($totalPriceWithoutShipping / getDollar()->price , 2));
            $min_spend = $request->header('currency') == 'AFN' ? $voucher->min_spend :
                floatval(number_format($voucher->min_spend / getDollar()->price , 2));
            if ($totalPriceWithoutShipping < $min_spend) {
                $setting = Setting::select('currency', 'currency_icon')->first();
                return response()->json(Validation::error(null,
                    __('lang.least_spend', ['amount' => $setting->currency_icon . $min_spend], $lang)
                ));
            }


            $totalOrdered = Order::where('voucher_id', $voucher->id)->count();


            if ($totalOrdered >= $voucher->usage_limit) {
                return response()->json(Validation::error(null,
                    __('lang.limit_exceeded', [], $lang)
                ));
            }


            $OrderedByUserQuery =  Order::where('voucher_id', $voucher->id);
            if ($request->user('user')) {

                $OrderedByUserQuery = $OrderedByUserQuery->where('user_id', $request->user('user')->id);

            } else if($request->user_token){

                $OrderedByUserQuery = $OrderedByUserQuery->where('user_token', $request->user_token);

            } else {

                return response()->json(Validation::errorLang($lang));
            }

            $totalOrderedByUser = $OrderedByUserQuery->count();


            if ($totalOrderedByUser >= $voucher->limit_per_customer) {
                return response()->json(Validation::error(null,
                    __('lang.maximum_time', [], $lang)
                ));
            }

            $start = new Carbon($voucher->start_time);
            $end = new Carbon($voucher->end_time);
            $now = Carbon::now();


            if ($start < $now && $now < $end) {
                if ((int)$voucher->type === (int)Config::get('constants.priceType.FLAT')) {
                    $offered = $voucher->price;
                } else {
                    $offered = number_format(
                        (float)($voucher->price * $totalPriceWithoutShipping) / 100,
                        2, '.', ''
                    );
                }
                if (!is_null($voucher->capped_price) && $offered > $voucher->capped_price) {
                    $offered = (int)$voucher->capped_price;
                }
                $offered = $currency == 'AFN' ? $offered :
                    floatval(number_format($offered / getDollar()->price , 2));
                return response()->json(new Response($request->token,
                    ['offered' => $offered, 'voucher' => $request->voucher]));
            }

            return response()->json(Validation::error(null,
                __('lang.voucher_expired', [], $lang)
            ));
        } catch (\Exception $ex) {
            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }
    }

    public function all(Request $request)
    {
        try {
            $lang = $request->header('language');

            if ($can = Utils::userCan($this->user, 'voucher.view')) {
                return $can;
            }

            $query = Voucher::query();
            $query = $query->orderBy('vouchers.' . $request->orderby, $request->type);

            if ($this->isVendor) {
                $query = $query->where('admin_id', $this->user->id);
            }


            if ($lang) {
                $query = $query->leftJoin('voucher_langs as pcl', function ($join) use ($lang) {
                    $join->on('pcl.voucher_id', '=', 'vouchers.id');
                    $join->where('pcl.lang', $lang);
                });
                $query = $query->select('vouchers.*', 'pcl.title');

                if ($request->q) {
                    $query = $query->where('pcl.title', 'LIKE', "%{$request->q}%");
                }

            } else {

                if ($request->q) {
                    $query = $query->where('vouchers.title', 'LIKE', "%{$request->q}%");
                }
            }


            $data = $query->paginate(Config::get('constants.api.PAGINATION'));

            if ($request->time_zone) {
                foreach ($data as $item) {
                    $item['created'] = Utils::formatDate(Utils::convertTimeToUSERzone($item->created_at, $request->time_zone));
                    $item['start_time'] = Utils::convertTimeToUSERzone($item->start_time, $request->time_zone);
                    $item['end_time'] = Utils::convertTimeToUSERzone($item->end_time, $request->time_zone);
                }
            } else {
                foreach ($data as $item) {
                    $item['created'] = Utils::formatDate($item->created_at);
                    $item['start_time'] = $item->start_time;
                    $item['end_time'] = $item->end_time;
                }
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

            if ($can = Utils::userCan($this->user, 'voucher.view')) {
                return $can;
            }

            $query = Voucher::query();
            if ($lang) {
                $query = $query->leftJoin('voucher_langs as trl', function ($join) use ($lang) {
                    $join->on('trl.voucher_id', '=', 'vouchers.id');
                    $join->where('trl.lang', $lang);
                });
                $query = $query->select('vouchers.*', 'trl.title');
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


            $validate = Validation::voucherRules($request);
            if ($validate) {
                return response()->json($validate);
            }


            $endTime = date('Y-m-d H:i:s', strtotime($request->end_time));
            $startTime = date('Y-m-d H:i:s', strtotime($request->start_time));

            if ($endTime <= $startTime) {
                return response()->json(Validation::error(null,
                    __('lang.time_greater', [], $lang)
                ));
            }


            if ($request->time_zone) {
                if ($request->end_time) {
                    $request['end_time'] = Utils::convertTimeToUTCzone($request->end_time, $request->time_zone);
                }
                if ($request->start_time) {
                    $request['start_time'] = Utils::convertTimeToUTCzone($request->start_time, $request->time_zone);
                }
            }
            if ($id) {
                if ($can = Utils::userCan($this->user, 'voucher.edit')) {
                    return $can;
                }

                $existing = Voucher::find($id);
                if (!$this->isSuperAdmin && $isOwner = Utils::isDataOwner($this->user, $existing)) {
                    return $isOwner;
                }

                $filtered = array_filter($request->all(), function ($element) {
                    return '' !== trim($element);
                });


                if ($lang) {
                    [$langData, $mainData] = Utils::seperateLangData($filtered, ['title']);

                    Voucher::where('id', $id)->update($mainData);

                    $existingLang = VoucherLang::where('voucher_id', $id)
                        ->where('lang', $lang)->first();

                    if (!$existingLang) {
                        $langData['voucher_id'] = $id;
                        $langData['lang'] = $lang;
                        VoucherLang::create($langData);

                    } else {

                        VoucherLang::where('id', $existingLang->id)->update($langData);
                    }
                } else {
                    Voucher::where('id', $id)->update($filtered);
                }


            } else {

                if ($can = Utils::userCan($this->user, 'voucher.create')) {
                    return $can;
                }

                $voucherFromDb = Voucher::where('code', $request->code)
                    ->get()
                    ->first();

                if (!is_null($voucherFromDb)) {
                    return response()->json(Validation::error(null,
                        __('lang.voucher_exists', [], $lang)
                    ));
                }

                $request['admin_id'] = $request->user()->id;


                if ($lang) {
                    [$langData, $mainData] = Utils::seperateLangData($request->all(), ['title']);
                    $voucher = Voucher::create($mainData);

                    $langData['voucher_id'] = $voucher->id;
                    $langData['lang'] = $lang;
                    VoucherLang::create($langData);
                    $id = $voucher->id;

                } else {
                    $voucher = Voucher::create($request->all());
                    $id = $voucher->id;
                }
            }


            $query = Voucher::query();
            if ($lang) {
                $query = $query->leftJoin('voucher_langs as trl', function ($join) use ($lang) {
                    $join->on('trl.voucher_id', '=', 'vouchers.id');
                    $join->where('trl.lang', $lang);
                });
                $query = $query->select('vouchers.*', 'trl.title');
            }
            $data = $query->find($id);


            if ($request->time_zone) {
                $data['created'] = Utils::formatDate(Utils::convertTimeToUSERzone($data->created_at, $request->time_zone));
                $data['start_time'] = Utils::convertTimeToUSERzone($data->start_time, $request->time_zone);
                $data['end_time'] = Utils::convertTimeToUSERzone($data->end_time, $request->time_zone);

            } else {
                $data['created'] = Utils::formatDate($data->created_at);
                $data['start_time'] = $data->start_time;
                $data['end_time'] = $data->end_time;
            }
            return response()->json(new Response($request->token, $data));

        } catch (\Exception $ex) {
            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }
    }

    public function delete(Request $request, $id)
    {
        try {

            $lang = $request->header('language');

            if ($can = Utils::userCan($this->user, 'voucher.delete')) {
                return $can;
            }
            $voucher = Voucher::find($id);

            if (!$this->isSuperAdmin && $isOwner = Utils::isDataOwner($this->user, $voucher)) {
                return $isOwner;
            }

            if (is_null($voucher)) {
                return response()->json(Validation::noDataLang($lang));
            }


            $order = Order::where('voucher_id', $id)->get()->first();

            if ($order) {
                return response()->json(Validation::error($request->token,
                    __('lang.used_in_order', [], $lang)
                ));
            }

            VoucherLang::where('voucher_id', $id)->delete();


            if ($voucher->delete()) {
                return response()->json(new Response($request->token, $voucher));
            }

            return response()->json(Validation::errorTokenLang($request->token, $lang));

        } catch (\Exception $ex) {
            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }


    }
}
