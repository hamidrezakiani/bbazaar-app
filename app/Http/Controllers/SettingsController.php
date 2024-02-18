<?php

namespace App\Http\Controllers;

use App\Models\Helper\ControllerHelper;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Models\Helper\Response;
use App\Models\Helper\Utils;
use App\Models\Helper\Validation;
use App\Models\Helper\FileHelper;
use Illuminate\Support\Facades\Artisan;

class SettingsController extends ControllerHelper
{

    public function find(Request $request)
    {
        try {
            if ($can = Utils::userCan($this->user, 'setting.view')) {
                return $can;
            }

            $data = Setting::first();
            return response()->json(new Response($request->token, $data));


        } catch (\Exception $ex) {
            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }
    }


    public function smtpFind(Request $request)
    {
        try {
            if ($can = Utils::userCan($this->user, 'setting.view')) {
                return $can;
            }

            $data['smtpHost'] = env('MAIL_HOST');
            $data['smtpPort'] = env('MAIL_PORT');
            $data['smtpUsername'] = env('MAIL_USERNAME');
            $data['smtpPassword'] = env('MAIL_PASSWORD');
            $data['smtpEncryption'] = env('MAIL_ENCRYPTION');
            $data['mailFrom'] = env('MAIL_FROM_ADDRESS');


            return response()->json(new Response($request->token, $data));


        } catch (\Exception $ex) {
            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }
    }


    public function mediaStorageFind(Request $request)
    {
        try {


            if ($can = Utils::userCan($this->user, 'setting.view')) {
                return $can;
            }

            $data['mediaStorage'] = env('MEDIA_STORAGE');
            $data['thumbPrefix'] = env('THUMB_PREFIX');
            $data['defaultImage'] = env('DEFAULT_IMAGE');
            $data['cdnUrl'] = env('CDN_URL');
            $data['gcProjectId'] = env('GOOGLE_CLOUD_PROJECT_ID');
            $data['gcStorageBucket'] = env('GOOGLE_CLOUD_STORAGE_BUCKET');
            $data['gcStoragePathPrefix'] = env('GOOGLE_CLOUD_STORAGE_PATH_PREFIX');


            return response()->json(new Response($request->token, $data));


        } catch (\Exception $ex) {
            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }
    }


    public function socialLoginFind(Request $request)
    {

        try {
            if ($can = Utils::userCan($this->user, 'setting.view')) {
                return $can;
            }

            $data['googleClientId'] = env('GOOGLE_CLIENT_ID');
            $data['googleClientSecret'] = env('GOOGLE_CLIENT_SECRET');

            $data['facebookClientId'] = env('FACEBOOK_CLIENT_ID');
            $data['facebookClientSecret'] = env('FACEBOOK_CLIENT_SECRET');

            return response()->json(new Response($request->token, $data));


        } catch (\Exception $ex) {
            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }
    }


    public function smtpAction(Request $request)
    {
        try {


            if ($can = Utils::userCan($this->user, 'setting.edit')) {
                return $can;
            }


            $db = [
                "MAIL_HOST" => "smtpHost",
                "MAIL_PORT" => "smtpPort",
                "MAIL_USERNAME" => "smtpUsername",
                "MAIL_PASSWORD" => "smtpPassword",
                "MAIL_ENCRYPTION" => "smtpEncryption",
                "MAIL_FROM_ADDRESS" => "mailFrom"
            ];
            $path = base_path('.env');
            if (file_exists($path)) {

                Artisan::call('config:clear');
                Artisan::call('route:clear ');
                Artisan::call('cache:clear');
                Artisan::call('view:clear');

                foreach ($db as $key => $value) {
                    file_put_contents($path, str_replace(
                        $key . '=' . env($key), $key . '=' . request($value), file_get_contents($path)
                    ));
                }
            }

            return response()->json(new Response($request->token, $request->all()));


        } catch (\Exception $ex) {
            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }
    }


    public function mediaStorageAction(Request $request)
    {

        try {


            if ($can = Utils::userCan($this->user, 'setting.edit')) {
                return $can;
            }

            $db = [
                "MEDIA_STORAGE" => "mediaStorage",
                "THUMB_PREFIX" => "thumbPrefix",
                "DEFAULT_IMAGE" => "defaultImage"
            ];

            if ($request->mediaStorage == config('env.media.URL')) {

                $db["CDN_URL"] = "cdnUrl";

            } else if ($request->mediaStorage == config('env.media.GCS')) {

                $db["CDN_URL"] = "cdnUrl";

                $db["GOOGLE_CLOUD_PROJECT_ID"] = "gcProjectId";
                $db["GOOGLE_CLOUD_STORAGE_BUCKET"] = "gcStorageBucket";
                $db["GOOGLE_CLOUD_STORAGE_PATH_PREFIX"] = "gcStoragePathPrefix";
            }

            $path = base_path('.env');
            if (file_exists($path)) {

                Artisan::call('config:clear');
                Artisan::call('route:clear ');
                Artisan::call('cache:clear');
                Artisan::call('view:clear');

                foreach ($db as $key => $value) {
                    file_put_contents($path, str_replace(
                        $key . '=' . env($key), $key . '=' . request($value), file_get_contents($path)
                    ));
                }
            }

            return response()->json(new Response($request->token, $request->all()));


        } catch (\Exception $ex) {
            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }
    }


