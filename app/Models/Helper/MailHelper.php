<?php

namespace App\Models\Helper;

use App\Models\AttributeValue;
use App\Models\Order;
use App\Models\SiteSetting;
use App\Models\SubscriptionEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use PDF;
use Mail;
use App\Mail\EmailSender;
use App\Models\Setting;

class MailHelper
{

    public static function sendingSubscriptionEmail($subject, $body, $subscribers, $lang = null)
    {
        try {



            $setting = Setting::get()->first();
            $siteSetting = SiteSetting::get()->first();


            $objDemo = MailHelper::prepareEmailData($setting, $siteSetting);
            $objDemo->logo_base64 = FileHelper::imageToBase64($objDemo->image);

            $emails = [];
            foreach ($subscribers as $i) {
                if (!is_null($i->email)) {
                    array_push($emails, $i->email);
                }
            }


            Mail::send('mail_templates.subscription', ['setting' => $objDemo, 'body' => $body, 'lang' => $lang],
                function ($message) use ($objDemo, $subject, $emails) {
                    $message->to($emails)
                        ->subject($subject);

                });
        } catch (\Exception $ex) {
            throw new \Exception($ex);
        }
        return true;
    }

    public static function sendingOrderEmail($request, $id, $lang = null)
    {
        $query = Order::query();

        $query = $query->with('cancellation');
        $query = $query->with('user');
        $query = $query->with('guest_user');

        $query = $query->with('address');
        $query = $query->with('ordered_products.shipping_place');


        if($lang){

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
            $query = $query->with('ordered_products.updated_inventory.inventory_attributes.attribute_value.attribute');
            $query = $query->with('voucher');

        }


        $order = $query->find($id);

        if (is_null($order)) {
            return null;
        }

        if ($request->time_zone) {
            $order['created'] = Utils::formatDate(Utils::convertTimeToUSERzone($order->created_at, $request->time_zone));
        } else {
            $order['created'] = Utils::formatDate($order->created_at);
        }

        $order['formatted_address'] = Utils::formatAddress($order->address);
        $order['order_method'] = Config::get('constants.paymentMethodIn')[$order['order_method']];
        $order['calculated_price'] = Utils::calcPrice($order);


        if ($request->user('user')) {

            $objDemo = MailHelper::emailData($order->user->name);

        } else if($request->user_token){

            $objDemo = MailHelper::emailData($order->guest_user->name);

        }



        $objDemo->logo_base64 = FileHelper::imageToBase64($objDemo->image);

        return ['setting' => $objDemo, 'order' => $order, 'lang' => $lang];
    }

    public static function shippingPrice($shipping, $type)
    {
        if ((int)$type === Config::get('constants.shippingTypeIn.LOCATION')) {
            return (float)$shipping->price;
        } else if ((int)$type === Config::get('constants.shippingTypeIn.PICKUP')) {
            return (float)$shipping->pickup_price;
        }
    }

    public static function generatingAttribute($order)
    {
        $attributes = $order->updated_inventory->inventory_attributes;
        $attrStr = [];
        foreach ($attributes as $i) {
            array_push($attrStr, $i->attribute_value->attribute->title . ': ' . $i->attribute_value->title);
        }
        return join(', ', $attrStr);
    }


    public static function order($id)
    {
        $order = Order::with('ordered_products.product')
            ->with('cancellation')
            ->with('ordered_products.updated_inventory.inventory_attributes.attribute_value.attribute')
            ->with('voucher')
            ->with('user')
            ->with('guest_user')
            ->with('address')
            ->with('ordered_products.shipping_place')
            ->find($id);

        $order['created'] = Utils::formatDate($order->created_at);
        $order['formatted_address'] = Utils::formatAddress($order->address);
        $order['order_method'] = Config::get('constants.paymentMethodIn')[$order['order_method']];
        $order['calculated_price'] = Utils::calcPrice($order);

        return $order;
    }

