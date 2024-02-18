<?php

namespace App\Http\Controllers;

use App\Models\Helper\ControllerHelper;
use App\Models\Helper\FileHelper;
use App\Models\Helper\Response;
use App\Models\Helper\Utils;
use App\Models\Helper\Validation;
use App\Models\Store;
use App\Models\StoreLang;
use Illuminate\Http\Request;

class StoreController extends ControllerHelper
{
    public function find(Request $request)
    {
        try {

            $lang = $request->header('language');

            $query = Store::query();
            if ($lang) {
                $query = $query->leftJoin('store_langs as cl', function ($join) use ($lang) {
                    $join->on('cl.store_id', '=', 'stores.id');
                    $join->where('cl.lang', $lang);
                });
                $query = $query->select('stores.*', 'cl.name', 'cl.meta_title', 'cl.meta_description');
            }
            $query = $query->where('stores.admin_id', $this->user->id);
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

            $validate = Validation::store($request);
            if ($validate) {
                return response()->json($validate);
            }

            $data = Store::where('admin_id', $this->user->id)->first();

            $bySlug = Store::where('slug', $request['slug'])->first();


            $request['created_at'] = $request['updated_at'] = '';

            $filtered = array_filter($request->all(), function ($element) {
                return '' !== trim($element);
            });

            if ($data) {

                if ($bySlug && $bySlug->id != $data->id) {
                    return response()->json(Validation::error($request->token,
                        __('lang.slug_exists', [], $lang)));
                }



                if ($lang) {
                    [$langData, $mainData] = Utils::seperateLangData($filtered, [
                        'name', 'meta_title', 'meta_description'
                    ]);
                    Store::where('admin_id', $this->user->id)->update($mainData);


                    $existingLang = StoreLang::where('store_id', $data->id)
                        ->where('lang', $lang)->first();

                    if (!$existingLang) {
                        $langData['store_id'] = $request->id;
                        $langData['lang'] = $lang;
                        StoreLang::create($langData);

                    } else {
                        StoreLang::where('id', $existingLang->id)->update($langData);
                    }
                } else {

                    Store::where('admin_id', $this->user->id)->update($filtered);
                }




            } else {

                if ($bySlug) {
                    return response()->json(Validation::error($request->token,
                        __('lang.slug_exists', [], $lang)));
                }

                $filtered['admin_id'] = $this->user->id;


                if ($lang) {
                    [$langData, $mainData] = Utils::seperateLangData($filtered, [
                        'name', 'meta_title', 'meta_description'
                    ]);
                    $siteSetting = Store::create($mainData);

                    $langData['store_id'] = $siteSetting->id;
                    $langData['lang'] = $lang;
                    StoreLang::create($langData);

                } else {
                    Store::create($filtered);

                }

            }



            $query = Store::query();
            if ($lang) {
                $query = $query->leftJoin('store_langs as cl', function ($join) use ($lang) {
                    $join->on('cl.store_id', '=', 'stores.id');
                    $join->where('cl.lang', $lang);
                });
                $query = $query->select('stores.*', 'cl.name', 'cl.meta_title', 'cl.meta_description'
                );
            }
            $query = $query->where('admin_id', $this->user->id);
            $data = $query->first();

            return response()->json(new Response($request->token, $data));


        } catch (\Exception $ex) {
            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }
    }


    public function uploadLogo(Request $request)
    {
        try {
            $lang = $request->header('language');

            $validate = Validation::image($request);
            if ($validate) {
                return response()->json($validate);
            }

            $image_info = FileHelper::uploadImage($request['photo'], 'image');

            $existingStore = Store::where('admin_id', $this->user->id)->first();

            if (is_null($existingStore)) {
                Store::create(['image' => $image_info['name'], 'admin_id' => $this->user->id]);

            } else {
                if ($existingStore->image) {
                    FileHelper::deleteFile($existingStore->image);
                }
                $existingStore->image = $image_info['name'];
                Store::where('admin_id', $this->user->id)->update(['image' => $image_info['name']]);
            }


            $query = Store::query();
            if ($lang) {
                $query = $query->leftJoin('store_langs as cl', function ($join) use ($lang) {
                    $join->on('cl.store_id', '=', 'stores.id');
                    $join->where('cl.lang', $lang);
                });
                $query = $query->select('stores.*', 'cl.name', 'cl.meta_title', 'cl.meta_description'
                );
            }
            $query = $query->where('admin_id', $this->user->id);
            $data = $query->first();

            return response()->json(new Response($request->token, $data));


        } catch (\Exception $ex) {
            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }


    }
}
