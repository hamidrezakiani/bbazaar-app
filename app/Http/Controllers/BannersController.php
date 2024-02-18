<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\BannerLang;
use App\Models\BannerSourceBrand;
use App\Models\BannerSourceCategory;
use App\Models\BannerSourceProduct;
use App\Models\BannerSourceSubCategory;
use App\Models\Helper\ControllerHelper;
use App\Models\Helper\FileHelper;
use App\Models\Helper\Response;
use App\Models\Helper\Utils;
use App\Models\Helper\Validation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class BannersController extends ControllerHelper
{
    public function all(Request $request)
    {
        try {
            $lang = $request->header('language');


            if ($can = Utils::userCan($this->user, 'banner.view')) {
                return $can;
            }

            $query = Banner::orderBy('banners.created_at', 'ASC');

            if ($lang) {
                $query = $query->leftJoin('banner_langs as cl', function ($join) use ($lang) {
                    $join->on('cl.banner_id', '=', 'banners.id');
                    $join->where('cl.lang', $lang);
                });
                $query = $query->select('banners.*', 'cl.title');
            }


            if ($this->isVendor) {
                $query = $query->where('admin_id', $this->user->id);
            }

            $data = $query->paginate(Config::get('constants.api.PAGINATION'));

            return response()->json(new Response($request->token, $data));


        } catch (\Exception $ex) {
            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }
    }


    public function find(Request $request, $id)
    {

        try {

            $lang = $request->header('language');

            if ($can = Utils::userCan($this->user, 'banner.view')) {
                return $can;
            }

            $query = Banner::with('source_brands.brand')
                ->with('source_categories.category')
                ->with('source_sub_categories.sub_category')
                ->with('source_products.product');

            if ($lang) {
                $query = $query->leftJoin('banner_langs as cl', function ($join) use ($lang) {
                    $join->on('cl.banner_id', '=', 'banners.id');
                    $join->where('cl.lang', $lang);
                });
                $query = $query->select('banners.*', 'cl.title');
            }
            $banner = $query->find($id);

            if (!$this->isSuperAdmin && $isOwner = Utils::isDataOwner($this->user, $banner)) {
                return $isOwner;
            }

            if (is_null($banner)) {
                return response()->json(Validation::noDataLang($lang));
            }

            return response()->json(new Response($request->token, $banner));

        } catch (\Exception $ex) {
            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }
    }


    public function action(Request $request, $id = null)
    {
        try {
            $lang = $request->header('language');


            $validate = Validation::banner($request);
            if ($validate) {
                return response()->json($validate);
            }

            $filteredCategories = [];
            $filteredSubCategories = [];
            $filteredBrands = [];
            $filteredProducts = [];

            $bySlug = Banner::where('slug', $request['slug'])->first();


            if ($id) {
                if ($can = Utils::userCan($this->user, 'banner.edit')) {
                    return $can;
                }

                $existing = Banner::find($id);
                if (!$this->isSuperAdmin && $isOwner = Utils::isDataOwner($this->user, $existing)) {
                    return $isOwner;
                }

                if ($bySlug && $bySlug['id'] != $id) {
                    return response()->json(Validation::error($request->token,
                        __('lang.slug_exists', [], $lang)));
                }

                $filtered = array_filter($request->all(), function ($element) {
                    return !is_array($element) && '' !== trim($element);
                });

                unset($filtered['source_brands']);
                unset($filtered['source_categories']);
                unset($filtered['source_sub_categories']);
                unset($filtered['source_products']);

                if ($lang) {
                    [$langData, $mainData] = Utils::seperateLangData($filtered, ['title']);
                    Banner::where('id', $id)->update($mainData);
                    $existingLang = BannerLang::where('banner_id', $id)
                        ->where('lang', $lang)->first();

                    if (!$existingLang) {
                        $langData['banner_id'] = $id;
                        $langData['lang'] = $lang;
                        BannerLang::create($langData);

                    } else {
                        BannerLang::where('id', $existingLang->id)->update($langData);
                    }
                } else {

                    Banner::where('id', $id)->update($filtered);
                }

                $existingBanner = Banner::with('source_brands.brand')
                    ->with('source_categories.category')
                    ->with('source_sub_categories.sub_category')
                    ->with('source_products.product')
                    ->find($id);

                // Adding item id in array to prevent adding same id twice
                foreach ($existingBanner['source_categories'] as $i) {
                    $filteredCategories[$i->category->id] = $i->category->id;
                }

                foreach ($existingBanner['source_sub_categories'] as $i) {
                    $filteredSubCategories[$i->sub_category->id] = $i->sub_category->id;
                }

                foreach ($existingBanner['source_brands'] as $i) {
                    $filteredBrands[$i->brand->id] = $i->brand->id;
                }

                foreach ($existingBanner['source_products'] as $i) {
                    $filteredBrands[$i->product->id] = $i->product->id;
                }

            } else {
                if ($can = Utils::userCan($this->user, 'banner.create')) {
                    return $can;
                }

                if ($bySlug) {
                    return response()->json(Validation::error($request->token,
                        __('lang.slug_exists', [], $lang)));
                }

                $request['admin_id'] = $request->user()->id;
                $request['type'] = (string)$request->type;

                //  return response()->json(new Response($request->token, $request->all()));

                if ($lang) {
                    [$langData, $mainData] = Utils::seperateLangData($request->all(), ['title']);
                    $banner = Banner::create($mainData);

                    $langData['banner_id'] = $banner->id;
                    $langData['lang'] = $lang;
                    BannerLang::create($langData);
                    $id = $banner->id;

                } else {
                    $banner = Banner::create($request->all());
                    $id = $banner->id;
                }
            }

            // Adding / deleting / updating categories
            $categoryDeleted = [];
            $categoryAdded = [];

            foreach ($request['source_categories'] as $i) {
                // Checking the item is to not be deleted and already in the database
                if (key_exists($i['category']['id'], $filteredCategories) && !key_exists('deleted', $i)) {
                    continue;
                }
                // Check if this item is not being deleted, then added to the existing list
                if (!key_exists('deleted', $i)) {
                    $filteredCategories[$i['category']['id']] = $i['category']['id'];
                }

                if (key_exists('deleted', $i) && key_exists('id', $i) && $i['id'] && $i['deleted']) {
                    // Deleted category
                    array_push($categoryDeleted, $i['id']);
                } else if ((!key_exists('id', $i) || (key_exists('id', $i) && !$i['id']))
                    && ((key_exists('deleted', $i) && !$i['deleted']) || !key_exists('deleted', $i))
                    && $i['category']['id']) {
                    // Added category
                    array_push($categoryAdded, [
                        'banner_id' => $id,
                        'category_id' => $i['category']['id']
                    ]);
                } else if (key_exists('id', $i) && $i['id'] && (key_exists('updated', $i) && $i['updated']) && $i['category']['id']) {
                    // Updated category
                    BannerSourceCategory::where('id', $i['id'])->update(['category_id' => $i['category']['id']]);
                }
            }

            BannerSourceCategory::whereIn('id', $categoryDeleted)->delete();
            BannerSourceCategory::insert($categoryAdded);

            // Adding / deleting / updating sub categories
            $subCategoryDeleted = [];
            $subCategoryAdded = [];

            foreach ($request['source_sub_categories'] as $i) {
                // Checking the item is to not be deleted and already in the database
                if (key_exists($i['sub_category']['id'], $filteredSubCategories) && !key_exists('deleted', $i)) {
                    continue;
                }
                // Check if this item is not being deleted, then added to the existing list
                if (!key_exists('deleted', $i)) {
                    $filteredSubCategories[$i['sub_category']['id']] = $i['sub_category']['id'];
                }

                if (key_exists('deleted', $i) && key_exists('id', $i) && $i['id'] && $i['deleted']) {
                    // Deleted sub category
                    array_push($subCategoryDeleted, $i['id']);
                } else if ((!key_exists('id', $i) || (key_exists('id', $i) && !$i['id']))
                    && ((key_exists('deleted', $i) && !$i['deleted']) || !key_exists('deleted', $i))
                    && $i['sub_category']['id']) {
                    // Added sub  category
                    array_push($subCategoryAdded, [
                        'banner_id' => $id,
                        'sub_category_id' => $i['sub_category']['id']
                    ]);
                } else if (key_exists('id', $i) && $i['id'] && (key_exists('updated', $i) && $i['updated']) && $i['sub_category']['id']) {
                    // Updated sub category
                    BannerSourceSubCategory::where('id', $i['id'])->update(['sub_category_id' => $i['sub_category']['id']]);
                }
            }

            BannerSourceSubCategory::whereIn('id', $subCategoryDeleted)->delete();
            BannerSourceSubCategory::insert($subCategoryAdded);

            // Adding / deleting / updating brands
            $brandDeleted = [];
            $brandAdded = [];

            foreach ($request['source_brands'] as $i) {
                // Checking the item is to not be deleted and already in the database
                if (key_exists($i['brand']['id'], $filteredBrands) && !key_exists('deleted', $i)) {
                    continue;
                }
                // Check if this item is not being deleted, then added to the existing list
                if (!key_exists('deleted', $i)) {
                    $filteredBrands[$i['brand']['id']] = $i['brand']['id'];
                }

                if (key_exists('deleted', $i) && key_exists('id', $i) && $i['id'] && $i['deleted']) {
                    // Deleted brand
                    array_push($brandDeleted, $i['id']);
                } else if ((!key_exists('id', $i) || (key_exists('id', $i) && !$i['id']))
                    && ((key_exists('deleted', $i) && !$i['deleted']) || !key_exists('deleted', $i))
                    && $i['brand']['id']) {
                    // Added brand
                    array_push($brandAdded, [
                        'banner_id' => $id,
                        'brand_id' => $i['brand']['id']
                    ]);
                } else if (key_exists('id', $i) && $i['id'] && (key_exists('updated', $i) && $i['updated']) && $i['brand']['id']) {
                    // Updated brand
                    BannerSourceBrand::where('id', $i['id'])->update(['brand_id' => $i['brand']['id']]);
                }
            }

            BannerSourceBrand::whereIn('id', $brandDeleted)->delete();
            BannerSourceBrand::insert($brandAdded);

            // Adding / deleting / updating products
            $productDeleted = [];
            $productAdded = [];

            foreach ($request['source_products'] as $i) {
                // Checking the item is to not be deleted and already in the database
                if (key_exists($i['product']['id'], $filteredProducts) && !key_exists('deleted', $i)) {
                    continue;
                }
                // Check if this item is not being deleted, then added to the existing list
                if (!key_exists('deleted', $i)) {
                    $filteredProducts[$i['product']['id']] = $i['product']['id'];
                }

                if (key_exists('deleted', $i) && key_exists('id', $i) && $i['id'] && $i['deleted']) {
                    // Deleted brand
                    array_push($productDeleted, $i['id']);
                } else if ((!key_exists('id', $i) || (key_exists('id', $i) && !$i['id']))
                    && ((key_exists('deleted', $i) && !$i['deleted']) || !key_exists('deleted', $i))
                    && $i['product']['id']) {
                    // Added product
                    array_push($productAdded, [
                        'banner_id' => $id,
                        'product_id' => $i['product']['id']
                    ]);
                } else if (key_exists('id', $i) && $i['id'] && (key_exists('updated', $i) && $i['updated']) && $i['product']['id']) {
                    // Updated product
                    BannerSourceProduct::where('id', $i['id'])->update(['product_id' => $i['product']['id']]);
                }
            }

            BannerSourceProduct::whereIn('id', $productDeleted)->delete();
            BannerSourceProduct::insert($productAdded);

            $query = Banner::with('source_brands.brand')
                ->with('source_categories.category')
                ->with('source_sub_categories.sub_category')
                ->with('source_products.product');

            if ($lang) {
                $query = $query->leftJoin('banner_langs as cl', function ($join) use ($lang) {
                    $join->on('cl.banner_id', '=', 'banners.id');
                    $join->where('cl.lang', $lang);
                });
                $query = $query->select('banners.*', 'cl.title');
            }
            $data = $query->find($id);

            return response()->json(new Response($request->token, $data));


        } catch (\Exception $ex) {
            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }
    }


    public function delete(Request $request, $id)
    {
        try {

            $lang = $request->header('language');

            if ($can = Utils::userCan($this->user, 'banner.delete')) {
                return $can;
            }

            $banner = Banner::find($id);

            if (!$this->isSuperAdmin && $isOwner = Utils::isDataOwner($this->user, $banner)) {
                return $isOwner;
            }

            if (is_null($banner)) {
                return response()->json(Validation::nothingFoundLang($lang));
            }

            BannerSourceBrand::where('banner_id', $id)->delete();
            BannerSourceCategory::where('banner_id', $id)->delete();
            BannerSourceSubCategory::where('banner_id', $id)->delete();
            BannerSourceProduct::where('banner_id', $id)->delete();


            BannerLang::where('banner_id', $id)->delete();
            if ($banner->delete()) {
                FileHelper::deleteFile($banner->image);
                return response()->json(new Response($request->token, $banner));
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


            $validate = Validation::bannerImage($request);
            if ($validate) {
                return response()->json($validate);
            }

            $image_info = FileHelper::uploadImage($request['photo'], 'banner');
            $request['image'] = $image_info['name'];

            $banner = $id ? Banner::find($id) : null;

            if (is_null($banner)) {
                $request['admin_id'] = $request->user()->id;
                $banner = Banner::create($request->all());
                $id = $banner->id;

            } else {
                $image = $banner->image;
                if ($banner->update($request->all())) {
                    FileHelper::deleteFile($image);
                }
            }

            $query = Banner::with('source_brands.brand')
                ->with('source_categories.category')
                ->with('source_sub_categories.sub_category')
                ->with('source_products.product');

            if ($lang) {
                $query = $query->leftJoin('banner_langs as cl', function ($join) use ($lang) {
                    $join->on('cl.banner_id', '=', 'banners.id');
                    $join->where('cl.lang', $lang);
                });
                $query = $query->select('banners.*', 'cl.title');
            }
            $banner = $query->find($id);

            return response()->json(new Response($request->token, $banner));


        } catch (\Exception $ex) {
            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }
    }
}
