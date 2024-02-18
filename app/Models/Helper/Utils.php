<?php

namespace App\Models\Helper;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;

class Utils
{

    public static function seperateLangData($data, $langFields){
        $langData = [];
        $mainData = [];

        foreach ($data as $key => $val) {
            if (!in_array($key, $langFields)) {
                $mainData[$key] = $val;
            } else {
                $langData[$key] = $val;
            }
        }

        return [$langData, $mainData];

    }

    public static function orderDetailRedirect(){
        return config('env.url.CLIENT_BASE_URL') . config('env.redirect.ORDER_DETAIL_REDIRECT');
    }

    public static function frontendSocialRedirect(){
        return config('env.url.CLIENT_BASE_URL') . config('env.redirect.FRONTEND_SOCIAL_REDIRECT');
    }

    public static function backendSocialRedirect(){
        return config('env.url.APP_URL') . config('env.redirect.BACKEND_SOCIAL_REDIRECT');
    }

    public static function userCan($user, $role){
        if(is_null($user) || !$user->can($role)){
            return response()->json(Validation::unauthorized());
        }
        return false;
    }

    public static function isDataOwner($user, $data){
        if(is_null($user) || ($user->id != $data->admin_id)){
            return response()->json(Validation::unauthorized());
        }
        return false;
    }

    public static function generateRandomString($length = 10) {
        return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
    }

    public static function cacheRemember($cacheKey, $query, $expiration = 60 * 60 * 24){

        return cache()->remember($cacheKey, $expiration, $query);
    }

    public static function convertTimeToUTCzone($str, $userTimezone, $format = 'Y-m-d H:i:s'){


        $new_str = new \DateTime($str, new \DateTimeZone( $userTimezone  ) );


        $new_str->setTimeZone(new \DateTimeZone('UTC'));
        return $new_str->format( $format);
    }

    public  static function convertTimeToUSERzone($str, $userTimezone, $format = 'Y-m-d H:i:s'){
        if(empty($str)){
            return '';
        }

        $new_str = new \DateTime($str, new \DateTimeZone('UTC') );
        $new_str->setTimeZone(new \DateTimeZone( $userTimezone ));
        return $new_str->format( $format);
    }

    public  static function idGenerator($model){
        $lastValue = $model::select('id')->orderBy('created_at','desc')->first();
        if($lastValue && $lastValue->id){
            $lastId = substr($lastValue->id,5);
            $lastId = $lastId + 3;
        }else{
            $lastId = 111;
        }
        $id = rand(6, 9) . rand(100, 999) . rand(0, 5) . $lastId;
        return $id;
    }

    public static function formatAddress($address){
        if($address){
            $addressArr = [];
            array_push($addressArr, $address->address_1);
            array_push($addressArr, $address->address_2);
            array_push($addressArr, $address->city);
            array_push($addressArr, $address->state);
            array_push($addressArr, $address->country);
            array_push($addressArr, $address->zip);

            $filtered = array_filter($addressArr, function ($element) {
                return '' !== trim($element);
            });

            return join(',', $filtered);
        }
        return 'N/A';
    }

    public static function formatDate($date, $format = 'h:i a, d M, y'){
        return Carbon::parse($date)->format($format);
    }


    public static function formatErrors($errors)
    {
        $errors_arr = [];
        foreach ($errors as $key => $value) {
            foreach ($errors[$key] as $error) {
                array_push($errors_arr, $error);
            }
        }
        return $errors_arr;
    }

    public static function orderId($item)
    {
        return self::formatDate($item->created_at, 'Ydm') . $item->id . $item->user_id . $item->status;
    }

    public static function calcPrice($order,$userOrder,$currency) {
        $subtotal = 0;
        $shipping_price = 0;
        $tax = 0;
        $bundle_offer = 0;

        foreach ($order->ordered_products as $item){
            $subtotal += $item->selling * $item->quantity;
            $shipping_price += $item->shipping_price;
            $tax += $item->tax_price * $item->quantity;
            $bundle_offer += $item->bundle_offer * $item->selling;
        }

        $calculated['subtotal'] = floatval(number_format($subtotal , 2));
        $calculated['shipping_price'] = $shipping_price;
        $calculated['bundle_offer'] = $bundle_offer;
        $calculated['tax'] = strval($tax) ;

        // Voucher price calculation
        $voucher = $order->voucher;
        $voucherPrice = $order->voucher_price;
        $totalPriceWithoutShipping = $userOrder->total_amount - $calculated['bundle_offer'];
//        if($voucher){
//            if((float)$voucher->type == (float)Config::get('constants.priceType.FLAT')){
//                $voucherPrice = $currency == "AFN" ? $voucher->price
//                : floatval(number_format($voucher->price / getDollar()->price , 2));
//            } else {
//                $voucherPrice = $voucher->price ;
//            }
//            if(!is_null($voucher->capped_price) && $voucherPrice > $voucher->capped_price){
//                $voucherPrice = $currency == "AFN" ? (int) $voucher->capped_price
//                : floatval(number_format((int) $voucher->capped_price / getDollar()->price , 2));
//            }
//        }
        $calculated['voucher_price'] = $voucherPrice;
        $calculated['total_price'] = floatval(number_format($userOrder->total_amount,2));
//        $currency == 'USD' ? $calculated['total_price'] = number_format($calculated['total_price'] / getDollar()->price, 2 ,'.',',')
//           : $calculated['total_price'];

        return $calculated;
    }

    public static function adminCalcPrice($order) {
        $subtotal = 0;
        $shipping_price = 0;
        $tax = 0;
        $bundle_offer = 0;

        foreach ($order->ordered_products as $item){
            $subtotal += $item->selling * $item->quantity;
            $shipping_price += $item->shipping_price;
            $tax += $item->tax_price * $item->quantity;
            $bundle_offer += $item->bundle_offer * $item->selling;
        }

        $calculated['subtotal'] = $subtotal;
        $calculated['shipping_price'] = $shipping_price;
        $calculated['bundle_offer'] = $bundle_offer;
        $calculated['tax'] = number_format($tax, 2);

        // Voucher price calculation
        $voucher = $order->voucher;
        $voucherPrice = 0;
        $totalPriceWithoutShipping = $calculated['subtotal'] - $calculated['bundle_offer'];
        if($voucher){
            if((int)$voucher->type == (int)Config::get('constants.priceType.FLAT')){
                $voucherPrice = $voucher->price;
            } else {
                $voucherPrice = number_format((float)($voucher->price * $totalPriceWithoutShipping) / 100, 2, '.', '');
            }
            if(!is_null($voucher->capped_price) && $voucherPrice > $voucher->capped_price){
                $voucherPrice = (int) $voucher->capped_price;
            }
        }
        $calculated['voucher_price'] = $voucherPrice;

        $calculated['total_price'] = $totalPriceWithoutShipping + $calculated['shipping_price']
            + (float)$calculated['tax'] - $voucherPrice;

        return $calculated;
    }
    public  static function jsDecryption($encrypted){
        $key = hex2bin("0123456470abcdef0123456789abcdef");
        $iv =  hex2bin("abcdef1876343516abcdef9876543210");
        $decrypted = openssl_decrypt($encrypted, 'AES-128-CBC', $key, OPENSSL_ZERO_PADDING, $iv);
        return trim($decrypted);
    }

    public  static function generateTrackingId($item){


        $now = Carbon::now();

        return Utils::formatDate($now, 'Ydm') . Utils::generateRandomString(5) . $item['user_id'];
    }


}
