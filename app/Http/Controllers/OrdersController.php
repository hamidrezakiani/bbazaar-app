<?php

namespace App\Http\Controllers;

use App\Http\Resources\ByUserCollection;
use App\Models\AttributeValue;
use App\Models\Cancellation;
use App\Models\Cart;
use App\Models\GuestUser;
use App\Models\Helper\ControllerHelper;
use App\Models\Helper\FileHelper;
use App\Models\Helper\MailHelper;
use App\Models\Helper\Response;
use App\Models\Helper\Utils;
use App\Models\Helper\Validation;
use App\Models\IyzicoPayment;
use App\Models\Order;
use App\Models\OrderedProduct;
use App\Models\Payment;
use App\Models\Setting;
use App\Models\SiteSetting;
use App\Models\UpdatedInventory;
use App\Models\UserAddress;
use App\Models\Voucher;
use Carbon\Carbon;
use Flutterwave\Service\Transactions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Auth;
use Razorpay\Api\Api;
use PDF;
use Mail;

class OrdersController extends ControllerHelper
{
    public function vendorAll(Request $request)
    {

        try {

            if (!$this->isVendor) {
                return Utils::isDataOwner(null, null);
            }

            if ($can = Utils::userCan($this->user, 'order.view')) {
                return $can;
            }

            $query = OrderedProduct::join('products as p', function ($join) {
                $join->on('p.id', '=', 'ordered_products.product_id');
                $join->where('p.admin_id', '=', $this->user->id);
            });

            $query = $query->with('product');
            $query = $query->with('updated_inventory.inventory_attributes.attribute_value.attribute');
            $query = $query->with('shipping_place');

            $query = $query->select('ordered_products.*');
            $data = $query->paginate(Config::get('constants.api.PAGINATION'));

            if ($request->time_zone) {
                foreach ($data as $item) {
                    $item['created'] = Utils::formatDate(Utils::convertTimeToUSERzone($item->created_at, $request->time_zone));
                }
            } else {
                foreach ($data as $item) {
                    $item['created'] = Utils::formatDate($item->created_at);
                }
            }

            return response()->json(new Response($request->token, $data));


        } catch (\Exception $ex) {
            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }
    }


