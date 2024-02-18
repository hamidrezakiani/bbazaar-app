<?php

namespace App\Models\Helper;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class Validation
{

    public static function updatedInventory($request, $errorType="form"){
        $rules = [
            'inventories' => 'required'
        ];

        return self::validationMessage($request, $rules, $errorType);
    }

    public static function cancelled($request){
        $rules = [
            'order_id' => 'required',
            'title' => 'required',
            'message' => 'required',
        ];

        return self::validationMessage($request, $rules);
    }

    public static function user_wishlist($request){
        $rules = [
            'product_id' => 'required',
        ];

        return self::validationMessage($request, $rules);
    }
    public static function userProfile($request){
        $rules = [
            'name' => 'required',
        ];

        return self::validationMessage($request, $rules);
    }
    public static function orderStatus($request){
        $rules = [
            'id' => 'required'
        ];

        return self::validationMessage($request, $rules);
    }


    public static function ratingReview($request){
        $rules = [
            'rating' => 'required|numeric|min:1|max:5',
            'product_id' => 'required',
            'order_id' => 'required'
        ];

        return self::validationMessage($request, $rules);
    }


    public static function voucherValidity($request){
        $rules = [
            'voucher' => 'required',
            'price' => 'required'
        ];

        return self::validationMessage($request, $rules);
    }

    public static function admin_login($request)
    {
        $rules = [
            'email' => 'required|email',
            'password' => 'required|min:6'
        ];

        return self::validationMessage($request, $rules);
    }


    public static function page_wysiwyg_image($request)
    {
        $rules = [];

        array_push($rules, self::imageRules());

        return self::validationMessage($request, $rules, 'image');
    }

    public static function wysiwyg_image($request)
    {
        $rules = [
            'type' => 'required'
        ];

        array_push($rules, self::imageRules());

        return self::validationMessage($request, $rules, 'image');
    }

    public static function email_verification($request)
    {
        $rules = [
            'email' => 'required|email',
        ];

        return self::validationMessage($request, $rules);
    }

    public static function update_password($request)
    {
        $rules = [
            'code' => 'required|min:4',
            'email' => 'required|email',
            'password' => 'required|min:6'
        ];

        return self::validationMessage($request, $rules);
    }

    public static function updateUserPassword($request)
    {
        $rules = [
            'current_password' => 'required|min:6',
            'new_password' => 'required|min:6'
        ];

        return self::validationMessage($request, $rules);
    }

    public static function user_address($request)
    {
        $rules = [
            'country' => 'required|min:2|max:2',
            'city' => 'required',
            'zip' => 'required',
            'address_1' => 'required',
            'email' => 'required',
            'name' => 'required',
            'phone' => 'required'
        ];

        return self::validationMessage($request, $rules);
    }

    public static function user_verification($request)
    {
        $rules = [
            'code' => 'required|min:4',
            'email' => 'required|email',
        ];

        return self::validationMessage($request, $rules);
    }

