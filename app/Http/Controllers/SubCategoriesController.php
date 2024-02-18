<?php

namespace App\Http\Controllers;

use App\Models\BannerSourceCategory;
use App\Models\BannerSourceSubCategory;
use App\Models\Category;
use App\Models\Helper\ControllerHelper;
use App\Models\Helper\Response;
use App\Models\Helper\Utils;
use App\Models\Helper\Validation;
use App\Models\HomeSliderSourceSubCategory;
use App\Models\Product;
use App\Models\SubCategory;
use App\Models\SubCategoryLang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use App\Models\Helper\FileHelper;

class SubCategoriesController extends ControllerHelper
{
    public function all(Request $request)
    {
        try {
            $lang = $request->header('language');

            if ($can = Utils::userCan($this->user, 'subcategory.view')) {
                return $can;
            }

            $query = SubCategory::query();
            $query = $query->orderBy('sub_categories.' . $request->orderby, $request->type);

            if ($this->isVendor) {
                $query = $query->where('admin_id', $this->user->id);
            }


            if ($lang) {
                $query = $query->leftJoin('sub_category_langs as scl', function ($join) use ($lang) {
                    $join->on('scl.sub_category_id', '=', 'sub_categories.id');
                    $join->where('scl.lang', $lang);
                });
                $query = $query->select('sub_categories.*', 'scl.title', 'scl.meta_title', 'scl.meta_description');

                $query = $query->with(['category' => function ($query) use ($lang) {
                    $query->leftJoin('category_langs as cl',
                        function ($join) use ($lang) {
                            $join->on('categories.id', '=', 'cl.category_id');
                            $join->where('cl.lang', $lang);
                        })
                        ->select('categories.title', 'categories.id', 'categories.slug', 'cl.title');
                }]);


                if ($request->q) {
                    $query = $query->where('scl.title', 'LIKE', "%{$request->q}%");
                }

            } else {
                $query = $query->with('category');


                if ($request->q) {
                    $query = $query->where('sub_categories.title', 'LIKE', "%{$request->q}%");
                }
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


    public function allSubCategories(Request $request)
    {

        try {


            $lang = $request->header('language');
            $query = SubCategory::query();

            if ($lang) {
                $query = $query->leftJoin('sub_category_langs as scl', function ($join) use ($lang) {
                    $join->on('scl.sub_category_id', '=', 'sub_categories.id');
                    $join->where('scl.lang', $lang);
                });
                $query = $query->select('sub_categories.id', 'scl.title');

            } else {
                $query = $query->select('sub_categories.id', 'sub_categories.title');

            }
            $query = $query->orderBy('sub_categories.created_at');
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

            if ($can = Utils::userCan($this->user, 'subcategory.view')) {
                return $can;
            }

            $query = SubCategory::query();
            if ($lang) {
                $query = $query->leftJoin('sub_category_langs as scl', function ($join) use ($lang) {
                    $join->on('scl.sub_category_id', '=', 'sub_categories.id');
                    $join->where('scl.lang', $lang);
                });
                $query = $query->select('sub_categories.*', 'scl.title', 'scl.meta_title', 'scl.meta_description');
            }
            $subCategory = $query->find($id);

            if (!$this->isSuperAdmin && $isOwner = Utils::isDataOwner($this->user, $subCategory)) {
                return $isOwner;
            }

            if (is_null($subCategory)) {
                return response()->json(Validation::noDataLang($lang));
            }


            return response()->json(new Response($request->token, $subCategory));


        } catch (\Exception $ex) {
            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }
    }


    public function action(Request $request, $id = null)
    {
        try {
            $lang = $request->header('language');

            $validate = Validation::subCategory($request);
            if ($validate) {
                return response()->json($validate);
            }

            $bySlug = SubCategory::where('slug', $request['slug'])->get()->first();

            if ($id) {
                if ($can = Utils::userCan($this->user, 'subcategory.edit')) {
                    return $can;
                }

                $existing = SubCategory::find($id);
                if (!$this->isSuperAdmin && $isOwner = Utils::isDataOwner($this->user, $existing)) {
                    return $isOwner;
                }


                if ($bySlug && $bySlug['id'] != $id) {
                    return response()->json(Validation::error($request->token,
                        __('lang.slug_exists', [], $lang)
                    ));
                }

                $filtered = array_filter($request->all(), function ($element) {
                    return '' !== trim($element);
                });


                if ($lang) {
                    [$langData, $mainData] = Utils::seperateLangData($filtered,
                        ['title', 'meta_title', 'meta_description']);

                    SubCategory::where('id', $id)->update($mainData);
                    $existingLang = SubCategoryLang::where('sub_category_id', $id)
                        ->where('lang', $lang)->first();

                    if (!$existingLang) {
                        $langData['sub_category_id'] = $id;
                        $langData['lang'] = $lang;
                        SubCategoryLang::create($langData);

                    } else {
                        SubCategoryLang::where('id', $existingLang->id)->update($langData);
                    }
                } else {
                    SubCategory::where('id', $id)->update($filtered);
                }

            } else {
                if ($can = Utils::userCan($this->user, 'subcategory.create')) {
                    return $can;
                }

                if ($bySlug) {
                    return response()->json(Validation::error($request->token,
                        __('lang.slug_exists', [], $lang)
                    ));
                }

                $request['image'] = Config::get('constants.media.DEFAULT_IMAGE');
                $request['admin_id'] = $request->user()->id;
                $request['id'] = Utils::idGenerator(new SubCategory());


                if ($lang) {
                    [$langData, $mainData] = Utils::seperateLangData($request->all(),
                        ['title', 'meta_title', 'meta_description']);
                    $subCategory = SubCategory::create($mainData);

                    $langData['sub_category_id'] = $subCategory->id;
                    $langData['lang'] = $lang;
                    SubCategoryLang::create($langData);
                    $id = $subCategory->id;

                } else {
                    $subCategory = SubCategory::create($request->all());
                    $id = $subCategory->id;
                }
            }

            $query = SubCategory::query();
            if ($lang) {
                $query = $query->leftJoin('sub_category_langs as scl', function ($join) use ($lang) {
                    $join->on('scl.sub_category_id', '=', 'sub_categories.id');
                    $join->where('scl.lang', $lang);
                });
                $query = $query->select('sub_categories.*', 'scl.title', 'scl.meta_title', 'scl.meta_description');
            }

            $subCategory = $query->find($id);


            return response()->json(new Response($request->token, $subCategory));


        } catch (\Exception $ex) {
            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }
    }


    public function delete(Request $request, $id)
    {
        try {

            $lang = $request->header('language');

            if ($can = Utils::userCan($this->user, 'subcategory.delete')) {
                return $can;
            }
            $subCategory = SubCategory::find($id);

            if (!$this->isSuperAdmin && $isOwner = Utils::isDataOwner($this->user, $subCategory)) {
                return $isOwner;
            }

            if (is_null($subCategory))
                return response()->json(Validation::nothingFoundLang($lang));

            $product = Product::where('subcategory_id', $id)->get()->first();

            if ($product) {
                return response()->json(Validation::error($request->token,
                    __('lang.item_used', [], $lang)
                ));
            }

            $homeSlidersSourceSubCategory = HomeSliderSourceSubCategory::where('sub_category_id', $id)
                ->get()->first();

            if ($homeSlidersSourceSubCategory) {
                return response()->json(Validation::error($request->token,
                    __('lang.slider_used_sub_category', [], $lang)
                ));
            }

            $bannerSourceSubCat = BannerSourceSubCategory::where('sub_category_id', $id)->get()->first();

            if ($bannerSourceSubCat) {
                return response()->json(Validation::error($request->token,
                    __('lang.unable_delete', ['message' =>
                        __('lang.banner_used', [], $lang)], $lang)));
            }


            SubCategoryLang::where('sub_category_id', $id)->delete();

            if ($subCategory->delete()) {
                FileHelper::deleteFile($subCategory->image);
                return response()->json(new Response($request->token, $subCategory));
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

            $validate = Validation::subCategoryImage($request);
            if ($validate) {
                return response()->json($validate);
            }

            $image_info = FileHelper::uploadImage($request['photo'], 'sub-category');
            $request['image'] = $image_info['name'];

            $subCategory = $id ? SubCategory::find($id) : null;

            if (is_null($subCategory)) {
                if ($can = Utils::userCan($this->user, 'subcategory.create')) {
                    return $can;
                }

                $request['admin_id'] = $request->user()->id;
                $request['id'] = Utils::idGenerator(new SubCategory());
                $subCategory = SubCategory::create($request->all());
                $id = $subCategory->id;

            } else {
                if ($can = Utils::userCan($this->user, 'subcategory.edit')) {
                    return $can;
                }
                if (!$this->isSuperAdmin && $isOwner = Utils::isDataOwner($this->user, $subCategory)) {
                    return $isOwner;
                }

                $sub_category_image = $subCategory->image;
                if ($subCategory->update($request->all())) {
                    FileHelper::deleteFile($sub_category_image);
                }
            }


            $query = SubCategory::query();
            if ($lang) {
                $query = $query->leftJoin('sub_category_langs as scl', function ($join) use ($lang) {
                    $join->on('scl.sub_category_id', '=', 'sub_categories.id');
                    $join->where('scl.lang', $lang);
                });
                $query = $query->select('sub_categories.*', 'scl.title', 'scl.meta_title', 'scl.meta_description');
            }
            $subCategory = $query->find($id);


            return response()->json(new Response($request->token, $subCategory));

        } catch (\Exception $ex) {
            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }
    }
}
