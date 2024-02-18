<?php

namespace App\Http\Controllers;

use App\Models\Helper\ControllerHelper;
use App\Models\Helper\Response;
use App\Models\Helper\Utils;
use App\Models\Helper\Validation;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class LanguageController extends ControllerHelper
{

    public function languages(Request $request)
    {

        try {

            $languages = Language::where('status', Config::get('constants.status.PUBLIC'))
                ->orderBy('default', 'DESC')
                ->orderBy('created_at', 'DESC')
                ->select('name', 'code', 'default', 'direction', 'predefined')
                ->get();

            $data['languages'] = $languages;

            if (count($languages) > 0) {
                $data['default_language'] = $languages[0];
            }

            return response()->json(new Response($request->token, $data));


        } catch (\Exception $ex) {
            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }
    }


    public function all(Request $request)
    {

        try {

            if ($can = Utils::userCan($this->user, 'language.view')) {
                return $can;
            }

            $query = Language::orderBy($request->orderby, $request->type);
            if ($this->isVendor) {
                $query = $query->where('admin_id', $this->user->id);
            }

            if ($request->q) {
                $query = $query->where('name', 'LIKE', "%{$request->q}%");
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


    public function find(Request $request, $id)
    {
        try {

            $lang = $request->header('language');


            if ($can = Utils::userCan($this->user, 'language.view')) {
                return $can;
            }
            $data = Language::find($id);
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


    public function action(Request $request, Language $language)
    {

        try {

            $lang = $request->header('language');
            $validate = Validation::language($request);
            if ($validate) {
                return response()->json($validate);
            }

            $existingLang = Language::where('code', $request['code'])->first();


            if (($existingLang && !$request['id'] && $existingLang->code) ||
                ($existingLang && $request['id'] != $existingLang->id && $existingLang->code == $request['code'])
            ) {
                return response()->json(Validation::error($request->token,
                    __('lang.language_exists', [], $lang)
                ));
            }

            if ($language->id) {
                if ($can = Utils::userCan($this->user, 'language.edit')) {
                    return $can;
                }

                $existing = Language::find($language->id);

                if (!$this->isSuperAdmin && $isOwner = Utils::isDataOwner($this->user, $existing)) {
                    return $isOwner;
                }

                $request['created_at'] = null;
                $request['updated_at'] = null;


                $language->update($request->all());

            } else {


                if ($can = Utils::userCan($this->user, 'language.create')) {
                    return $can;
                }
                $request['admin_id'] = $request->user()->id;
                $language = Language::create($request->all());
            }

            $language['created'] = Utils::formatDate($language->created_at);
            return response()->json(new Response($request->token, $language));


        } catch (\Exception $ex) {
            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }
    }


    public function delete(Request $request, $id)
    {
        try {
            $lang = $request->header('language');


            if ($can = Utils::userCan($this->user, 'language.delete')) {
                return $can;
            }
            $language = Language::find($id);

            if (!$this->isSuperAdmin && $isOwner = Utils::isDataOwner($this->user, $language)) {
                return $isOwner;
            }

            if (is_null($language)) {
                return response()->json(Validation::noDataLang($lang));
            }

            if ($language->delete()) {
                return response()->json(new Response($request->token, $language));
            }

            return response()->json(Validation::errorTokenLang($request->token, $lang));

        } catch (\Exception $ex) {
            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }
    }
}