    public function socialLoginAction(Request $request)
    {
        try {


            if ($can = Utils::userCan($this->user, 'setting.edit')) {
                return $can;
            }

            $db = [
                "GOOGLE_CLIENT_ID" => "googleClientId",
                "GOOGLE_CLIENT_SECRET" => "googleClientSecret",
                "FACEBOOK_CLIENT_ID" => "facebookClientId",
                "FACEBOOK_CLIENT_SECRET" => "facebookClientSecret"
            ];
            $path = base_path('.env');
            if (file_exists($path)) {

                Artisan::call('config:clear');
                Artisan::call('route:clear ');
                Artisan::call('cache:clear');
                Artisan::call('view:clear');

                foreach ($db as $key => $value) {
                    file_put_contents($path, str_replace(
                        $key . '=' . env($key), $key . '=' . request($value), file_get_contents($path)
                    ));
                }
            }

            return response()->json(new Response($request->token, $request->all()));


        } catch (\Exception $ex) {
            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }
    }


    public function address(Request $request)
    {

        try {


            $lang = $request->header('language');

            if ($can = Utils::userCan($this->user, 'setting.edit')) {
                return $can;
            }

            $validate = Validation::address($request);
            if ($validate) {
                return response()->json($validate);
            }

            $admin_id = $request->user()->id;
            $data = Setting::first();

            $setting['admin_id'] = $admin_id;
            $setting['address_1'] = request('address_1');
            $setting['address_2'] = request('address_2');
            $setting['phone'] = request('phone');
            $setting['email'] = request('email');
            $setting['city'] = request('city');
            $setting['state'] = request('state');
            $setting['zip'] = request('zip');
            $setting['country'] = request('country');



            if (!$data) {
                if (Setting::create($setting)) {
                    return response()->json(new Response($request->token, $setting));
                }
            } else {
                if (Setting::where('id', $data->id)->update($setting)) {
                    return response()->json(new Response($request->token, $setting));
                }
            }

            return response()->json(Validation::errorTokenLang($request->token, $lang));


        } catch (\Exception $ex) {
            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }

    }


    public function currency(Request $request)
    {

        try {

            $lang = $request->header('language');
            $validate = Validation::currency($request);
            if ($validate) {
                return response()->json($validate);
            }

            $data = Setting::where('admin_id', $this->user->id)->first();

            $setting['currency'] = $request['currency'];
            $setting['currency_icon'] = $request['currency_icon'];
            $setting['currency_position'] = $request['currency_position'];

            if (is_null($data)) {
                $setting['admin_id'] = $this->user->id;
                if (Setting::create($setting)) {
                    return response()->json(new Response($request->token, $setting));
                }

            } else {

                if (Setting::where('id', $data->id)->update($setting)) {
                    return response()->json(new Response($request->token, $setting));
                }
            }

            return response()->json(Validation::errorTokenLang($request->token,$lang));


        } catch (\Exception $ex) {
            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }


    }


    public function convert(Request $request, $imageName)
    {
        try {
            $content = FileHelper::imageToBase64($imageName);

            if (is_string($content)) {
                return response()->json(new Response($request->token, $content));
            }
            return $content;


        } catch (\Exception $ex) {
            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }
    }


    public function uploadLogo(Request $request)
    {
        try {
            $lang = $request->header('language');


            if ($can = Utils::userCan($this->user, 'setting.edit')) {
                return $can;
            }

            $validate = Validation::image($request);
            if ($validate) {
                return response()->json($validate);
            }

            $image_info = FileHelper::uploadImage($request['photo'], 'logo');

            $existingSetting = Setting::find($request->id);

            if (Setting::where('id', $request->id)->update(['logo' => $image_info['name']])) {
                if ($existingSetting->logo) {
                    FileHelper::deleteFile($existingSetting->logo);
                }
                $existingSetting->logo = $image_info['name'];
                return response()->json(new Response($request->token, $existingSetting));
            }

            return response()->json(Validation::errorTokenLang($request->token, $lang));

        } catch (\Exception $ex) {
            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }


    }
}
