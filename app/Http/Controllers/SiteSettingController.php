<?php

namespace App\Http\Controllers;

use App\Models\Helper\ControllerHelper;
use App\Models\Helper\FileHelper;
use App\Models\Helper\Response;
use App\Models\Helper\Utils;
use App\Models\Helper\Validation;
use App\Models\SiteSetting;
use App\Models\SiteSettingLang;
use Illuminate\Http\Request;

class SiteSettingController extends ControllerHelper
{
    public function find(Request $request)
    {
        try {

            $lang = $request->header('language');


            if ($can = Utils::userCan($this->user, 'site_setting.view')) {
                return $can;
            }

            $query = SiteSetting::query();
            if ($lang) {
                $query = $query->leftJoin('site_setting_langs as cl', function ($join) use ($lang) {
                    $join->on('cl.site_setting_id', '=', 'site_settings.id');
                    $join->where('cl.lang', $lang);
                });
                $query = $query->select('site_settings.*', 'cl.site_name', 'cl.copyright_text',
                    'cl.meta_title', 'cl.meta_description'
                );
            }
            $data = $query->first();


            return response()->json(new Response($request->token, $data));


        } catch (\Exception $ex) {
            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }

    }


    public function action(Request $request)
    {

        try {

            $lang = $request->header('language');

            if ($can = Utils::userCan($this->user, 'site_setting.edit')) {
                return $can;
            }

            $validate = Validation::siteSetting($request);
            if ($validate) {
                return response()->json($validate);
            }

            $admin_id = $request->user()->id;
            $data = SiteSetting::first();

            $request['created_at'] = null;
            $request['updated_at'] = null;
            $request['admin_id'] = $admin_id;

            $filtered = array_filter($request->all(), function ($element) {
                return '' !== trim($element);
            });


            if (!$data) {


                if ($lang) {
                    [$langData, $mainData] = Utils::seperateLangData($filtered, [
                        'site_name', 'copyright_text', 'meta_title', 'meta_description'
                    ]);
                    $siteSetting = SiteSetting::create($mainData);

                    $langData['site_setting_id'] = $siteSetting->id;
                    $langData['lang'] = $lang;
                    SiteSettingLang::create($langData);

                } else {
                    SiteSetting::create($filtered);

                }

            } else {


                if ($lang) {
                    [$langData, $mainData] = Utils::seperateLangData($filtered, [
                        'site_name', 'copyright_text', 'meta_title', 'meta_description'
                    ]);
                    SiteSetting::where('id', $data->id)->update($mainData);
                    $existingLang = SiteSettingLang::where('site_setting_id', $data->id)
                        ->where('lang', $lang)->first();

                    if (!$existingLang) {
                        $langData['site_setting_id'] = $data->id;
                        $langData['lang'] = $lang;
                        SiteSettingLang::create($langData);

                    } else {
                        SiteSettingLang::where('id', $existingLang->id)->update($langData);
                    }
                } else {



                    SiteSetting::where('id', $data->id)->update([
                        'site_name' => $request->site_name,
                        'site_url' => $request->site_url,
                        'meta_title' => $request->meta_title,
                        'meta_description' => $request->meta_description,
                        'copyright_text' => $request->copyright_text,
                        'primary_color' => $request->primary_color,
                        'primary_hover_color' => $request->primary_hover_color,
                        'styling' => $request->styling
                    ]);
                }

            }


            $query = SiteSetting::query();
            if ($lang) {
                $query = $query->leftJoin('site_setting_langs as cl', function ($join) use ($lang) {
                    $join->on('cl.site_setting_id', '=', 'site_settings.id');
                    $join->where('cl.lang', $lang);
                });
                $query = $query->select('site_settings.*', 'cl.copyright_text', 'cl.site_name',
                    'cl.meta_title', 'cl.meta_description'
                );
            }
            $data = $query->first();

            $data['id'] = null;


            return response()->json(new Response($request->token, $data));


        } catch (\Exception $ex) {
            return response()->json(Validation::error(null, explode('.', $ex->getMessage())[0]));
        }



    }


    public function upload(Request $request)
    {
        try {

            $lang = $request->header('language');

            if ($can = Utils::userCan($this->user, 'site_setting.edit')) {
                return $can;
            }


            $validate = Validation::image($request);
            if ($validate) {
                return response()->json($validate);
            }

            $image_info = FileHelper::uploadImage($request['photo'], $request['type']);

            $existingSetting = SiteSetting::first();

            if (SiteSetting::where('id', $existingSetting->id)->update([request('type') => $image_info['name']])) {


                if ($existingSetting[request('type')]) {
                    FileHelper::deleteFile($existingSetting[request('type')]);
                }
                $existingSetting[request('type')] = $image_info['name'];



                $query = SiteSetting::query();
                if ($lang) {
                    $query = $query->leftJoin('site_setting_langs as cl', function ($join) use ($lang) {
                        $join->on('cl.site_setting_id', '=', 'site_settings.id');
                        $join->where('cl.lang', $lang);
                    });
                    $query = $query->select('site_settings.*', 'cl.site_name', 'cl.copyright_text',
                        'cl.meta_title', 'cl.meta_description'
                    );
                }
                $data = $query->first();

                return response()->json(new Response($request->token, $data));
            }

            return response()->json(Validation::errorTokenLang($request->token, $lang));

        } catch (\Exception $ex) {
            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }


    }

}
