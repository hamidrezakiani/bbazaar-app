<?php

namespace App\Http\Controllers;

use App\Models\ContactUs;
use App\Models\Helper\ControllerHelper;
use App\Models\Helper\Response;
use App\Models\Helper\Utils;
use App\Models\Helper\Validation;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class ContactUsController extends ControllerHelper
{
    public function all(Request $request)
    {
        try {


            if ($can = Utils::userCan($this->user, 'message.view')) {
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

            $query = ContactUs::query();
            if ($request->q) {
                $query = $query->where('subject', 'LIKE', "%{$request->q}%");
                $query = $query->orWhere('name', 'LIKE', "%{$request->q}%");
                $query = $query->orWhere('email', 'LIKE', "%{$request->q}%");
            } else {
                $query = $query->orderBy($request->orderby, $request->type);
            }
            $query = $query->select('id', 'name', 'email', 'subject', 'replied', 'viewed');
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

            ContactUs::where('viewed', '!=', Config::get('constants.status.PUBLIC'))
                ->update(['viewed' => Config::get('constants.status.PUBLIC')]);

            return response()->json(new Response($request->token, $data));

        } catch (\Exception $ex) {
            return response()->json(Validation::error(null, explode('.', $ex->getMessage())[0]));
        }
    }

    public function find(Request $request, $id)
    {
        try {

            $lang = $request->header('language');

            if ($can = Utils::userCan($this->user, 'message.view')) {
                return $can;
            }

            $data = ContactUs::find($id);

            if (is_null($data)) {
                return response()->json(Validation::noDataLang($lang));
            }

            if ($request->time_zone) {
                $data['created'] = Utils::formatDate(Utils::convertTimeToUSERzone($data->created_at,
                    $request->time_zone));

            } else {
                $data['created'] = Utils::formatDate($data->created_at);
            }

            return response()->json(new Response($request->token, $data));


        } catch (\Exception $ex) {
            return response()->json(Validation::error(null, explode('.', $ex->getMessage())[0]));
        }
    }


    public function action(Request $request, ContactUs $contactUs)
    {
        try {

            $validate = Validation::contactUs($request);
            if ($validate) {
                return response()->json($validate);
            }

            $filtered = array_filter($request->all(), function ($element) {
                return '' !== trim($element);
            });

            $contactUs->update(array_filter($filtered));

            $contactUs['created'] = Utils::formatDate($contactUs->created_at);

            return response()->json(new Response($request->token, $contactUs));


        } catch (\Exception $ex) {
            return response()->json(Validation::error(null, explode('.', $ex->getMessage())[0]));
        }
    }


    public function delete(Request $request, $id)
    {

        try {

            $lang = $request->header('language');

            if ($can = Utils::userCan($this->user, 'message.delete')) {
                return $can;
            }

            $contactUs = ContactUs::find($id);

            if (is_null($contactUs)) {
                return response()->json(Validation::noDataLang($lang));
            }

            if ($contactUs->delete()) {
                return response()->json(new Response($request->token, $contactUs));
            }

            return response()->json(Validation::errorTokenLang($request->token, $lang));

        } catch (\Exception $ex) {
            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }


    }
}
