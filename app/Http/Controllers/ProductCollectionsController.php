<?php

namespace App\Http\Controllers;

use App\Models\CollectionWithProduct;
use App\Models\Helper\ControllerHelper;
use App\Models\Helper\Response;
use App\Models\Helper\Utils;
use App\Models\Helper\Validation;
use App\Models\Product;
use App\Models\ProductCollection;
use App\Models\ProductCollectionLang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class ProductCollectionsController extends ControllerHelper
{
    public function all(Request $request)
    {
        try {
            $lang = $request->header('language');

            if ($can = Utils::userCan($this->user, 'product_collection.view')) {
                return $can;
            }

            $query = ProductCollection::query();
            $query = $query->orderBy('product_collections.' . $request->orderby, $request->type);

            if ($this->isVendor) {
                $query = $query->where('admin_id', $this->user->id);
            }


            if ($lang) {
                $query = $query->leftJoin('product_collection_langs as pcl', function ($join) use ($lang) {
                    $join->on('pcl.product_collection_id', '=', 'product_collections.id');
                    $join->where('pcl.lang', $lang);
                });
                $query = $query->select('product_collections.*', 'pcl.title');

                if ($request->q) {
                    $query = $query->where('pcl.title', 'LIKE', "%{$request->q}%");
                }
            } else {
                if ($request->q) {
                    $query = $query->where('product_collections.title', 'LIKE', "%{$request->q}%");
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


    public function allList(Request $request)
    {

        try {
            $lang = $request->header('language');


            $query = ProductCollection::query();

            if ($lang) {
                $query = $query->leftJoin('product_collection_langs as trl', function ($join) use ($lang) {
                    $join->on('trl.product_collection_id', '=', 'product_collections.id');
                    $join->where('trl.lang', $lang);
                });
                $query = $query->select('product_collections.id', 'trl.title');

            } else {

                $query = $query->select('product_collections.id', 'product_collections.title');
            }

            $query = $query->orderBy('product_collections.created_at');
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

            if ($can = Utils::userCan($this->user, 'product_collection.view')) {
                return $can;
            }

            $query = ProductCollection::query();

            if ($lang) {
                $query = $query->leftJoin('product_collection_langs as trl', function ($join) use ($lang) {
                    $join->on('trl.product_collection_id', '=', 'product_collections.id');
                    $join->where('trl.lang', $lang);
                });
                $query = $query->select('product_collections.*', 'trl.title');
            }
            $data = $query->find($id);

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


    public function action(Request $request, $id = null)
    {
        try {

            $lang = $request->header('language');

            $validate = Validation::collection($request);
            if ($validate) {
                return response()->json($validate);
            }

            $bySlug = ProductCollection::where('slug', $request['slug'])->get()->first();


            if ($id) {
                if ($can = Utils::userCan($this->user, 'product_collection.edit')) {
                    return $can;
                }

                $existing = ProductCollection::find($id);
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
                    ProductCollection::where('id', $id)->update($mainData);
                    $existingLang = ProductCollectionLang::where('product_collection_id', $id)
                        ->where('lang', $lang)->first();

                    if (!$existingLang) {
                        $langData['product_collection_id'] = $id;
                        $langData['lang'] = $lang;
                        ProductCollectionLang::create($langData);

                    } else {

                        ProductCollectionLang::where('id', $existingLang->id)->update($langData);
                    }
                } else {
                    ProductCollection::where('id', $id)->update($filtered);
                }


            } else {
                if ($can = Utils::userCan($this->user, 'product_collection.create')) {
                    return $can;
                }

                if ($bySlug) {
                    return response()->json(Validation::error($request->token,
                        __('lang.slug_exists', [], $lang)));
                }

                $request['admin_id'] = $request->user()->id;


                if ($lang) {
                    [$langData, $mainData] = Utils::seperateLangData($request->all(), ['title']);
                    $productCollection = ProductCollection::create($mainData);

                    $langData['product_collection_id'] = $productCollection->id;
                    $langData['lang'] = $lang;
                    ProductCollectionLang::create($langData);
                    $id = $productCollection->id;

                } else {
                    $productCollection = ProductCollection::create($request->all());
                    $id = $productCollection->id;
                }

            }


            $query = ProductCollection::query();

            if ($lang) {
                $query = $query->leftJoin('product_collection_langs as trl', function ($join) use ($lang) {
                    $join->on('trl.product_collection_id', '=', 'product_collections.id');
                    $join->where('trl.lang', $lang);
                });
                $query = $query->select('product_collections.*', 'trl.title');
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
            if ($can = Utils::userCan($this->user, 'product_collection.delete')) {
                return $can;
            }
            $productCollection = ProductCollection::find($id);


            if (is_null($productCollection)) {
                return response()->json(Validation::nothingFoundLang($lang));
            }

            if (!$this->isSuperAdmin && $isOwner = Utils::isDataOwner($this->user, $productCollection)) {
                return $isOwner;
            }


            $collectionWithProduct = CollectionWithProduct::where('product_collection_id', $id)->get()->first();


            if ($collectionWithProduct) {
                return response()->json(Validation::error($request->token,
                    __('lang.using_collection', [], $lang)));
            }


            ProductCollectionLang::where('product_collection_id', $id)->delete();

            if ($productCollection->delete()) {
                return response()->json(new Response($request->token, $productCollection));
            }

            return response()->json(Validation::errorTokenLang($request->token, $lang));

        } catch (\Exception $ex) {
            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }


    }
}
