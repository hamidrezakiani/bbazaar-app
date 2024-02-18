<?php

namespace App\Http\Controllers;

use App\Models\BannerSourceBrand;
use App\Models\Brand;
use App\Models\BrandLang;
use App\Models\Helper\ControllerHelper;
use App\Models\Helper\FileHelper;
use App\Models\Helper\Response;
use App\Models\Helper\Utils;
use App\Models\Helper\Validation;
use App\Models\HomeSliderSourceBrand;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class BrandsController extends ControllerHelper
{
    public function all(Request $request)
    {
        try {
            $lang = $request->header('language');

            if ($can = Utils::userCan($this->user, 'brand.view')) {
                return $can;
            }

            $query = Brand::query();
            $query = $query->orderBy('brands.' . $request->orderby, $request->type);

            if ($this->isVendor) {
                $query = $query->where('admin_id', $this->user->id);
            }


            if ($lang) {
                $query = $query->leftJoin('brand_langs as b', function ($join) use ($lang) {
                    $join->on('b.brand_id', '=', 'brands.id');
                    $join->where('b.lang', $lang);
                });
                $query = $query->select('brands.*', 'b.title');


                if ($request->q) {
                    $query = $query->where('b.title', 'LIKE', "%{$request->q}%");
                }
            } else {

                if ($request->q) {
                    $query = $query->where('brands.title', 'LIKE', "%{$request->q}%");
                }

            }


            $data = $query->paginate(Config::get('constants.api.PAGINATION'));

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
            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }
    }

    public function allBrands(Request $request)
    {
        try {
            $lang = $request->header('language');
            $query = Brand::query();

            if ($lang) {
                $query = $query->leftJoin('brand_langs as b', function ($join) use ($lang) {
                    $join->on('b.brand_id', '=', 'brands.id');
                    $join->where('b.lang', $lang);
                });
                $query = $query->select('brands.id', 'b.title');

            } else {

                $query = $query->select('brands.id', 'brands.title');
            }

            $query = $query->orderBy('brands.created_at');
            $data = $query->get();

            return response()->json(new Response($request->token, $data));

        } catch (\Exception $ex) {
            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }
    }


    public function find(Request $request, $id)
    {
        try {
            $lang = $request->header('language');


            if ($can = Utils::userCan($this->user, 'brand.view')) {
                return $can;
            }

            $query = Brand::query();
            if ($lang) {
                $query = $query->leftJoin('brand_langs as b', function ($join) use ($lang) {
                    $join->on('b.brand_id', '=', 'brands.id');
                    $join->where('b.lang', $lang);
                });
                $query = $query->select('brands.*', 'b.title');
            }
            $brand = $query->find($id);


            if (!$this->isSuperAdmin && $isOwner = Utils::isDataOwner($this->user, $brand)) {
                return $isOwner;
            }

            if (is_null($brand)) {
                return response()->json(Validation::noDataLang($lang));
            }

            return response()->json(new Response($request->token, $brand));


        } catch (\Exception $ex) {
            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }
    }


    public function action(Request $request, $id = null)
    {
        try {

            $lang = $request->header('language');

            $validate = Validation::brand($request);
            if ($validate) {
                return response()->json($validate);
            }

            $bySlug = Brand::where('slug', $request['slug'])->first();

            if ($id) {
                if ($can = Utils::userCan($this->user, 'brand.edit')) {
                    return $can;
                }

                $existing = Brand::find($id);
                if (!$this->isSuperAdmin && $isOwner = Utils::isDataOwner($this->user, $existing)) {
                    return $isOwner;
                }

                if ($bySlug && $bySlug['id'] != $id) {
                    return response()->json(Validation::error($request->token,
                        __('lang.slug_exists', [], $lang)));
                }

                $filtered = array_filter($request->all(), function ($element) {
                    return '' !== trim($element);
                });

                if ($lang) {
                    [$langData, $mainData] = Utils::seperateLangData($filtered, ['title']);
                    Brand::where('id', $id)->update($mainData);
                    $existingLang = BrandLang::where('brand_id', $id)->where('lang', $lang)->first();

                    if (!$existingLang) {
                        $langData['brand_id'] = $id;
                        $langData['lang'] = $lang;
                        BrandLang::create($langData);

                    } else {
                        BrandLang::where('id', $existingLang->id)->update($langData);
                    }
                } else {
                    Brand::where('id', $id)->update($filtered);
                }

            } else {
                if ($can = Utils::userCan($this->user, 'brand.create')) {
                    return $can;
                }

                if ($bySlug) {
                    return response()->json(Validation::error($request->token,
                        __('lang.slug_exists', [], $lang)));
                }

                $request['image'] = Config::get('constants.media.DEFAULT_IMAGE');
                $request['admin_id'] = $request->user()->id;
                $request['id'] = Utils::idGenerator(new Brand());


                if ($lang) {
                    [$langData, $mainData] = Utils::seperateLangData($request->all(), ['title']);
                    $brand = Brand::create($mainData);

                    $langData['brand_id'] = $brand->id;
                    $langData['lang'] = $lang;
                    BrandLang::create($langData);
                    $id = $brand->id;

                } else {
                    $brand = Brand::create($request->all());
                    $id = $brand->id;
                }
            }

            $query = Brand::query();
            if ($lang) {
                $query = $query->leftJoin('brand_langs as b', function ($join) use ($lang) {
                    $join->on('b.brand_id', '=', 'brands.id');
                    $join->where('b.lang', $lang);
                });
                $query = $query->select('brands.*', 'b.title');
            }
            $brand = $query->find($id);


            return response()->json(new Response($request->token, $brand));


        } catch (\Exception $ex) {
            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }
    }


    public function delete(Request $request, $id)
    {
        try {

            $lang = $request->header('language');

            if ($can = Utils::userCan($this->user, 'brand.delete')) {
                return $can;
            }

            $brand = Brand::find($id);

            if (!$this->isSuperAdmin && $isOwner = Utils::isDataOwner($this->user, $brand)) {
                return $isOwner;
            }

            if (is_null($brand)) {
                return response()->json(Validation::noDataLang($lang));
            }

            $product = Product::where('brand_id', $id)->get()->first();

            if ($product) {
                return response()->json(Validation::error($request->token,
                    __('lang.unable_delete', ['message' => __('lang.brand_used', [], $lang)], $lang)));
            }

            $homeSlidersSourceBrand = HomeSliderSourceBrand::where('brand_id', $id)->get()->first();

            if ($homeSlidersSourceBrand) {
                return response()->json(Validation::error($request->token,
                    __('lang.unable_delete', ['message' => __('lang.slider_used', [], $lang)], $lang)));
            }


            $bannerSourceBrand = BannerSourceBrand::where('brand_id', $id)->get()->first();

            if ($bannerSourceBrand) {
                return response()->json(Validation::error($request->token,
                    __('lang.unable_delete', ['message' => __('lang.banner_used', [], $lang)], $lang)));
            }

            BrandLang::where('brand_id', $id)->delete();
            if ($brand->delete()) {
                FileHelper::deleteFile($brand->image);
                return response()->json(new Response($request->token, $brand));
            }

            return response()->json(Validation::error($request->token, null, 'form', $lang));

        } catch (\Exception $ex) {
            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }
    }


    public function upload(Request $request, $id = null)
    {

        try {
            $lang = $request->header('language');


            $validate = Validation::image($request);
            if ($validate) {
                return response()->json($validate);
            }

            $image_info = FileHelper::uploadImage($request['photo'], 'brand');
            $request['image'] = $image_info['name'];

            $brand = $id ? Brand::find($id) : null;

            if (is_null($brand)) {
                if ($can = Utils::userCan($this->user, 'brand.create')) {
                    return $can;
                }

                $request['admin_id'] = $request->user()->id;
                $request['id'] = Utils::idGenerator(new Brand());
                $brand = Brand::create($request->all());
                $id = $brand->id;

            } else {
                if ($can = Utils::userCan($this->user, 'brand.edit')) {
                    return $can;
                }

                $existing = Brand::find($brand->id);
                if (!$this->isSuperAdmin && $isOwner = Utils::isDataOwner($this->user, $existing)) {
                    return $isOwner;
                }

                $brand_image = $brand->image;
                if ($brand->update($request->all())) {
                    FileHelper::deleteFile($brand_image);
                }
            }


            $query = Brand::query();
            if ($lang) {
                $query = $query->leftJoin('brand_langs as b', function ($join) use ($lang) {
                    $join->on('b.brand_id', '=', 'brands.id');
                    $join->where('b.lang', $lang);
                });
                $query = $query->select('brands.*', 'b.title');
            }
            $brand = $query->find($id);

            return response()->json(new Response($request->token, $brand));


        } catch (\Exception $ex) {
            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }
    }
}
