<?php

namespace App\Http\Controllers;

use App\Models\Helper\ControllerHelper;
use App\Models\Helper\Response;
use App\Models\Helper\Utils;
use App\Models\Helper\Validation;
use App\Models\SubscriptionEmailFormat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class SubscriptionEmailFormatsController extends ControllerHelper
{
    public function all(Request $request)

    {

        try {

            if ($can = Utils::userCan($this->user, 'subscription_email_format.view')) {
                return $can;
            }


            $pagination = Config::get('constants.api.PAGINATION');
            if ($request->count) {
                $pagination = $request->count;
            }

            if (!$request->type) {
                $request->type = 'desc';
            }

            if (!$request->orderby) {
                $request->orderby = 'created_at';
            }

            $query = SubscriptionEmailFormat::query();
            if ($request->q) {
                $query = $query->where('subject', 'LIKE', "%{$request->q}%");
                $query = $query->orWhere('title', 'LIKE', "%{$request->q}%");
            } else {
                $query = $query->orderBy($request->orderby, $request->type);
            }
            $query = $query->select('id', 'title', 'body', 'subject');
            $data = $query->paginate($pagination);

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
            return response()->json(Validation::error(null, explode('.', $ex->getMessage())[0]));
        }
    }


    public function allEmailFormats(Request $request)
    {
        try {
            $data = SubscriptionEmailFormat::orderBy('created_at')->get();
            return response()->json(new Response($request->token, $data));

        } catch (\Exception $ex) {
            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }
    }


    public function find(Request $request, $id)
    {
        try {
            $lang = $request->header('language');
            if ($can = Utils::userCan($this->user, 'subscription_email_format.view')) {
                return $can;
            }

            $data = SubscriptionEmailFormat::find($id);

            if (is_null($data)) {
                return response()->json(Validation::noDataLang($lang));
            }

            if ($request->time_zone) {
                $data['created'] = Utils::formatDate(Utils::convertTimeToUSERzone($data->created_at, $request->time_zone));

            } else {
                $data['created'] = Utils::formatDate($data->created_at);
            }

            return response()->json(new Response($request->token, $data));


        } catch (\Exception $ex) {
            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }
    }


    public function action(Request $request, SubscriptionEmailFormat $subscriptionEmailFormat)
    {
        try {
            $validate = Validation::subscriptionEmail($request);
            if ($validate) {
                return response()->json($validate);
            }

            if ($subscriptionEmailFormat->id) {
                if ($can = Utils::userCan($this->user, 'subscription_email_format.edit')) {
                    return $can;
                }

                $existing = SubscriptionEmailFormat::find($subscriptionEmailFormat->id);
                if (!$this->isSuperAdmin && $isOwner = Utils::isDataOwner($this->user, $existing)) {
                    return $isOwner;
                }

                $filtered = array_filter($request->all(), function ($element) {
                    return '' !== trim($element);
                });

                $subscriptionEmailFormat->update(array_filter($filtered));

            } else {
                if ($can = Utils::userCan($this->user, 'subscription_email_format.create')) {
                    return $can;
                }

                $request['image'] = Config::get('constants.media.DEFAULT_IMAGE');
                $request['admin_id'] = $request->user()->id;
                $subscriptionEmailFormat = SubscriptionEmailFormat::create($request->all());
            }

            $subscriptionEmailFormat['created'] = Utils::formatDate($subscriptionEmailFormat->created_at);

            return response()->json(new Response($request->token, $subscriptionEmailFormat));


        } catch (\Exception $ex) {
            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }
    }


    public function delete(Request $request, $id)
    {
        try {

            $lang = $request->header('language');

            if ($can = Utils::userCan($this->user, 'subscription_email_format.delete')) {
                return $can;
            }

            $subscriptionEmailFormat = SubscriptionEmailFormat::find($id);

            if (is_null($subscriptionEmailFormat)) {
                return response()->json(Validation::noDataLang($lang));
            }

            if ($subscriptionEmailFormat->delete()) {
                return response()->json(new Response($request->token, $subscriptionEmailFormat));
            }

            return response()->json(Validation::errorTokenLang($request->token, $lang));

        } catch (\Exception $ex) {
            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }
    }
}
