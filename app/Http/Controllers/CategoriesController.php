<?php

namespace App\Http\Controllers;

use App\Models\BannerSourceBrand;
use App\Models\BannerSourceCategory;
use App\Models\Category;
use App\Models\CategoryLang;
use App\Models\Helper\ControllerHelper;
use App\Models\Helper\FileHelper;
use App\Models\Helper\Response;
use App\Models\Helper\Utils;
use App\Models\Helper\Validation;
use App\Models\HomeSliderSourceCategory;
use App\Models\Language;
use App\Models\Page;
use App\Models\Product;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class CategoriesController extends ControllerHelper
{
    public function all(Request $request)
    {
        try {

            $lang = $request->header('language');

            if ($can = Utils::userCan($this->user, 'category.view')) {
                return $can;
            }

            $query = Category::query();

            if ($this->isVendor) {
                $query = $query->where('admin_id', $this->user->id);
            }



            if ($lang) {
                $query = $query->leftJoin('category_langs as cl', function ($join) use ($lang) {
                    $join->on('cl.category_id', '=', 'categories.id');
                    $join->where('cl.lang', $lang);
                });
                $query = $query->select('categories.*', 'cl.title', 'cl.meta_title', 'cl.meta_description');

                if ($request->q) {
                    $query = $query->where('cl.title', 'LIKE', "%{$request->q}%");
                }

            }else {
                if ($request->q) {
                    $query = $query->where('categories.title', 'LIKE', "%{$request->q}%");
                }
            }

            $query = $query->orderBy('categories.' . $request->orderby, $request->type);


            $data = $query->paginate(Config::get('constants.api.PAGINATION'));

            foreach ($data as $item) {
                $item['created'] = Utils::formatDate($item->created_at);
            }
            return response()->json(new Response($request->token, $data));

        } catch (\Exception $ex) {
            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }
    }


    public function allCategories(Request $request)
    {
        try {
            $lang = $request->header('language');
            $query = Category::query();

            if ($lang) {
                $query = $query->leftJoin('category_langs as cl', function ($join) use ($lang) {
                    $join->on('cl.category_id', '=', 'categories.id');
                    $join->where('cl.lang', $lang);
                });
                $query = $query->select('categories.id', 'cl.title');

            } else {
                $query = $query->select('categories.id', 'categories.title');
            }

            $query = $query->orderBy('categories.created_at');
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

            if ($can = Utils::userCan($this->user, 'category.view')) {
                return $can;
            }

            $query = Category::query();
            if ($lang) {
                $query = $query->leftJoin('category_langs as cl', function ($join) use ($lang) {
                    $join->on('cl.category_id', '=', 'categories.id');
                    $join->where('cl.lang', $lang);
                });
                $query = $query->select('categories.*', 'cl.title', 'cl.meta_title', 'cl.meta_description');
            }

            $category = $query->find($id);

            if (!$this->isSuperAdmin && $isOwner = Utils::isDataOwner($this->user, $category)) {
                return $isOwner;
            }

            if (is_null($category)) {
                return response()->json(Validation::noDataLang($lang));
            }

            return response()->json(new Response($request->token, $category));

        } catch (\Exception $ex) {
            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }
    }


    public function action(Request $request, $id = null)
    {
        try {

            $lang = $request->header('language');

            $validate = Validation::category($request);
            if ($validate) {
                return response()->json($validate);
            }

            $bySlug = Category::where('slug', $request['slug'])->first();

            if ($id) {
                if ($can = Utils::userCan($this->user, 'category.edit')) {
                    return $can;
                }
                $existing = Category::find($id);

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
                    [$langData, $mainData] = Utils::seperateLangData($filtered, ['title', 'meta_title', 'meta_description']);
                    Category::where('id', $id)->update($mainData);
                    $existingLang = CategoryLang::where('category_id', $id)
                        ->where('lang', $lang)
                        ->first();

                    if (!$existingLang) {
                        $langData['category_id'] = $id;
                        $langData['lang'] = $lang;
                        CategoryLang::create($langData);

                    } else {
                        CategoryLang::where('id', $existingLang->id)->update($langData);
                    }
                } else {
                    Category::where('id', $id)->update($filtered);
                }

            } else {
                if ($can = Utils::userCan($this->user, 'category.create')) {
                    return $can;
                }

                if ($bySlug) {
                    return response()->json(Validation::error($request->token,
                        __('lang.slug_exists', [], $lang)));
                }

                $request['image'] = Config::get('constants.media.DEFAULT_IMAGE');
                $request['admin_id'] = $request->user()->id;
                $request['id'] = Utils::idGenerator(new Category());

                if ($lang) {
                    [$langData, $mainData] = Utils::seperateLangData($request->all(), ['title', 'meta_title', 'meta_description']);
                    $category = Category::create($mainData);

                    $langData['category_id'] = $category->id;
                    $langData['lang'] = $lang;
                    CategoryLang::create($langData);
                    $id = $category->id;

                } else {
                    $category = Category::create($request->all());
                    $id = $category->id;
                }
            }

            $query = Category::query();
            if ($lang) {
                $query = $query->leftJoin('category_langs as cl', function ($join) use ($lang) {
                    $join->on('cl.category_id', '=', 'categories.id');
                    $join->where('cl.lang', $lang);
                });
                $query = $query->select('categories.*', 'cl.title', 'cl.meta_title', 'cl.meta_description');
            }

            $category = $query->find($id);

            return response()->json(new Response($request->token, $category));

        } catch (\Exception $ex) {
            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }
    }


    public function delete(Request $request, $id)
    {
        try {


            $lang = $request->header('language');

            if ($can = Utils::userCan($this->user, 'category.delete')) {
                return $can;
            }

            $category = Category::find($id);

            if (!$this->isSuperAdmin && $isOwner = Utils::isDataOwner($this->user, $category)) {
                return $isOwner;
            }

            if (is_null($category))
                return response()->json(Validation::nothingFoundLang($lang));

            $sub_category = SubCategory::where('category_id', $id)->get()->first();

            if ($sub_category) {
                return response()->json(Validation::error($request->token,
                    __('lang.unable_delete', ['message' =>
                        __('lang.category_used', [], $lang)], $lang)
                ));
            }

            $product = Product::where('category_id', $id)->get()->first();

            if ($product) {
                return response()->json(Validation::error($request->token,
                    __('lang.unable_delete', ['message' =>
                        __('lang.category_by_product', [], $lang)], $lang)
                ));
            }

            $homeSlidersSourceCategory = HomeSliderSourceCategory::where('category_id', $id)->get()->first();
            if ($homeSlidersSourceCategory) {
                return response()->json(Validation::error($request->token,
                    __('lang.unable_delete', ['message' =>
                        __('lang.slider_by_cat', [], $lang)], $lang)
                ));
            }


            $bannerSourceCat = BannerSourceCategory::where('category_id', $id)->get()->first();

            if ($bannerSourceCat) {
                return response()->json(Validation::error($request->token,
                    __('lang.unable_delete', ['message' =>
                        __('lang.banner_used', [], $lang)], $lang)));
            }


            CategoryLang::where('category_id', $id)->delete();

            if ($category->delete()) {
                FileHelper::deleteFile($category->image);
                return response()->json(new Response($request->token, $category));
            }

            return response()->json(Validation::errorTokenLang($request->token, $lang));

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

            $image_info = FileHelper::uploadImage($request['photo'], 'category');
            $request['image'] = $image_info['name'];

            $category = $id ? Category::find($id) : null;

            if (is_null($category)) {
                if ($can = Utils::userCan($this->user, 'category.create')) {
                    return $can;
                }

                $request['admin_id'] = $request->user()->id;
                $request['id'] = Utils::idGenerator(new Category());
                $category = Category::create($request->all());
                $id = $category->id;

            } else {
                if ($can = Utils::userCan($this->user, 'category.edit')) {
                    return $can;
                }
                if (!$this->isSuperAdmin && $isOwner = Utils::isDataOwner($this->user, $category)) {
                    return $isOwner;
                }

                $category_image = $category->image;
                if ($category->update($request->all())) {
                    FileHelper::deleteFile($category_image);
                }
            }


            $query = Category::query();
            if ($lang) {
                $query = $query->leftJoin('category_langs as cl', function ($join) use ($lang) {
                    $join->on('cl.category_id', '=', 'categories.id');
                    $join->where('cl.lang', $lang);
                });
                $query = $query->select('categories.*', 'cl.title', 'cl.meta_title', 'cl.meta_description');
            }

            $category = $query->find($id);

            return response()->json(new Response($request->token, $category));


        } catch (\Exception $ex) {
            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }

    }
}