    public function all(Request $request)
    {
        try {


            if ($this->isVendor) {
                return Utils::isDataOwner(null, null);
            }

            if ($can = Utils::userCan($this->user, 'order.view')) {
                return $can;
            }

            $query = Order::query();

            $query = $query->with('address');
            $query = $query->with('user_info');
            $query = $query->orderBy('orders.' . $request->orderby, $request->type);

            if ($request->filter) {

                foreach (explode(',', $request->filter) as $i) {
                    if ($i == 'cancelled') {
                        $query = $query->orWhere('cancelled', 1);
                    }
                    if ($i == 'paid') {
                        $query = $query->orWhere('payment_done', 1);
                    }
                    if ($i == 'unpaid') {
                        $query = $query->orWhere('payment_done', 0);
                    }
                    if ($i == 'card_payment') {
                        $query = $query
                            ->orWhere('order_method', Config::get('constants.paymentMethod.RAZORPAY'))
                            ->orWhere('order_method', Config::get('constants.paymentMethod.STRIPE'));
                    }
                    if ($i == 'paypal') {
                        $query = $query
                            ->orWhere('order_method', Config::get('constants.paymentMethod.PAYPAL'));
                    }
                    if ($i == 'cash_on_delivery') {
                        $query = $query->orWhere('order_method',
                            Config::get('constants.paymentMethod.CASH_ON_DELIVERY'));
                    }
                }
            }

            $query = $query->select('orders.*');
            $data = $query->paginate(Config::get('constants.api.PAGINATION'));

            if ($request->time_zone) {
                foreach ($data as $item) {
                    $item['created'] = Utils::formatDate(Utils::convertTimeToUSERzone($item->created_at, $request->time_zone));
                }
            } else {
                foreach ($data as $item) {
                    $item['created'] = Utils::formatDate($item->created_at);
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


            if ($this->isVendor) {
                return Utils::isDataOwner(null, null);
            }

            if ($can = Utils::userCan($this->user, 'order.view')) {
                return $can;
            }


            $query = Order::query();
            $query = $query->with('cancellation');
            $query = $query->with('address');
            $query = $query->with('user');
            $query = $query->with('guest_user');

            $query = $query->with('ordered_products.shipping_place');


            if ($lang) {

                $query = $query->with(['ordered_products.product' => function ($query) use ($lang) {
                    $query->leftJoin('product_langs as pl',
                        function ($join) use ($lang) {
                            $join->on('products.id', '=', 'pl.product_id');
                            $join->where('pl.lang', $lang);
                        })
                        ->select('products.id', 'products.title', 'products.image', 'products.selling',
                            'products.offered', 'products.shipping_rule_id',
                            'products.bundle_deal_id', 'products.unit', 'pl.title');
                }]);


                $query = $query->with(['voucher' => function ($query) use ($lang) {
                    $query->leftJoin('voucher_langs as vl',
                        function ($join) use ($lang) {
                            $join->on('vouchers.id', '=', 'vl.voucher_id');
                            $join->where('vl.lang', $lang);
                        })
                        ->select('vouchers.*', 'vl.title');
                }]);


                $query = $query->with(['ordered_products.updated_inventory.inventory_attributes.attribute_value' => function ($query) use ($lang) {
                    $query->leftJoin('attribute_value_langs as avl',
                        function ($join) use ($lang) {
                            $join->on('attribute_values.id', '=', 'avl.attribute_value_id');
                            $join->where('avl.lang', $lang);
                        })
                        ->with(['attribute' => function ($query) use ($lang) {

                            $query->leftJoin('attribute_langs as al',
                                function ($join) use ($lang) {
                                    $join->on('attributes.id', '=', 'al.attribute_id');
                                    $join->where('al.lang', $lang);
                                })
                                ->select('attributes.id', 'attributes.title', 'al.title');
                        }])
                        ->select('attribute_values.*', 'avl.title');
                }]);


            } else {

                $query = $query->with('ordered_products.product');
                $query = $query->with('voucher')
                    ->with('ordered_products.updated_inventory.inventory_attributes.attribute_value')
                    ->with('ordered_products.updated_inventory.inventory_attributes.attribute_value.attribute');
            }


            $order = $query->find($id);

            if (is_null($order)) {
                return response()->json(Validation::nothingFoundLang($lang));
            }

            $order['calculated'] = Utils::adminCalcPrice($order);

            if ($request->time_zone) {
                $order['created'] = Utils::formatDate(Utils::convertTimeToUSERzone($order->created_at, $request->time_zone));
            } else {
                $order['created'] = Utils::formatDate($order->created_at);
            }

            return response()->json(new Response($request->token, $order));


        } catch (\Exception $ex) {
            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }
    }


    public function updateStatus(Request $request)
    {
        try {
            $lang = $request->header('language');
            if ($this->isVendor) {
                return Utils::isDataOwner(null, null);
            }

            if ($can = Utils::userCan($this->user, 'order.edit')) {
                return $can;
            }

            $validate = Validation::orderStatus($request);
            if ($validate) {
                return response()->json($validate);
            }

            $order = Order::find($request->id);

            if (is_null($order)) {
                return response()->json(Validation::nothingFoundLang($lang));
            }

            $updatedStatus['status'] = $request->status;

            if ((int)Config::get('constants.orderStatus.DELIVERED') == (int)$request->status &&
                (int)Config::get('constants.paymentMethod.CASH_ON_DELIVERY') == (int)$order->order_method) {
                $updatedStatus['payment_done'] = Config::get('constants.status.PUBLIC');
            }

            Order::where('id', $request->id)->update($updatedStatus);

            return response()->json(new Response($request->token, ['result' =>
                [
                    'status' => $request->status,
                    'payment_done' => Config::get('constants.status.PUBLIC'),
                    'id' => $request->id
                ]]));


        } catch (\Exception $ex) {
            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }
    }


    public function delete(Request $request, $id)
    {

        try {
            $lang = $request->header('language');


            if ($this->isVendor) {
                return Utils::isDataOwner(null, null);
            }

            $order = Order::find($id);

            if (is_null($order)) {
                return response()->json(Validation::nothingFoundLang($lang));
            }

            OrderedProduct::where('order_id', $id)->delete();


            Cancellation::where('order_id', $id)->delete();


            if (Order::where('id', $id)->delete()) {
                return response()->json(new Response($request->token, $order));
            }
            return response()->json(Validation::errorTokenLang($request->token, $lang));

        } catch (\Exception $ex) {
            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }
    }


    public function byUser(Request $request)
    {
        try {


            $lang = $request->header('language');


            if ($request->order_id) {


                $query = Order::query();


                if ($lang) {

                    $query = $query->with(['ordered_products.updated_inventory.inventory_attributes.attribute_value.attribute' =>
                        function ($query) use ($lang) {
                            $query->leftJoin('attribute_langs as al', function ($join) use ($lang) {
                                $join->on('al.attribute_id', '=', 'attributes.id');
                                $join->where('al.lang', $lang);
                            })
                                ->select('attributes.*', 'al.title');
                        }]);

                    $query = $query->with(['ordered_products.updated_inventory.inventory_attributes.attribute_value' =>
                        function ($query) use ($lang) {

                            $query->leftJoin('attribute_value_langs as avl',
                                function ($join) use ($lang) {
                                    $join->on('attribute_values.id', '=', 'avl.attribute_value_id');
                                    $join->where('avl.lang', $lang);
                                })
                                ->select('attribute_values.*', 'avl.title');
                        }]);


                    $query = $query->with(['ordered_products.product.bundle_deal' => function ($query) use ($lang) {

                        $query->leftJoin('bundle_deal_langs as bdl', function ($join) use ($lang) {
                            $join->on('bdl.bundle_deal_id', '=', 'bundle_deals.id');
                            $join->where('bdl.lang', $lang);
                        })
                            ->select('bundle_deals.id', 'bundle_deals.buy', 'bundle_deals.free', 'bdl.title');

                    }]);

                    $query = $query->with(['ordered_products.product' => function ($query) use ($lang) {

                        $query->leftJoin('product_langs as pl', function ($join) use ($lang) {
                            $join->on('pl.product_id', '=', 'products.id');
                            $join->where('pl.lang', $lang);
                        })
                            ->select(['products.id', 'pl.title', 'products.slug', 'products.image', 'products.selling',
                                'category_id',
                                'products.offered', 'products.shipping_rule_id', 'products.bundle_deal_id', 'pl.unit']);

                    }]);


                    $query = $query->with('ordered_products.shipping_place');

                    $query = $query->with('address');

                    $query = $query->with('user_info');

                    $query = $query->with('voucher');
                    $query = $query->with('cancellation');


                } else {


                    $query = $query->with('ordered_products.product.bundle_deal');
                    $query = $query->with('ordered_products.updated_inventory.inventory_attributes.attribute_value.attribute');
                    $query = $query->with('address');

                    $query = $query->with('user_info');

                    $query = $query->with('voucher');
                    $query = $query->with('cancellation');
                    $query = $query->with('ordered_products.shipping_place');
                }


                $order = $query->find($request->order_id);
                $request->header('currency') == "USD" ? $order->total_amount = number_format($order->total_amount / getDollar()->price,2) : $order->total_amount;
                $userOrder = Order::find($request->order_id);
                if (is_null($order)) {
                    return response()->json(Validation::error($request->token,
                        __('lang.no_order', [], $lang)
                    ));
                }


                if ($request->user('user')) {

                    if ((int)$order->user_id !== $request->user('user')->id) {
                        return response()->json(Validation::error($request->token,
                            __('lang.not_order', [], $lang)
                        ));
                    }

                } else if($request->user_token){

                    if ($order->user_token !== $request->user_token) {
                        return response()->json(Validation::error($request->token,
                            __('lang.not_order', [], $lang)
                        ));
                    }

                } else {

                    return response()->json(Validation::errorLang($lang));
                }


                $order['user'] = $order->user_info;
                unset($order->user_info);
                foreach($order->ordered_products as $item){

//                    $selling = $item->selling;
//                    unset($item->selling);
//                    $shipping_price = $item->shipping_price;
//                    unset($item->shipping_price);
//                    $request->header('currency') == "USD" && $item->currency == "USD" ? number_format($shipping_price,2) : $item->shipping_price = number_format($shipping_price / getDollar()->price,2);
//                    $request->header('currency') == "USD" && $item->currency == "USD" ?  $item->selling = floatval(number_format($selling,2,',' , '.')) :  $item->selling = number_format($selling / getDollar()->price,2);
                }
                $order['calculated'] = Utils::calcPrice($order,$userOrder,$request->header('currency'));
                $order['created'] = Utils::formatDate(Utils::convertTimeToUSERzone($order->created_at, $request->time_zone));
//
//                dd($order);
                return response()->json(new Response($request->token, $order));

            } else {


                $query = Order::query();
                if ($lang) {
                    $query = $query->with(['ordered_products.product' => function ($query) use ($lang) {

                        $query->leftJoin('product_langs as pl', function ($join) use ($lang) {
                            $join->on('pl.product_id', '=', 'products.id');
                            $join->where('pl.lang', $lang);
                        })
                            ->select('products.id', 'pl.title', 'products.slug', 'products.image', 'products.selling',
                                'category_id',
                                'products.offered', 'products.shipping_rule_id', 'products.bundle_deal_id', 'pl.unit');


                    }]);
                } else {
                    $query = $query->with('ordered_products.product');
                }
                $query = $query->orderBy('created_at', 'DESC');

                if ($request->cancelled) {
                    $query = $query->where('cancelled', $request->cancelled);
                }

                if ($request->paid) {
                    $query = $query->where('payment_done', 1);

                    if ($request->unpaid) {
                        $query = $query->orWhere('payment_done', 0);
                    }
                } else if ($request->unpaid) {
                    $query = $query->where('payment_done', 0);
                }

                if ($request->card_payment) {
                    $query = $query
                        ->where('order_method', Config::get('constants.paymentMethod.RAZORPAY'))
                        ->orWhere('order_method', Config::get('constants.paymentMethod.STRIPE'));

                    if ($request->cash_on_delivery) {
                        $query = $query->orWhere('order_method', Config::get('constants.paymentMethod.CASH_ON_DELIVERY'));
                    }

                } else if ($request->cash_on_delivery) {
                    $query = $query->where('order_method', Config::get('constants.paymentMethod.CASH_ON_DELIVERY'));
                }



                if ($request->user('user')) {

                    $query = $query->where('user_id', $request->user('user')->id);

                } else if($request->user_token){

                    $query = $query->where('user_token', $request->user_token);

                } else {

                    return response()->json(Validation::errorLang($lang));
                }



                $data = new ByUserCollection($query->paginate(Config::get('constants.frontend.PAGINATION')));

                if ($request->time_zone) {
                    foreach ($data as $item) {

                        $item['created'] = Utils::formatDate(Utils::convertTimeToUSERzone($item->created_at, $request->time_zone));
                    }
                } else {
                    foreach ($data as $item) {

                        $item['created'] = Utils::formatDate($item->created_at);
                    }
                }
                return response()->json(new Response($request->token, $data));
            }

        } catch (\Exception $ex) {
            throw $ex;
//            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }
    }

    public function paymentDone(Request $request)
    {
        try {

            $lang = $request->header('language');

            $params = json_decode(Utils::jsDecryption($request->data));

            $request->request->add(['user_token' => $params->user_token]);
            $request->request->add(['id' => $params->id]);
            $request->request->add(['payment_token' => $params->payment_token]);
            $request->request->add(['order_method' => $params->order_method]);

            $validate = Validation::orderStatus($request);
            if ($validate) {
                return response()->json($validate);
            }


            $order = Order::with('voucher')
                ->with('address')
                ->where('id', $request->id)
                ->first();

            if (is_null($order)) {
                return response()->json(Validation::error($request->token,
                    __('lang.invalid_order', [], $lang)
                ));
            }


            if ($request->user('user')) {

                if ($order->user_id != $request->user('user')->id) {
                    return response()->json(Validation::error($request->token,
                        __('lang.invalid_user', [], $lang)
                    ));
                }

            } else if($request->user_token){

                if ($order->user_token != $request->user_token) {
                    return response()->json(Validation::error($request->token,
                        __('lang.invalid_user', [], $lang)
                    ));
                }

            } else {

                return response()->json(Validation::errorLang($lang));
            }


            $payment = Payment::first();

            if ((int)$payment->cash_on_delivery != 1 &&
                ((int)$request->order_method == Config::get('constants.paymentMethod.CASH_ON_DELIVERY'))) {

                return response()->json(Validation::error($request->token,
                    __('lang.accepted_cod', [], $lang)
                ));

            } else if ((int)$payment->paypal != 1 &&
                (int)$request->order_method == Config::get('constants.paymentMethod.PAYPAL')) {

                return response()->json(Validation::error($request->token,
                    __('lang.accepted_paypal', [], $lang)
                ));

            } else if ((int)$payment->stripe != 1 &&
                (int)$request->order_method == Config::get('constants.paymentMethod.STRIPE')) {

                return response()->json(Validation::error($request->token,
                    __('lang.accepted_gateway', [], $lang)
                ));

            } else if ((int)$payment->razorpay != 1 &&
                (int)$request->order_method == Config::get('constants.paymentMethod.RAZORPAY')) {

                return response()->json(Validation::error($request->token,
                    __('lang.accepted_gateway', [], $lang)
                ));

            } else if ((int)$payment->flutterwave != 1 &&
                (int)$request->order_method == Config::get('constants.paymentMethod.FLUTTERWAVE')) {

                return response()->json(Validation::error($request->token,
                    __('lang.accepted_gateway', [], $lang)
                ));
            }
            $paymentDone = false;

            if ((int)$request->order_method == Config::get('constants.paymentMethod.FLUTTERWAVE')) {

                try {

                    $con = \Flutterwave\Helper\Config::setUp(
                        $payment->fw_secret_key,
                        $payment->fw_public_key,
                        $payment->fw_encryption_key,
                        $payment->fw_environment
                    );
                    $transactions = new \Flutterwave\Service\Transactions($con);
                    $response = $transactions->verify($request->payment_token);

                    if ($response->status === "success") {

                        $paymentDone = true;

                    } else {

                        return response()->json(Validation::error($request->token,
                            __('lang.flutterwave_error', [], $lang)
                        ));
                    }

                } catch (\Exception $e) {

                    if (str_contains($e->getMessage(), 'The stream or file')) {
                        $paymentDone = true;
                    } else {
                        return response()->json(Validation::error($request->token,
                            $e->getMessage()
                        ));
                    }
                }
            } else if ((int)$request->order_method == Config::get('constants.paymentMethod.PAYPAL')) {


                $paymentDone = true;

            } else if ((int)$request->order_method == Config::get('constants.paymentMethod.RAZORPAY')) {
                if ($order->payment_token != $request->payment_token) {

                    return response()->json(Validation::error($request->token,
                        __('lang.invalid_token', [], $lang)
                    ));
                }
                $paymentDone = true;

            } else if ((int)$request->order_method == Config::get('constants.paymentMethod.STRIPE')) {

                // Calculating price
                $orderedProduct = OrderedProduct::with('product.bundle_deal')
                    ->where('order_id', $request->id)
                    ->get();
                $voucherPrice = 0;
                $shippingPrice = 0;
                $subtotal = 0;
                foreach ($orderedProduct as $item) {
                    // Bundle calculation
                    $bundleQtyOffer = 0;
                    $bundleDeal = $item->product->bundle_deal;
                    if ($bundleDeal) {
                        if ($bundleDeal) {
                            if ($item->quantity >= $bundleDeal->buy) {
                                $bundleQtyOffer = $bundleDeal->free;
                            }
                        }
                    }
                    $shippingPrice += $item->shipping_price;

                    $subtotal += ($item->selling * ($item->quantity - $bundleQtyOffer))
                        + ($item->tax_price * (int)$item->quantity);
                }
                if ($order->voucher) {
                    if ((int)$order->voucher->type === (int)Config::get('constants.priceType.FLAT')) {
                        $voucherPrice = $order->voucher->price;
                    } else {
                        $voucherPrice = number_format((float)($order->voucher->price * $subtotal) / 100, 2, '.', '');
                    }
                    if (!is_null($order->voucher->capped_price) && $voucherPrice > $order->voucher->capped_price) {
                        $voucherPrice = (int)$order->voucher->capped_price;
                    }
                }
                $totalPrice = $subtotal - $voucherPrice + $shippingPrice;

                $sSecret = $payment->stripe_secret;
                $setting = Setting::select('currency')->first();

                \Stripe\Stripe::setApiKey($sSecret);
                \Stripe\Charge::create([
                    'amount' => $totalPrice * 100,
                    'currency' => $setting->currency,
                    'source' => $request->payment_token,
                    'description' => 'order_id_' . $order->id,
                    'receipt_email' => $order->address->email,
                    'metadata' => [
                        'order_id' => $order->id,
                    ]
                ]);

                $paymentDone = true;

            } else if ((int)$request->order_method == Config::get('constants.paymentMethod.IYZICO_PAYMENT')) {

                $result["iyzico_payment"] = IyzicoPayment::initIyzico($request, $order->id);

                return response()->json(new Response($request->token, $result));
            }
            $result = Order::where('id', $request->id)->update([
                'payment_done' => $paymentDone,
                'order_method' => $request->order_method

            ]);
        } catch (\Exception $e) {
            return response()->json(Validation::error($request->token, $e->getMessage()));
        }
        return response()->json(new Response($request->token, $result));
    }


    public function action(Request $request)
    {
        try {
            $lang = $request->header('language');
            $currency = $request->header('currency');


            $params = json_decode(Utils::jsDecryption($request->data));

            $request->request->add(['user_token' => $params->user_token]);
            $request->request->add(['order_method' => $params->order_method]);
            $request->request->add(['voucher' => $params->voucher]);
            $request->request->add(['time_zone' => $params->time_zone]);

            $payment = Payment::first();

            if ((int)$payment->cash_on_delivery != 1 &&
                ((int)$request->order_method == Config::get('constants.paymentMethod.CASH_ON_DELIVERY'))) {
                return response()->json(Validation::error($request->token,
                    __('lang.accepted_cod', [], $lang)
                ));

            } else if ((int)$payment->paypal != 1 &&
                (int)$request->order_method == Config::get('constants.paymentMethod.PAYPAL')
            ) {
                return response()->json(Validation::error($request->token,
                    __('lang.accepted_paypal', [], $lang)
                ));

            } else if ((int)$payment->stripe != 1 &&
                (int)$request->order_method == Config::get('constants.paymentMethod.STRIPE')
            ) {
                return response()->json(Validation::error($request->token,
                    __('lang.accepted_gateway', [], $lang)
                ));

            } else if ((int)$payment->razorpay != 1 &&
                (int)$request->order_method == Config::get('constants.paymentMethod.RAZORPAY')
            ) {
                return response()->json(Validation::error($request->token,
                    __('lang.accepted_gateway', [], $lang)
                ));
            } else if ((int)$payment->iyzico_payment != 1 &&
                (int)$request->order_method == Config::get('constants.paymentMethod.IYZICO_PAYMENT')
            ) {
                return response()->json(Validation::error($request->token,
                    __('lang.accepted_gateway', [], $lang)
                ));
            }


            $validate = Validation::order($request);
            if ($validate) {
                return response()->json($validate);
            }

            $user = $request->user('user');


            $cartQuery = Cart::with('product_inner');


            if ($request->user('user')) {

                $cartQuery = $cartQuery->where('user_id', $request->user('user')->id);

            } else if($request->user_token){

                $cartQuery = $cartQuery->where('user_token', $request->user_token);

            } else {

                return response()->json(Validation::errorLang($lang));
            }

            $existingCart = $cartQuery->with('shipping_place')
                ->where('selected', Config::get('constants.status.PUBLIC'))
                ->with('updated_inventory')
                ->get();

            $totalPriceWithoutShipping = 0;
            foreach ($existingCart as $key => $cart) {
                if ($cart->shipping_place_id && !is_null($cart->product_inner)) {
                    // Selling price calculation

                    if (count($cart->updated_inventory->inventory_attributes) > 0) {
                        $inventoryPrice = (float)$cart->updated_inventory->price;
                    } else {
                        $inventoryPrice = 0;
                    }


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
                    } else if ($offered > 0) {
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
                    $totalPriceWithoutShipping += (float)$currentPrice * ((int)$cart->quantity - $bundleQtyOffer);
                }
            }

            $offeredVoucher = 0;
            $voucher = null;

            if ($request->voucher) {
                $voucher = Voucher::where('code', $request->voucher)
                    ->where('status', Config::get('constants.status.PUBLIC'))
                    ->get()->first();

                if (is_null($voucher)) {
                    return response()->json(Validation::error($request->token,
                        __('lang.invalid_voucher', [], $lang)
                    ));
                }
                $totalPriceWithoutShipping = $request->header('currency') == "AFN" ? $totalPriceWithoutShipping
                    : floatval(number_format($totalPriceWithoutShipping / getDollar()->price , 2));
                $min_spend = $request->header('currency') == 'AFN' ? $voucher->min_spend :
                    floatval(number_format($voucher->min_spend / getDollar()->price , 2));
                if ($totalPriceWithoutShipping < $min_spend) {
                    $setting = Setting::select('currency', 'currency_icon', 'currency_position')->first();
                    $price = $min_spend . $setting->currency_icon;

                    if ((int)$setting->currency_position == Config::get('constants.currencyPosition.PRE')) {
                        $price = $setting->currency_icon . $voucher->min_spend;
                    }

                    return response()->json(Validation::error($request->token,
                        __('lang.min_spent', ['amount' => $price], $lang)
                    ));
                }

                $totalOrdered = Order::where('voucher_id', $voucher->id)->count();

                if ($totalOrdered >= $voucher->usage_limit) {
                    return response()->json(Validation::error($request->token,
                        __('lang.voucher_exceeded', [], $lang)
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
                    return response()->json(Validation::error($request->token,
                        __('lang.voucher_max', [], $lang)
                    ));
                }

                $start = new Carbon($voucher->start_time);
                $end = new Carbon($voucher->end_time);
                $now = Carbon::now();

                if ($start >= $now && $now >= $end) {
                    return response()->json(Validation::error($request->token,
                        __('lang.voucher_expired', [], $lang)
                    ));
                }

                if ((int)$voucher->type === (int)Config::get('constants.priceType.FLAT')) {
                    $offeredVoucher = $currency == "AFN" ? $voucher->price :
                    floatval(number_format($voucher->price / getDollar()->price , 2));
                } else {
                    $offeredVoucher = number_format((float)($voucher->price * $totalPriceWithoutShipping) / 100, 2, '.', '');
                }
                if (!is_null($voucher->capped_price) && $offeredVoucher > $voucher->capped_price) {
                    $offeredVoucher = $currency == "AFN" ? (int)$voucher->capped_price :
                    floatval(number_format((int)$voucher->capped_price / getDollar()->price , 2));
                }
            }

            $cartError = [];

            foreach ($existingCart as $c) {
                $productErr = [];
                $error = false;

                if ($c->product->status != Config::get('constants.status.PUBLIC')) {
                    array_push($productErr,
                        __('lang.private_product', ['product' => $c->product->title], $lang)
                    );
                    $error = true;
                }
                if ((int)$c->updated_inventory->quantity < 1) {
                    array_push($productErr,
                        __('lang.out_stock_product', ['product' => $c->product->title], $lang)
                    );
                    $error = true;
                }
                if ($error) {
                    $cartError[$c->id] = $productErr;
                }
            }

            if (count($cartError) > 0) {
                return response()->json(Validation::error($request->token, $cartError, 'product'));
            }

            $setting = Setting::select('currency')->first();

            if (!$voucher) {
                $voucher['id'] = null;
            }




            if (count($existingCart) > 0) {
                $now = Carbon::now();


                $orderArr = [
                    'order_method' => $request->order_method,
                    'voucher_id' => $voucher['id'],
                    'currency' => $setting->currency,
                    'updated_at' => $now,
                    'created_at' => $now,
                ];
                $orderArr['user_id'] = null;
                if ($request->user('user')) {

                    $orderArr['user_id'] = $request->user('user')->id ?? null;
                    $orderArr['order'] = Utils::generateTrackingId(["user_id" => $request->user('user')->id]);
                    $orderArr['user_address_id'] = $user->default_address;

                } else if($request->user_token){

                    $guestUser = GuestUser::where('user_token', $request->user_token)->first();

                    if(!$guestUser){
                       $guestUser = GuestUser::create([
                            "user_token" => $request->user_token
                        ]);
                    }



                    if(!$guestUser->default_address){
                        $userAddress = UserAddress::where('user_token', $request->user_token)->first();


                        GuestUser::where('user_token', $request->user_token)
                            ->update(['default_address' => $userAddress->id]);

                        $guestUser = GuestUser::where('user_token', $request->user_token)->first();

                    }

                    $orderArr['user_address_id'] = $guestUser->default_address;
                    $orderArr['user_token'] = $request->user_token;
                    $orderArr['order'] = Utils::generateTrackingId(["user_id" => rand(2,50)]);
                }

//                var_dump($orderArr);
//                die();
                $order = Order::create([
                    'order_method' => $orderArr['order_method'],
                    'voucher_id' => $orderArr['voucher_id'],
                    'currency' => $request->header('currency'),
                    'updated_at' => $orderArr['updated_at'],
                    'created_at' => $orderArr['created_at'],
                    'user_id' => $orderArr['user_id'],
                    'order' => $orderArr['order'],
                    'user_address_id' => $orderArr['user_address_id'],
                    'user_token' => $guestUser->user_token
                ]);

                $orderedProducts = [];
                $totalPrice = 0;

                $commission = 0;
                if ($this->isVendor) {
                    $commission = $this->user->commission;
                }




                foreach ($existingCart as $key => $cart) {
                    if ($cart->shipping_place_id && !is_null($cart->product_inner)) {
                        // Selling price calculation


                        if (count($cart->updated_inventory->inventory_attributes) > 0) {
                            $inventoryPrice = (float)$cart->updated_inventory->price;
                        } else {
                            $inventoryPrice = 0;
                        }


                        $selling = (float)$cart->product_inner->selling;
                        $offered = (float)$cart->product_inner->offered;
                        $flashPrice = null;
                        if (!is_null($cart->product_inner->end_time)) {
                            $flashPrice = (float)$cart->product_inner->price;
                        }
                        if ($inventoryPrice > 0) {
                            $currentPrice = $inventoryPrice;
                        } else if ($flashPrice !== null) {
                            $currentPrice = $flashPrice;
                        } else if ($offered > 0) {
                            $currentPrice = $offered;
                        } else {
                            $currentPrice = $selling;
                        }

                        // Selling price calculation
                        $shippingPrice = 0;
                        if ((int)$cart->shipping_type === Config::get('constants.shippingTypeIn.LOCATION')) {
                            $shippingPrice = $cart->shipping_place->price;
                        } else if ((int)$cart->shipping_type === Config::get('constants.shippingTypeIn.PICKUP')) {
                            $shippingPrice = $cart->shipping_place->pickup_price;
                        }

                        // Bundle calculation
                        $bundleQtyOffer = 0;
                        $bundleDeal = $cart->product_inner->bundle_deal;
                        if ($bundleDeal) {
                            if ($cart->quantity >= $bundleDeal->buy) {
                                $bundleQtyOffer = $bundleDeal->free;
                            }
                        }



                        // Tax calculation
                        $taxQtyOffer = 0;
                        $taxRule = $cart->product_inner->tax_rules;
                        if ($taxRule) {
                            if ((int)$taxRule->type === (int)Config::get('constants.priceType.FLAT')) {
                                $taxQtyOffer = $taxRule->price;
                            } else {
                                $taxQtyOffer = number_format(
                                    (float)($taxRule->price * $currentPrice) / 100,
                                    2, '.', '');
                            }
                        }

                        $totalTax = (float)($taxQtyOffer * (int)$cart->quantity);
                        $priceWithoutBundle = (float)($currentPrice * ((int)$cart->quantity - (int)$bundleQtyOffer));
                        $total = (float)($shippingPrice + $totalTax + $priceWithoutBundle);
                        $request->header('currency') == 'USD' ? $totalPrice += $total / getDollar()->price : $totalPrice += $total ;
//                        $totalPrice += $total;
//                        var_dump($totalPrice);
//                        die();

                        // Inserting ordered product
                        array_push($orderedProducts, [
                            'commission' => $commission,
                            'tax_price' => $request->header('currency') == 'USD' ? $taxQtyOffer / getDollar()->price : $taxQtyOffer,
                            'commission_amount' => ($currentPrice * $cart->quantity * $commission) / 100,
                            'product_id' => $cart->product_inner->id,
                            'inventory_id' => $cart->inventory_id,
                            'quantity' => $cart->quantity,
                            'shipping_place_id' => $cart->shipping_place_id,
                            'shipping_type' => $cart->shipping_type,
                            'purchased' => $request->header('currency') == 'USD' ? $cart->product_inner->purchased / getDollar()->price : $cart->product_inner->purchased,
                            'bundle_offer' => $bundleQtyOffer,
                            'shipping_price' => $request->header('currency') == 'USD' ? $shippingPrice / getDollar()->price : $shippingPrice,
                            'selling' => $request->header('currency') == 'USD' ? $currentPrice / getDollar()->price : $currentPrice,
                            'order_id' => $order->id,
                            'updated_at' => $now,
                            'created_at' => $now
                        ]);



                        UpdatedInventory::where('id', $cart->inventory_id)->decrement('quantity', $cart->quantity);
                    }
                }


                $totalPrice = number_format($totalPrice, 2, '.', '');


//                var_dump($orderedProducts[0]['product_id']);
//                die();
                $result = OrderedProduct::insert($orderedProducts);

                if ($result) {

                    if ($request->user('user')) {

                        $user = $request->user('user');

                        Cart::where('user_id', $user->id)
                            ->where('selected', Config::get('constants.status.PUBLIC'))
                            ->delete();


                        $re['name'] = $user->name;
                        $re['email'] = $user->email;

                    } else if($request->user_token){

                        Cart::where('user_token', $request->user_token)
                            ->where('selected', Config::get('constants.status.PUBLIC'))
                            ->delete();

                        $guestUser = GuestUser::where('user_token', $request->user_token)->first();

                        $re['name'] = $guestUser->name;
                        $re['email'] = $guestUser->email;

                    }



                    $re['currency'] = $setting->currency;
                    $re['amount'] = number_format((float)$totalPrice, 2, '.', '');
                    $re['id'] = $order->id;

                    $re['order'] = $order->order;




                    if ((int)$request->order_method == Config::get('constants.paymentMethod.STRIPE')) {

                        $re['order_method'] = Config::get('constants.paymentMethod.STRIPE');
//                        dd( $offeredVoucher);
                        // Saving total amount in order to generate report for admin easily
                        Order::where('id', $order->id)->update([
                            'total_amount' => $totalPrice - $offeredVoucher,
                            'voucher_price' => $offeredVoucher
                        ]);

                        return response()->json(new Response($request->token, $re));

                    } else if ((int)$request->order_method == Config::get('constants.paymentMethod.RAZORPAY')) {

                        try {
                            $api = new Api($payment->razorpay_key, $payment->razorpay_secret);
                            $razorpayOrder = $api->order->create([
                                'receipt' => 'order_id_' . $order->id,
                                'amount' => ($totalPrice - $offeredVoucher) * 100,
                                'currency' => $setting->currency
                            ]);
                            $re['payment_token'] = $razorpayOrder->id;
                            $re['order_method'] = Config::get('constants.paymentMethod.RAZORPAY');

                            // Saving total amount in order to generate report for admin easily

                            Order::where('id', $order->id)->update([
                                'payment_token' => $razorpayOrder->id,
                                'total_amount' => $totalPrice - $offeredVoucher,
                                'voucher_price' => $offeredVoucher
                            ]);

                            return response()->json(new Response($request->token, $re));
                        } catch (\Exception $e) {

                            $ops = OrderedProduct::where('order_id', $order->id)
                                ->get();

                            foreach ($existingCart as $ops) {

                                OrderedProduct::where('id', $ops->id)
                                    ->delete();

                                UpdatedInventory::where('id', $ops->inventory_id)
                                    ->increment('quantity', $ops->quantity);

                            }

                            Order::where('id', $order->id)
                                ->delete();
                            return response()->json(Validation::error($request->token, $e->getMessage()));
                        }

                    } else if ((int)$request->order_method == Config::get('constants.paymentMethod.CASH_ON_DELIVERY')) {
//                        dd($offeredVoucher);
                        // Saving total amount in order to generate report for admin easily
                        Order::where('id', $order->id)->update([
                            'total_amount' => $totalPrice - $offeredVoucher,
                            'voucher_price' => $offeredVoucher
                        ]);
                        return response()->json(new Response($request->token, $order));


                    } else if ((int)$request->order_method == Config::get('constants.paymentMethod.PAYPAL')) {

                        // Saving total amount in order to generate report for admin easily
                        Order::where('id', $order->id)->update([
                            'total_amount' => $totalPrice - $offeredVoucher,
                            'voucher_price' => $offeredVoucher
                        ]);
                        return response()->json(new Response($request->token, $re));

                    } else if ((int)$request->order_method == Config::get('constants.paymentMethod.FLUTTERWAVE')) {

                        // Saving total amount in order to generate report for admin easily
                        Order::where('id', $order->id)->update([
                            'total_amount' => $totalPrice - $offeredVoucher,
                            'voucher_price' => $offeredVoucher
                        ]);
                        return response()->json(new Response($request->token, $re));


                    } else if ((int)$request->order_method == Config::get('constants.paymentMethod.IYZICO_PAYMENT')) {

                        // Saving total amount in order to generate report for admin easily
                        Order::where('id', $order->id)->update([
                            'total_amount' => $totalPrice - $offeredVoucher,
                            'voucher_price' => $offeredVoucher
                        ]);

                        $re["iyzico_payment"] = IyzicoPayment::initIyzico($request, $order->id);


                        return response()->json(new Response($request->token, $re));
                    }
                }
                return response()->json(Validation::error($request->token,
                    __('lang.went_wrong', [], $lang)
                ));
            }
            return response()->json(Validation::error($request->token,
                __('lang.no_cart', [], $lang)
            ));

        } catch (\Exception $e) {
            return $e;
//            return response()->json(Validation::error($request->token, $e->getMessage()));
        }
    }


    public function sendOrderEmail(Request $request, $id)
    {
        try {
            $lang = $request->header('language');


            $mailDataLang = MailHelper::sendingOrderEmail($request, $id, $lang);

            $mailData = MailHelper::sendingOrderEmail($request, $id);


            if (is_null($mailData)) {
                return response()->json(Validation::error($request->token,
                    __('lang.invalid_order', [], $lang)
                ));
            }

            if($mailData){
                $setting = $mailData['setting'];
                $order = $mailData['order'];
            }



            $pdf = PDF::loadView('mail_templates.order_pdf', $mailData)
                ->setPaper('a4', 'potrait')
                ->setWarnings(false);



            $userName = "";
            $userEmail = "";

            if ($request->user('user')) {

                $userEmail = $order->user->email;
                $userName = $order->user->name;

            } else if($request->user_token){




                if($order->guest_user->email){
                    $userEmail = $order->guest_user->email;
                }

                if($order->guest_user->name){
                    $userName = $order->guest_user->name;
                }


            } else {

                return response()->json(Validation::errorLang($lang));
            }



            Mail::send('mail_templates.order_placed', $mailDataLang,
                function ($message) use ($setting, $pdf, $order, $lang, $userName, $userEmail) {
                    $message->to($userEmail, $userName)
                        ->subject(
                            __('lang.confirmation', ['store' => $setting->store_name], $lang)
                        )
                        ->attachData($pdf->output(), $order['order'] . ".pdf");

                });

        } catch (\Exception $ex) {
            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }

        return response()->json(new Response($request->token, true));

    }



    public function sendDeliveredEmail(Request $request, $id)
    {
        try {
            $lang = $request->header('language');

            $mailData = MailHelper::sendingOrderEmail($request, $id, $lang);
            if (is_null($mailData)) {
                return response()->json(Validation::error($request->token,
                    __('lang.invalid_order', [], $lang)
                ));
            }

            if ((int)Config::get('constants.orderStatus.DELIVERED') != (int)$mailData['order']['status']) {
                return response()->json(new Response($request->token, true));
            }

            $order = $mailData['order'];

            $name = $order->user['name'] ? $order->user['name'] : '';
            $email = $order->user['email'] ? $order->user['email'] : null;

            if (is_null($email)) {
                return response()->json(Validation::error($request->token,
                    __('lang.no_user', [], $lang)
                ));
            }

            Mail::send('mail_templates.package_delivered', $mailData,
                function ($message) use ($order, $email, $name, $lang) {
                    $message->to($email, $name)
                        ->subject(__('lang.package_delivered', [], $lang));

                });

        } catch (\Exception $ex) {
            return response()->json(Validation::error($request->token, explode('.', $ex->getMessage())[0]));
        }

        return response()->json(new Response($request->token, true));
    }


    public function generatePDF($id)
    {
        if ($this->isVendor) {
            return Utils::isDataOwner(null, null);
        }

        if ($can = Utils::userCan($this->user, 'order.view')) {
            return $can;
        }

        if ($can = Utils::userCan($this->user, 'order.edit')) {
            return $can;
        }

        $key = hex2bin("0123456470abcdef0123456789abcdef");
        $iv = hex2bin("abcdef1876343516abcdef9876543210");

        $encrypted = '3z8tIolfpCM8iqPnvDbv3w==';
        $decrypted = openssl_decrypt($encrypted, 'AES-128-CBC', $key, OPENSSL_ZERO_PADDING, $iv);

        $decrypted = trim($decrypted);

//        dd($decrypted);


        $order = MailHelper::order($id);
        $objDemo = MailHelper::emailData('jj');
        $objDemo->logo_base64 = FileHelper::imageToBase64($objDemo->image);

        return view('mail_templates.package_delivered', ['order' => $order, 'setting' => $objDemo]);
        // return view('mail_templates.order_placed', ['order' => $order, 'setting' => $objDemo]);
        return view('mail_templates.order_pdf', ['order' => $order, 'setting' => $objDemo]);

        $pdf = PDF::loadView('mail_templates.order_pdf', ['order' => $order, 'setting' => $objDemo])
            ->setPaper('a4', 'potrait')->setWarnings(false);
        return $pdf->download('disney.pdf');
    }
}
