<?php

namespace App\Http\Controllers;

use App\Models\Helper\ControllerHelper;
use App\Models\Helper\MailHelper;
use App\Models\Helper\Response;
use App\Models\Helper\Utils;
use App\Models\Helper\Validation;
use App\Models\SubscriptionEmail;
use App\Models\SubscriptionEmailFormat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class SubscriptionEmailsController extends ControllerHelper
{

    public function allSubscribers(Request $request)
    {
        try {

            $data = SubscriptionEmail::orderBy('created_at')->get(['id', 'email']);
            return response()->json(new Response($request->token, $data));

        } catch (\Exception $ex) {
            return response()->json(Validation::error(null, explode('.', $ex->getMessage())[0]));
        }
    }


    public function emailSubscription(Request $request)
    {
        try {

            $validate = Validation::emailSubscription($request);
            if ($validate) {
                return response()->json($validate);
            }

            $existingEmail = SubscriptionEmail::where('email', $request->email)->first();

            if (is_null($existingEmail)) {
                SubscriptionEmail::create($request->all());
            }

            return response()->json(new Response('', true));
        } catch (\Exception $ex) {
            return response()->json(Validation::error(null, explode('.', $ex->getMessage())[0]));
        }
    }


    public function all(Request $request)
    {
        try {
            if ($can = Utils::userCan($this->user, 'subscriber.view')) {
                return $can;
            }

            if ($request->q) {
                $data = SubscriptionEmail::query()
                    ->orderBy($request->orderby, $request->type)
                    ->where('email', 'LIKE', "%{$request->q}%")
                    ->paginate(Config::get('constants.api.PAGINATION'));

            } else {
                $data = SubscriptionEmail::orderBy($request->orderby, $request->type)
                    ->paginate(Config::get('constants.api.PAGINATION'));
            }

            foreach ($data as $item) {
                $item['created'] = Utils::formatDate($item->created_at);
            }
            return response()->json(new Response($request->token, $data));
        } catch (\Exception $ex) {
            return response()->json(Validation::error(null, explode('.', $ex->getMessage())[0]));
        }
    }


    public function delete(Request $request, $id)
    {
        try {

            $lang = $request->header('language');

            if ($can = Utils::userCan($this->user, 'subscriber.delete')) {
                return $can;
            }


            $subscriptionEmail = SubscriptionEmail::find($id);

            if (is_null($subscriptionEmail)) {
                return response()->json(Validation::noDataLang($lang));
            }

            if ($subscriptionEmail->delete()) {
                return response()->json(new Response($request->token, $subscriptionEmail));
            }

            return response()->json(Validation::errorTokenLang($request->token, $lang));

        } catch (\Exception $ex) {
            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }
    }

    public function sendSubscriptionEmail(Request $request)
    {
        try {

            $lang = $request->header('language');


            if ($can = Utils::userCan($this->user, 'subscriber.view')) {
                return $can;
            }


            $subscriptionEmailFormat = SubscriptionEmailFormat::find($request->id);

            if (is_null($subscriptionEmailFormat)) {
                return response()->json(Validation::error($request->token,
                    __('lang.email_format', [], $lang)
                ));
            }

            $subscribers = SubscriptionEmail::get();

            if (count($subscribers) < 1) {
                return response()->json(Validation::error($request->token,
                    __('lang.no_subscriber', [], $lang)
                ));
            }

            $subscribers = MailHelper::sendingSubscriptionEmail($subscriptionEmailFormat->subject,
                $subscriptionEmailFormat->body, $subscribers, $lang);

            return response()->json(new Response($request->token, $subscribers));

        } catch (\Exception $ex) {
            return response()->json(Validation::error($request->token, explode('.', $ex->getMessage())[0]));
        }
    }


}