    public static function user_signup($request)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6'
        ];

        return self::validationMessage($request, $rules);
    }

    public static function order($request)
    {
        $rules = [
            'order_method' => 'required',
        ];

        return self::validationMessage($request, $rules);
    }

    public static function admin_signup($request)
    {
        $rules = [
            'username' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6'
        ];

        return self::validationMessage($request, $rules);
    }

    public static function admin_password($request)
    {
        $rules = [
            'password' => 'required|min:6',
            'new_password' => 'required|min:6'
        ];

        return self::validationMessage($request, $rules);
    }

    public static function forgotPassword($request)
    {
        $rules = [
            'email' => 'required|email',
        ];

        return self::validationMessage($request, $rules);
    }

    public static function verifyCode($request)
    {
        $rules = [
            'email' => 'required|email',
            'code' => 'required',
            'password' => 'required|min:6'
        ];

        return self::validationMessage($request, $rules);
    }


    public static function payment($request)
    {
        $rules = [
            'cash_on_delivery' => 'required'
        ];

        return self::validationMessage($request, $rules);
    }

    public static function withdrawal($request)
    {
        $rules = [
            'amount' => 'required'
        ];

        return self::validationMessage($request, $rules);
    }

    public static function withdrawalApprove($request)
    {
        $rules = [
            'id' => 'required'
        ];

        return self::validationMessage($request, $rules);
    }

    public static function withdrawalCancel($request)
    {
        $rules = [
            'id' => 'required',
            'message' => 'required'
        ];

        return self::validationMessage($request, $rules);
    }

    public static function withdrawalAccount($request)
    {
        $rules = [
            'account_number' => 'required',
            'account_name' => 'required',
            'bank_name' => 'required',
            'branch_name' => 'required',
            'title' => 'required',
            'default' => 'required'
        ];

        return self::validationMessage($request, $rules);
    }


    public static function siteSetting($request)
    {
        $rules = [
            'site_name' => 'required',
            'meta_title' => 'required',
            'meta_description' => 'required',
        ];

        return self::validationMessage($request, $rules);
    }

    public static function store($request)
    {
        $rules = [
            'name' => 'required',
            'slug' => 'required'
        ];

        return self::validationMessage($request, $rules);
    }

    public static function address($request)
    {
        $rules = [
            'address_1' => 'required',
            'city' => 'required',
            'state' => 'required',
            'zip' => 'required',
            'country' => 'required'
        ];

        return self::validationMessage($request, $rules);
    }

    public static function currency($request)
    {
        $rules = [
            'currency' => 'required',
            'currency_icon' => 'required',
            'currency_position' => 'required'
        ];

        return self::validationMessage($request, $rules);
    }

    public static function page($request)
    {
        $rules = [
            'title' => 'required',
            'slug' => 'required',
            'page_from_component' => 'required',
            'meta_title' => 'required',
            'meta_description' => 'required'
        ];

        return self::validationMessage($request, $rules);
    }


    public static function flashSale($request)
    {
        $rules = [
            'title' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'status' => 'required|numeric|min:0|not_in:0',
        ];

        return self::validationMessage($request, $rules);
    }

    public static function serviceAndAbout($request)
    {
        $rules = [
            'service_links' => 'required',
            'about_links' => 'required'
        ];

        return self::validationMessage($request, $rules);
    }


    public static function footerLink($request)
    {
        $rules = [
            'page_id' => 'required',
            'type' => 'required|numeric|min:0|not_in:0'
        ];

        return self::validationMessage($request, $rules);
    }

    public static function footerImageLink($request)
    {
        $rules = [
            'title' => 'required',
            'link' => 'required',
            'type' => 'required|numeric|min:0|not_in:0'
        ];

        return self::validationMessage($request, $rules);
    }

    public static function footerImage($request)
    {
        $rules = [
            'type' => 'required|numeric|min:0|not_in:0'
        ];

        array_push($rules, self::imageRules());

        return self::validationMessage($request, $rules, 'image');
    }


    public static function banner($request)
    {
        $rules = [
            'source_type' => 'required|numeric|min:0|not_in:0',
            'type' => 'required|numeric|min:0|not_in:0',
            'closable' => 'required|numeric|min:0|not_in:0',
            'slug' => 'required',
            'title' => 'required'
        ];

        return self::validationMessage($request, $rules);
    }

    public static function homeSlider($request)
    {
        $rules = [
            'source_type' => 'required|numeric|min:0|not_in:0',
            'type' => 'required|numeric|min:0|not_in:0',
            'slug' => 'required',
            'title' => 'required'
        ];

        return self::validationMessage($request, $rules);
    }

    public static function bannerImage($request)
    {
        $rules = [
            'type' => 'required|numeric|min:0|not_in:0'
        ];

        array_push($rules, self::imageRules());

        return self::validationMessage($request, $rules, 'image');
    }


    public static function homeSliderImage($request)
    {
        $rules = [
            'type' => 'required|numeric|min:0|not_in:0'
        ];

        array_push($rules, self::imageRules());

        return self::validationMessage($request, $rules, 'image');
    }

    public static function password_check($admin, $password, $message = null, $error_type = 'form', $lang = null)
    {
        if(!$message){
            $message = __('lang.wrong_email', [], $lang);
        }

        if (is_null($admin) || !Hash::check($password, $admin->password)){
            return new Response(null, [$error_type => [$message]], 201, $message);
        }

        return false;
    }

    public static function frontendError($message = null, $lang = null)
    {
        if(!$message){
            $message = __('lang.couldnt_found', [], $lang);
        }
        return Validation::message(null, $message);
    }


    public static function errorTokenLang($token = null, $lang = null)
    {
        return self::error($token, null, 'form', $lang);
    }


    public static function errorLang($lang = null)
    {
        return self::error(null, null, 'form', $lang);
    }


    public static function error($token = null, $message = null, $error_type = 'form', $lang = null)
    {
        if(!$message){
            $message = __('lang.went_wrong', [], $lang);
        }
        return new Response($token, [$error_type => [$message]], 201, $message);
    }


    public static function nothingFoundLang($lang = null, $status = 200)
    {
        return self::nothing_found($status, null, 'form', $lang);
    }


    public static function nothing_found($status = 200, $message = null, $error_type = 'form', $lang = null)
    {
        if(!$message){
            $message = __('lang.couldnt_found', [], $lang);
        }

        return new Response(null, [$error_type => [$message]], $status, $message);
    }

    public static function unauthorized($status = 403, $message = null, $error_type = 'form', $lang = null)
    {
        if(!$message){
            $message = __('lang.no_access', [], $lang);
        }

        return new Response(null, [$error_type => [$message]], $status, $message);
    }


    public static function noDataLang($lang = null)
    {
        return self::noData(201, null, 'form', $lang);
    }


    public static function noData($status = 201, $message = null, $error_type = 'form', $lang = null)
    {
        if(!$message){
            $message = __('lang.couldnt_found', [], $lang);
        }
        return new Response(null, [$error_type => [$message]], $status, $message);
    }

    public static function invalid_parameter($token, $message = null, $error_type = 'form', $lang = null)
    {
        if(!$message){
            $message = __('lang.invalid_parameter', [], $lang);
        }

        return new Response($token, [$error_type => [$message]], 201, $message);
        //return new Response($token, [$message], 201, $message);
    }

    public static function message($token, $message)
    {
        return new Response($token, [$message], 201, $message);
    }


    public static function productDescription($request){
        $rules = [
            'description' => 'required',
        ];

        return self::validationMessage($request, $rules);
    }


    public static function changeCart($request){
        $rules = [
            'checked' => 'required',
            'unchecked' => 'required'
        ];

        return self::validationMessage($request, $rules);
    }

    public static function productMain($request){
        $rules = [
            'title' => 'required',
            'unit' => 'required',
            'meta_title' => 'required',
            'meta_description' => 'required',
            'description' => 'required',
            'overview' => 'required',
            'selling' => 'required|numeric|min:0|not_in:0',
            'purchased' => 'required|numeric|min:0|not_in:0',
            'category_id' => 'required|numeric|min:0|not_in:0',
            'tax_rule_id' => 'required|numeric|min:0|not_in:0',
            'shipping_rule_id' => 'required|numeric|min:0|not_in:0'
        ];

        return self::validationMessage($request, $rules);
    }


    public static function updateCart($request){
        $rules = [
            'id' => 'required',
            'quantity' => 'required',
        ];

        return self::validationMessage($request, $rules);
    }

    public static function shippingCart($request){
        $rules = [
            'cart' => 'required',
            'selected_address' => 'required'
        ];

        return self::validationMessage($request, $rules);
    }


    public static function sendSubscriptionEmail($request){
        $rules = [
            'id' => 'required',
        ];

        return self::validationMessage($request, $rules);
    }


    public static function emailSubscription($request){
        $rules = [
            'email' => 'required|email',
        ];

        return self::validationMessage($request, $rules);
    }


    public static function cart($request){
        $rules = [
            'product_id' => 'required',
            'inventory_id' => 'required',
            'quantity' => 'required',
        ];

        return self::validationMessage($request, $rules);
    }

    public static function admin($request){
        $rules = [
            'username' => 'required',
            'roles' => 'required',
            'email' => 'required'
        ];

        return self::validationMessage($request, $rules);
    }

    public static function role($request){
        $rules = [
            'name' => 'required'
        ];

        return self::validationMessage($request, $rules);
    }

    public static function subCategory($request){
        $rules = [
            'title' => 'required',
            'category_id' => 'required|numeric|min:0|not_in:0',
            'slug' => 'required',
            'meta_title' => 'required',
            'meta_description' => 'required'
        ];

        return self::validationMessage($request, $rules);
    }

    public static function attributeValue($request){
        $rules = [
            'title' => 'required',
            'attribute_id' => 'required|numeric|min:0|not_in:0'
        ];

        return self::validationMessage($request, $rules);
    }

    public static function contactUs($request)
    {
        $rules = [
            'id' => 'required'
        ];

        return self::validationMessage($request, $rules);
    }

    public static function shippingRule($request)
    {
        $rules = [
            'title' => 'required',
            'shipping_places' => 'required',
        ];

        return self::validationMessage($request, $rules);
    }


    public static function attribute($request)
    {
        $rules = [
            'title' => 'required',
        ];

        return self::validationMessage($request, $rules);
    }


    public static function tag($request)
    {
        $rules = [
            'title' => 'required',
        ];

        return self::validationMessage($request, $rules);
    }



    public static function collection($request)
    {
        $rules = [
            'title' => 'required',
            'slug' => 'required',
        ];

        return self::validationMessage($request, $rules);
    }


    public static function brand($request)
    {
        $rules = [
            'title' => 'required',
            'slug' => 'required'
        ];

        return self::validationMessage($request, $rules);
    }

    public static function category($request)
    {
        $rules = [
            'title' => 'required',
            'slug' => 'required',
            'meta_title' => 'required',
            'meta_description' => 'required'
        ];

        return self::validationMessage($request, $rules);
    }


    public static function subscriptionEmail($request)
    {
        $rules = [
            'title' => 'required',
            'subject' => 'required',
            'body' => 'required'
        ];

        return self::validationMessage($request, $rules);
    }

    public static function voucherRules($request)
    {
        $rules = [
            'title' => 'required',
            'code' => 'required',
            'type' => 'required|numeric|min:0|not_in:0',
            'price' => 'required|numeric|min:0|not_in:0'
        ];
        return self::validationMessage($request, $rules);
    }


    public static function language($request)
    {
        $rules = [
            'name' => 'required',
            'code' => 'required'
        ];
        return self::validationMessage($request, $rules);
    }


    public static function bundleDeals($request)
    {
        $rules = [
            'title' => 'required',
            'buy' => 'required|numeric|min:0|not_in:0',
            'free' => 'required|numeric|min:0|not_in:0'
        ];
        return self::validationMessage($request, $rules);
    }

    public static function userFollowStore($request)
    {
        $rules = [
            'store_id' => 'required'
        ];
        return self::validationMessage($request, $rules);
    }

    public static function taxRules($request)
    {
        $rules = [
            'title' => 'required',
            'type' => 'required|numeric|min:0|not_in:0',
            'price' => 'required|numeric|min:0'
        ];
        return self::validationMessage($request, $rules);
    }


    public static function tagRules($request)
    {
        $rules = [
            'title' => 'required',
            'type' => 'required|numeric|min:0|not_in:0'
        ];
        return self::validationMessage($request, $rules);
    }

    public static function quantityValidation($request, $token)
    {
        $rules = [
            'attributes' => 'required',
            'quantity' => 'required|numeric|min:0',
            'price' => 'required|numeric|min:0',
        ];

        $validator = Validator::make($request, $rules);
        return self::validationResponse($validator, $token, 'inventory');
    }

    public static function inventoryQuantity($request)
    {
        $rules = [
            'quantity' => 'required|numeric|min:0',
            'product_id' => 'required|numeric'
        ];

        return self::validationMessage($request, $rules, 'inventory');
    }

    public static function inventoryValue($request)
    {
        $rules = [
            'attributes' => 'required',
            'product_id' => 'required|numeric'
        ];

        return self::validationMessage($request, $rules, 'inventory');
    }


    public static function install($request){
        $rules = [
            'appName' => 'required',
            'dbName' => 'required',
            'dbUser' => 'required'
        ];
        return self::validationMessage($request, $rules);
    }

    public static function subCategoryImage($request){
        $rules = [
            'category_id' => 'required|numeric|min:0|not_in:0'
        ];

        array_push($rules, self::imageRules());

        return self::validationMessage($request, $rules, 'image');
    }

    public static function productPreviewImage($request)
    {
        $rules = [
            'category_id' => 'required|numeric|min:0|not_in:0',
            'tax_rule_id' => 'required|numeric|min:0|not_in:0',
            'shipping_rule_id' => 'required|numeric|min:0|not_in:0'
        ];

        array_push($rules, self::imageRules());

        return self::validationMessage($request, $rules, 'image');
    }


    public static function image($request, $errorType = 'image')
    {
        if(env('MEDIA_STORAGE') == config('env.media.URL')) {
            $rules = [
                'photo' => 'required',
            ];
            return self::validationMessage($request, $rules, $errorType);

        } else {
            return self::validationMessage($request, self::imageRules(), $errorType);
        }

    }

    public static function video($request, $errorType = 'video')
    {
        if(env('MEDIA_STORAGE') == config('env.media.URL')) {
            $rules = [
                'video_file' => 'required',
                'thumb' => 'required',
            ];
            return self::validationMessage($request, $rules, $errorType);

        } else {
            return self::validationMessage($request, self::videoRules(), $errorType);
        }
    }


    public static function multipleImages($request, $token){
        $validator = Validator::make($request, self::imageRules());

        return self::validationResponse($validator, $token, 'multiple_image');
    }

    public static function success($request, $message = "Success", $data = null, $status = 200){
        return response()->json(new Response($request->token, $data, $status, @$message));
    }

    public static function imageRules(){
        return ['photo' => 'required|file|image|mimes:jpeg,png,gif,svg,webp|max:1024'];
    }

    public static function videoRules(){
        return ['file'  => 'mimes:mp4,mov,ogg,qt | max:20000'];
    }


    public static function validationMessage($request, $rules, $error_type = 'form'){
        $validator = Validator::make($request->all(), $rules);

        return self::validationResponse($validator, $request->token, $error_type);
    }

    public static function validationResponse($validator, $token, $error_type = 'form'){
        if ($validator->fails()){

            return new Response($token, [$error_type => Utils::formatErrors($validator->errors()->messages())], 201);

        }

        return false;
    }
}