    public static function emailData($receiver)
    {
        $setting = Setting::first();
        $siteSetting = SiteSetting::first();

        $objDemo = new \stdClass();
        $objDemo->currency_icon = $setting->currency_icon;
        $objDemo->receiver = $receiver;
        $objDemo->address = Utils::formatAddress($setting);
        $objDemo->logo = FileHelper::imageLink($siteSetting->email_logo);
        $objDemo->image = $siteSetting->email_logo;
        $objDemo->phone = $setting && $setting->phone ? $setting->phone : 'N/A';
        $objDemo->store_name = $siteSetting->site_name;
        return $objDemo;
    }

    public static function prepareEmailData($setting, $siteSetting)
    {
        $objDemo = new \stdClass();
        $objDemo->currency_icon = $setting->currency_icon;
        $objDemo->address = Utils::formatAddress($setting);
        $objDemo->logo = FileHelper::imageLink($siteSetting->email_logo);
        $objDemo->image = $siteSetting->email_logo;
        $objDemo->phone = $setting && $setting->phone ? $setting->phone : 'N/A';
        $objDemo->store_name = $siteSetting->site_name;
        return $objDemo;
    }


    public static function orderPlaced($user, $orderId)
    {
        try {

            $order = MailHelper::order($orderId);
            $objDemo = MailHelper::emailData($order->user->name);
            $objDemo->logo_base64 = FileHelper::imageToBase64($objDemo->image);


            $pdf = PDF::loadView('mail_templates.order_pdf', ['order' => $order, 'setting' => $objDemo])
                ->setPaper('a4', 'potrait')->setWarnings(false);

            Mail::send('mail_templates.order_placed', ['setting' => $objDemo, 'order' => $order],
                function ($message) use ($objDemo, $pdf, $order, $user) {
                    $message->to($user->email, $user->name)
                        ->subject(
                            __('lang.confirmation', ['store' => $objDemo->store_name])
                        )
                        ->attachData($pdf->output(), Utils::orderId($order) . ".pdf");

                });
            // Mail::to($user->email)->send(new EmailSender($objDemo, 'mail_templates.order_placed'));
        } catch (\Exception $ex) {
            throw new \Exception($ex);
        }
        return true;
    }


    public static function codeSender($request, $type = 'registration', $subject = null, $lang = null)
    {
        if (!$subject) {
            $subject = __('lang.almost_there', [], $lang);
        }

        if (is_null($type)) {
            $type = 'registration';
        }

        $bladeTemplate = 'mail_templates.user_registration';
        switch ($type) {
            case 'registration':
                break;
            case 'forgot_password':
                $bladeTemplate = 'mail_templates.forgot_password';
                break;
        }

        $setting = Setting::first();
        $query = SiteSetting::query();

        if ($lang) {

            // SETTING
            $query = $query->leftJoin('site_setting_langs as cl', function ($join) use ($lang) {
                $join->on('cl.site_setting_id', '=', 'site_settings.id');
                $join->where('cl.lang', $lang);
            })
                ->select('site_settings.*', 'cl.site_name', 'cl.copyright_text', 'cl.meta_title',
                    'cl.meta_description');
        }

        $siteSetting = $query->first();


        $objDemo = new \stdClass();
        $objDemo->code = rand(1000, 9999);
        $objDemo->receiver = $request->name;

        $objDemo->address = Utils::formatAddress($setting);

        $objDemo->phone = $setting && $setting->phone ? $setting->phone : 'N/A';
        $objDemo->store_name = $siteSetting->site_name;

        try {

            Mail::send($bladeTemplate, ['data' => $objDemo, 'lang' => $lang],
                function ($message) use ($request, $subject) {
                    $message->to($request->email, $request->name)
                        ->subject($subject);

                });


        } catch (\Exception $ex) {
            throw new \Exception($ex);
        }
        return $objDemo->code;
    }
}
