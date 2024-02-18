<?php

namespace App\Http\Controllers\MobileApi;

use App\Http\Controllers\Controller;
use App\Http\Resources\Mobile\FeaturedProductsResource;
use App\Http\Resources\Mobile\FlashSaleResource;
use App\Http\Resources\Mobile\ProductDetailResource;
use App\Http\Resources\Mobile\ProductResource;
use App\Http\Resources\Mobile\ProductCollection as ProductCollectionResource;
use App\Http\Resources\Mobile\SearchResource;
use App\Models\Attribute;
use App\Models\Banner;
use App\Models\Brand;
use App\Models\Category;
use App\Models\ContactUs;
use App\Models\FlashSale;
use App\Models\FlashSaleProduct;
use App\Models\FooterImageLink;
use App\Models\FooterLink;
use App\Models\HeaderLink;
use App\Models\Helper\FileHelper;
use App\Models\Helper\Response;
use App\Models\Helper\Utils;
use App\Models\Helper\Validation;
use App\Models\HomeSlider;
use App\Models\Language;
use App\Models\Order;
use App\Models\Page;
use App\Models\Payment;
use App\Models\Product;
use App\Models\ProductCollection;
use App\Models\RatingReview;
use App\Models\Setting;
use App\Models\ShippingRule;
use App\Models\SiteSetting;
use App\Models\Store;
use App\Models\SubCategory;
use App\Models\Tag;
use App\Models\UpdatedInventory;
use App\Models\UserFollowStore;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class MobileApiController extends Controller
{
    public function all(Request $request)
    {
        try {

            $lang = $request->header('language');


            $subCategory = null;
            $category = null;

            $query = Product::query();
            $query = $query->leftJoin('flash_sales', function ($join) {

                $join->on('products.id', '=', 'flash_sale_products.product_id');

                $join->leftJoin('flash_sale_products', function ($join) {
                    $join->on('flash_sales.id', '=', 'flash_sale_products.flash_sale_id');
                });
                $join->where('flash_sales.end_time', '>=', date('Y-m-d H:i:s'))
                    ->where('flash_sales.status', Config::get('constants.status.PUBLIC'));
            })
                ->groupBy('products.id');


            $allShipping = null;
            $allCollection = null;
            $allBrand = null;
            $sidebarData = $request->sidebar_data === 'true';


            if ($lang) {


                if ($request->sub_category) {

                    $querySC = SubCategory::query();
                    $querySC = $querySC->leftJoin('sub_category_langs as scl', function ($join) use ($lang) {
                        $join->on('scl.sub_category_id', '=', 'sub_categories.id');
                        $join->where('scl.lang', $lang);
                    });
                    $querySC = $querySC->with(['category' => function ($query) use ($lang) {
                        $query->leftJoin('category_langs as cl',
                            function ($join) use ($lang) {
                                $join->on('categories.id', '=', 'cl.category_id');
                                $join->where('cl.lang', $lang);
                            })
                            ->select('categories.id', 'cl.title', 'categories.image', 'categories.slug');
                    }]);
                    $querySC = $querySC->select('sub_categories.id', 'scl.title', 'sub_categories.image',
                        'sub_categories.category_id', 'sub_categories.slug');


                    $subCategory = $querySC->where('slug', $request->sub_category)
                        ->first();

                    if ($subCategory) {

                        $query = $query->where('products.subcategory_id', $subCategory->id);
                    }


                } else if ($request->category) {


                    $queryCat = Category::query();
                    $queryCat = $queryCat->leftJoin('category_langs as cl', function ($join) use ($lang) {
                        $join->on('cl.category_id', '=', 'categories.id');
                        $join->where('cl.lang', $lang);
                    });

                    $queryCat = $queryCat->select('categories.id', 'categories.image', 'cl.title', 'categories.slug');


                    $category = $queryCat->where('slug', $request->category)->first();

                    if ($category) {
                        $query = $query->where('products.category_id', $category->id);
                    }
                }


                $query = $query->leftJoin('product_langs as pl', function ($join) use ($lang) {
                    $join->on('pl.product_id', '=', 'products.id');
                    $join->where('pl.lang', $lang);
                });


                $query = $query->select('products.id', 'products.slug', 'pl.title', 'products.badge',
                    'products.selling', 'products.offered',
                    'products.image', 'products.review_count', 'products.rating', 'flash_sale_products.price',
                    'flash_sales.end_time');


                if ($sidebarData) {

                    $allBrand = Brand::leftJoin('brand_langs as b', function ($join) use ($lang) {
                        $join->on('b.brand_id', '=', 'brands.id');
                        $join->where('b.lang', $lang);
                    })
                        ->where('brands.status', Config::get('constants.status.PUBLIC'))
                        ->select('brands.id', 'brands.title', 'b.title')
                        ->get();

                    $allCollection = ProductCollection::leftJoin('product_collection_langs as pcl',
                        function ($join) use ($lang) {
                            $join->on('pcl.product_collection_id', '=', 'product_collections.id');
                            $join->where('pcl.lang', $lang);
                        })
                        ->where('product_collections.status', Config::get('constants.status.PUBLIC'))
                        ->select('product_collections.id', 'product_collections.title', 'pcl.title')
                        ->get();

                    $allShipping = ShippingRule::leftJoin('shipping_rule_langs as srl',
                        function ($join) use ($lang) {
                            $join->on('srl.shipping_rule_id', '=', 'shipping_rules.id');
                            $join->where('srl.lang', $lang);
                        })
                        ->select('shipping_rules.id', 'shipping_rules.title', 'srl.title')
                        ->get();

                }

            } else {


                if ($request->sub_category) {

                    $subCategory = SubCategory::with('category')
                        ->where('slug', $request->sub_category)
                        ->first();

                    if ($subCategory) {
                        $query = $query->where('products.subcategory_id', $subCategory->id);
                    }


                } else if ($request->category) {

                    $category = Category::where('slug', $request->category)->first();

                    if ($category) {
                        $query = $query->where('products.category_id', $category->id);
                    }
                }


                $query = $query->select('products.id', 'products.title', 'products.slug',
                    'products.badge',
                    'products.selling', 'products.offered',
                    'products.image', 'products.review_count', 'products.rating', 'flash_sale_products.price',
                    'flash_sales.end_time');


                if ($sidebarData) {

                    $allBrand = Brand::where('status', Config::get('constants.status.PUBLIC'))
                        ->select('id', 'title')
                        ->get();

                    $allCollection = ProductCollection::where('status', Config::get('constants.status.PUBLIC'))
                        ->select('id', 'title')
                        ->get();

                    $allShipping = ShippingRule::select('id', 'title')->get();

                }
            }


            if ($request->brand) {
                $query = $query->whereIn('products.brand_id', explode(',', $request->brand));
            }

            if ($request->collection) {
                $query = $query
                    ->rightJoin('collection_with_products as cwp', function ($join) {
                        $join->on('products.id', '=', 'cwp.product_id');
                    })
                    ->rightJoin('product_collections as pc', function ($join) use ($request) {
                        $join->on('pc.id', '=', 'cwp.product_collection_id');
                        $join->where('pc.status', Config::get('constants.status.PUBLIC'))
                            ->whereIn('pc.id', explode(',', $request->collection));
                    });
            }

            if ($request->rating != 0) {
                $query = $query->where('products.rating', '>=', $request->rating);
            }

            if ($request->max > 0 || $request->min > 0 ) {
                if ($request->max == 0) {
                    $request->max = 999999;
                }
                /*
                    Price Filter By Currency
                */
                $min = floatval($request->min);
                $max = floatval($request->max);
                if($request->header('currency') == 'USD'){
                    $min *= getDollar()->price;
                    $max *= getDollar()->price;
                }
                $query = $query->where(function ($q) use ($min,$max) {
                    $q->where(function ($qr) use ($min,$max) {
                        $qr->whereNotNull('flash_sales.end_time');
                        $qr->whereBetween('flash_sale_products.price', [$min,$max]);
                    });
                    $q->orWhere(function ($qr) use ($min,$max) {
                        $qr->whereNull('flash_sales.end_time');
                        $qr->whereNotNull('products.offered');
                        $qr->whereBetween('products.offered', [$min, $max]);
                        return $qr;
                    });
                    $q->orWhere(function ($qr) use ($min,$max) {
                        $qr->whereNull('flash_sales.end_time');
                        $qr->whereNull('products.offered');
                        $qr->whereBetween('products.selling', [$min, $max]);
                    });

                });

            }

            $query = $query->where('products.status', Config::get('constants.status.PUBLIC'));


            if ($request->shipping) {
                $query = $query->whereIn('products.shipping_rule_id', explode(',', $request->shipping));
            }

            if ($request->sortby) {
                if ($request->sortby == 'price_low_to_high') {

                    $query = $query
                        ->addSelect(DB::raw(
                            '(CASE
                        WHEN flash_sales.end_time IS NOT NULL
                            THEN flash_sale_products.price
                        WHEN products.offered IS NOT NULL
                            THEN products.selling
                        ELSE products.offered
                        END) AS current_price'
                        ))
                        ->orderBy('current_price', 'asc');

                } else if ($request->sortby == 'price_high_to_low') {

                    $query = $query
                        ->addSelect(DB::raw(
                            '(CASE
                        WHEN flash_sales.end_time IS NOT NULL
                            THEN flash_sale_products.price
                        WHEN products.offered IS NOT NULL
                            THEN products.selling
                        ELSE products.offered
                        END) AS current_price'
                        ))
                        ->orderBy('current_price', 'desc');

                } else if ($request->sortby == 'avg_customer_review') {
                    $query = $query->orderBy('products.rating', 'desc');
                } else {
                    $query = $query->orderBy('products.created_at', 'desc');
                }
            } else {
                $query = $query->orderBy('products.updated_at', 'desc');
            }

            $pagination = Config::get('constants.listing.PAGINATION');

            $data['result'] = new ProductCollectionResource($query->paginate($pagination));

            $data['sub_category'] = $subCategory;
            $data['category'] = $category;
            $data['shipping'] = $allShipping;
            $data['shipping'] = $allShipping;
            $data['brands'] = $allBrand;
            $data['collections'] = $allCollection;

            return response()->json(new Response($request->token, $data));

        } catch (\Exception $e) {

            if ($e instanceof \PDOException) {
                return response()->json(Validation::error(null, explode('.', $e->getMessage())[0]));
            } else {
                return response()->json(Validation::error(null, $e->getMessage()));
            }
        }
    }


    public function store(Request $request)
    {
        try {

            $lang = $request->header('language');
            $slug = $request->slug;


            if ($lang) {

                $store = Store::where('slug', $slug)
                    ->leftJoin('store_langs as sl', function ($join) use ($lang) {
                        $join->on('sl.store_id', '=', 'stores.id');
                        $join->where('sl.lang', $lang);
                    })
                    ->select('stores.*', 'sl.name', 'sl.meta_title', 'sl.meta_description')
                    ->first();


                $query = Product::query();
                $query = $query->leftJoin('flash_sales', function ($join) {

                    $join->on('products.id', '=', 'flash_sale_products.product_id');

                    $join->leftJoin('flash_sale_products', function ($join) {
                        $join->on('flash_sales.id', '=', 'flash_sale_products.flash_sale_id');
                    });
                    $join->where('flash_sales.end_time', '>=', date('Y-m-d H:i:s'))
                        ->where('flash_sales.status', Config::get('constants.status.PUBLIC'));
                })
                    ->groupBy('products.id');

                $query = $query->leftJoin('product_langs as pl', function ($join) use ($lang) {
                    $join->on('pl.product_id', '=', 'products.id');
                    $join->where('pl.lang', $lang);
                });

                $query = $query->where('products.admin_id', $store->admin_id);
                $query = $query->where('products.status', Config::get('constants.status.PUBLIC'));
                $query = $query->select('products.id', 'pl.title', 'products.slug', 'pl.badge',
                    'products.selling', 'products.offered',
                    'products.image', 'products.review_count', 'products.rating', 'flash_sale_products.price',
                    'flash_sales.end_time');

            } else {


                $store = Store::where('slug', $slug)->first();
                $query = Product::query();
                $query = $query->leftJoin('flash_sales', function ($join) {

                    $join->on('products.id', '=', 'flash_sale_products.product_id');

                    $join->leftJoin('flash_sale_products', function ($join) {
                        $join->on('flash_sales.id', '=', 'flash_sale_products.flash_sale_id');
                    });
                    $join->where('flash_sales.end_time', '>=', date('Y-m-d H:i:s'))
                        ->where('flash_sales.status', Config::get('constants.status.PUBLIC'));
                })
                    ->groupBy('products.id');


                $query = $query->where('products.admin_id', $store->admin_id);
                $query = $query->where('products.status', Config::get('constants.status.PUBLIC'));
                $query = $query->select('products.id', 'products.title', 'products.slug', 'products.badge',
                    'products.selling', 'products.offered',
                    'products.image', 'products.review_count', 'products.rating', 'flash_sale_products.price',
                    'flash_sales.end_time');
            }


            if ($request->sortby) {
                if ($request->sortby == 'price_low_to_high') {

                    $query = $query
                        ->addSelect(DB::raw(
                            '(CASE
                        WHEN flash_sales.end_time IS NOT NULL
                            THEN flash_sale_products.price
                        WHEN products.offered IS NOT NULL
                            THEN products.selling
                        ELSE products.offered
                        END) AS current_price'
                        ))
                        ->orderBy('current_price', 'asc');

                } else if ($request->sortby == 'price_high_to_low') {

                    $query = $query
                        ->addSelect(DB::raw(
                            '(CASE
                        WHEN flash_sales.end_time IS NOT NULL
                            THEN flash_sale_products.price
                        WHEN products.offered IS NOT NULL
                            THEN products.selling
                        ELSE products.offered
                        END) AS current_price'
                        ))
                        ->orderBy('current_price', 'desc');

                } else if ($request->sortby == 'avg_customer_review') {
                    $query = $query->orderBy('products.rating', 'desc');
                } else {
                    $query = $query->orderBy('products.created_at', 'desc');
                }
            } else {
                $query = $query->orderBy('products.updated_at', 'desc');
            }

            $pagination = Config::get('constants.listing.PAGINATION');

            $data['result'] = $query->paginate($pagination);
            $data['store'] = $store;
            $data['following'] = false;
            $data['review'] = 0;


            if ($request->required_rating) {
                $data['review'] = Product::where('admin_id', $store->admin_id)->avg('rating');
            }


            if (Auth::guard('user')->check()) {

                $user = Auth::guard('user')->user();

                $followed = UserFollowStore::where('user_id', $user->id)
                    ->where('store_id', $store->id)
                    ->first();

                if ($followed) {
                    $data['following'] = true;
                }
            }


            return response()->json(new Response($request->token, $data));

        } catch (\Exception $e) {

            if ($e instanceof \PDOException) {
                return response()->json(Validation::error(null, explode('.', $e->getMessage())[0]));
            } else {
                return response()->json(Validation::error(null, $e->getMessage()));
            }
        }
    }



    public function countriesPhones(Request $request)
    {
        try {

            $cacheKey = 'countries-phones';

            $resp = Utils::cacheRemember($cacheKey, function () use ($request) {

                $countries = file_get_contents(base_path() . '/storage/resources/countries.json');
                $phones = file_get_contents(base_path() . '/storage/resources/phones.json');

                $data['countries'] = json_decode($countries, true);
                $data['phones'] = json_decode($phones, true);

                return $data;

            });

            return response()->json(new Response(null, $resp));


        } catch (\Exception $e) {

            return response()->json(Validation::error($request->token, $e->getMessage()));
        }
    }


    public function resource(Request $request, $name)
    {
        try {

            $cacheKey = $name;

            $resp = Utils::cacheRemember($cacheKey, function () use ($request, $name) {

                $data = file_get_contents(base_path() . '/storage/resources/' . $name . '.json');

                return json_decode($data, true);

            });

            return response()->json(new Response(null, $resp));


        } catch (\Exception $e) {

            return response()->json(Validation::error($request->token, $e->getMessage()));
        }
    }


    public function localization(Request $request)
    {
        try {

            $langCode = $request->locale_code;

            $cacheKey = "frontend-lang" . $langCode;
            if (!$langCode) {
                $cacheKey = "frontend-lang";
            }

            $resp = Utils::cacheRemember($cacheKey, function () use ($request, $langCode) {

                $data = file_get_contents(base_path() . '/resources/lang/' . $langCode . '/frontend.json');

                return json_decode($data, true);

            });

            return response()->json(new Response(null, $resp));

        } catch (\Exception $e) {

            return response()->json(Validation::error($request->token, $e->getMessage()));
        }
    }


    public function localizationAdmin(Request $request)
    {
        try {

            $langCode = $request->locale_code;

            $cacheKey = "admin-lang" . $langCode;
            if (!$langCode) {
                $cacheKey = "admin-lang";
            }

            $resp = Utils::cacheRemember($cacheKey, function () use ($request, $langCode) {

                $data = file_get_contents(base_path() . '/resources/lang/' . $langCode . '/admin.json');

                return json_decode($data, true);

            });

            return response()->json(new Response(null, $resp));

        } catch (\Exception $e) {

            return response()->json(Validation::error($request->token, $e->getMessage()));
            //return response()->json(Validation::error($request->token, __('lang.lang_err_msg')));
        }
    }


    public function paymentGateway(Request $request)
    {
        try {
            $data = Payment::first();

            return response()->json(new Response($request->token, $data));

        } catch (\Exception $e) {

            if ($e instanceof \PDOException) {
                return response()->json(Validation::error(null, explode('.', $e->getMessage())[0]));
            } else {
                return response()->json(Validation::error(null, $e->getMessage()));
            }
        }
    }

    public function categories(Request $request)
    {
        try {
            $lang = $request->header('language');


            $query = SubCategory::query();

            if ($lang) {

                $query = $query->leftJoin('sub_category_langs as scl', function ($join) use ($lang) {
                    $join->on('scl.sub_category_id', '=', 'sub_categories.id');
                    $join->where('scl.lang', $lang);
                });
                $query = $query->select('sub_categories.id', 'sub_categories.slug', 'sub_categories.category_id',
                    'sub_categories.image', 'scl.title', 'scl.meta_title', 'scl.meta_description');


            } else {
                $query = $query->select('title', 'image', 'slug', 'category_id', 'id');
            }


            $query = $query->where('sub_categories.status', Config::get('constants.status.PUBLIC'));
            $data = $query->paginate(Config::get('constants.frontend.PAGINATION'));

            return response()->json(new Response($request->token, $data));

        } catch (\Exception $e) {

            if ($e instanceof \PDOException) {
                return response()->json(Validation::error(null, explode('.', $e->getMessage())[0]));
            } else {
                return response()->json(Validation::error(null, $e->getMessage()));
            }
        }
    }


    public function brands(Request $request)
    {
        try {
            $lang = $request->header('language');


            $query = Brand::query();


            if ($lang) {

                $query = $query->leftJoin('brand_langs as b', function ($join) use ($lang) {
                    $join->on('b.brand_id', '=', 'brands.id');
                    $join->where('b.lang', $lang);
                });
                $query = $query->select('brands.id', 'brands.slug', 'brands.image', 'b.title');


            } else {
                $query = $query->select('title', 'image', 'id', 'slug');
            }


            $query = $query->where('brands.status', Config::get('constants.status.PUBLIC'));
            $data = $query->paginate(Config::get('constants.frontend.PAGINATION'));

            return response()->json(new Response($request->token, $data));


        } catch (\Exception $e) {

            if ($e instanceof \PDOException) {
                return response()->json(Validation::error(null, explode('.', $e->getMessage())[0]));
            } else {
                return response()->json(Validation::error(null, $e->getMessage()));
            }
        }
    }

    public function search(Request $request)
    {
        try {
            $lang = $request->header('language');


            $data['product'] = [];
            $data['suggested'] = [];
            $data['category'] = [];
            $data['sub_category'] = [];

            if ($request->q) {
                $queryS = SubCategory::query();
                $queryC = Category::query();
                $queryP = Product::query();


                if ($lang) {

                    $queryS = $queryS->leftJoin('sub_category_langs as scl', function ($join) use ($lang) {
                        $join->on('scl.sub_category_id', '=', 'sub_categories.id');
                        $join->where('scl.lang', $lang);
                    });
                    $queryS = $queryS->with(['category' => function ($query) use ($lang) {
                        $query->leftJoin('category_langs as cl',
                            function ($join) use ($lang) {
                                $join->on('categories.id', '=', 'cl.category_id');
                                $join->where('cl.lang', $lang);
                            })
                            ->select('categories.id', 'cl.title', 'categories.image', 'categories.slug');
                    }]);
                    $queryS = $queryS->where('scl.title', 'LIKE', "%{$request->q}%");
                    $queryS = $queryS->select('sub_categories.id', 'scl.title', 'sub_categories.image',
                        'sub_categories.category_id', 'sub_categories.slug');


                    $queryC = $queryC->leftJoin('category_langs as cl', function ($join) use ($lang) {
                        $join->on('cl.category_id', '=', 'categories.id');
                        $join->where('cl.lang', $lang);
                    });

                    $queryC = $queryC->select('categories.id', 'categories.image', 'cl.title', 'categories.slug');


                    $queryP = $queryP->leftJoin('product_langs as pl', function ($join) use ($lang) {
                        $join->on('pl.product_id', '=', 'products.id');
                        $join->where('pl.lang', $lang);
                    });


                    $queryP = $queryP->select('products.id', 'pl.title', 'products.slug',
                        'products.selling', 'products.offered',
                        'products.image', 'products.review_count', 'products.rating', 'flash_sale_products.price',
                        'flash_sales.end_time');

                    $queryP = $queryP->where(function ($q) use ($request) {
                        $q->where('pl.title', 'LIKE', "%{$request->q}%")
                            ->orWhere('products.tags', 'LIKE', "%{$request->q}%");
                    });

                } else {

                    $queryS = $queryS->with('category');
                    $queryS = $queryS->where('title', 'LIKE', "%{$request->q}%");
                    $queryS = $queryS->select('id', 'title', 'image', 'category_id', 'slug');


                    $queryC = $queryC->where('title', 'LIKE', "%{$request->q}%");
                    $queryC = $queryC->select('id', 'image', 'title', 'slug');


                    $queryP = $queryP->select('products.id', 'products.title', 'products.slug',
                        'products.selling', 'products.offered',
                        'products.image', 'products.review_count', 'products.rating', 'flash_sale_products.price',
                        'flash_sales.end_time');

                    $queryP = $queryP->where(function ($q) use ($request) {
                        $q->where('products.title', 'LIKE', "%{$request->q}%")
                            ->orWhere('products.tags', 'LIKE', "%{$request->q}%");
                    });
                }

                $queryS = $queryS->where('status', Config::get('constants.status.PUBLIC'));
                $queryS = $queryS->limit(Config::get('constants.pagination.FRONTEND_SEARCH'));
                $data['sub_category'] = $queryS->get();


                $queryC = $queryC->where('status', Config::get('constants.status.PUBLIC'));
                $queryC = $queryC->limit(Config::get('constants.pagination.FRONTEND_SEARCH'));

                $data['category'] = $queryC->get();

                $queryT = Tag::query();
                $queryT = $queryT->where(function ($q) use ($request) {
                    $q->where('title', 'LIKE', "%{$request->q}%");
                });
                $queryT = $queryT->limit(Config::get('constants.pagination.FRONTEND_SEARCH'));
                $queryT = $queryT->select('id', 'title');
                $data['suggested'] = $queryT->get();


                $queryP = $queryP->leftJoin('flash_sales', function ($join) {

                    $join->on('products.id', '=', 'flash_sale_products.product_id');

                    $join->leftJoin('flash_sale_products', function ($join) {
                        $join->on('flash_sales.id', '=', 'flash_sale_products.flash_sale_id');
                    });
                    $join->where('flash_sales.end_time', '>=', date('Y-m-d H:i:s'))
                        ->where('flash_sales.status', Config::get('constants.status.PUBLIC'));
                });


                $queryP = $queryP->limit(Config::get('constants.pagination.FRONTEND_SEARCH'));
                $queryP = $queryP->where('products.status', Config::get('constants.status.PUBLIC'));
                $data['result'] = $queryP->get();

                $data['product'] = SearchResource::collection($queryP->get());


            }

            return response()->json(new Response($request->token, $data));


        } catch (\Exception $e) {

            if ($e instanceof \PDOException) {
                return response()->json(Validation::error(null, explode('.', $e->getMessage())[0]));
            } else {
                return response()->json(Validation::error(null, $e->getMessage()));
            }
        }
    }


    public function products(Request $request)
    {
        try {

            $lang = $request->header('language');


            $query = Product::query();
            $query = $query->leftJoin('flash_sales', function ($join) {

                $join->on('products.id', '=', 'flash_sale_products.product_id');

                $join->leftJoin('flash_sale_products', function ($join) {
                    $join->on('flash_sales.id', '=', 'flash_sale_products.flash_sale_id');
                });
                $join->where('flash_sales.end_time', '>=', date('Y-m-d H:i:s'))
                    ->where('flash_sales.status', Config::get('constants.status.PUBLIC'));
            })
                ->groupBy('products.id');


            $sourceResponse = null;
            $allCategories = null;
            $category = null;
            $allShipping = null;
            $allCollection = null;
            $allBrand = null;
            $source = null;
            $noCategory = false;
            $sidebarData = $request->sidebar_data === 'true' ? true : false;

            /*if ($request->q) {
                $query = $query->where(function ($q) use ($request) {
                    $q->where('products.title', 'LIKE', "%{$request->q}%")
                        ->orWhere('products.tags', 'LIKE', "%{$request->q}%");
                });
            } else if ($request->home_spm || $request->banner) {

                if ($request->home_spm) {
                    // Products of slider
                    $source = HomeSlider::with('source_brands.brand')
                        ->with('source_categories.category')
                        ->with('source_sub_categories.sub_category')
                        ->with('source_products.product')
                        ->find($request->home_spm);
                } else {
                    $source = Banner::with('source_brands.brand')
                        ->with('source_categories.category')
                        ->with('source_sub_categories.sub_category')
                        ->with('source_products.product')
                        ->find($request->banner);
                }

            } else {
                if ($request->sub_category) {
                    $query = $query->where('products.subcategory_id', $request->sub_category);
                    $noCategory = true;
                }

                if ($request->category) {
                    $query = $query->where('products.category_id', $request->category);

                    $category = Category::with('public_sub_categories')->where('id', $request->category)->first();

                    if (is_null($category)) {
                        return response()->json(Validation::frontendError());
                    }
                    $noCategory = true;
                }
            }*/


            if ($lang) {


                if ($request->q) {
                    $query = $query->where(function ($q) use ($request) {
                        $q->where('pl.title', 'LIKE', "%{$request->q}%")
                            ->orWhere('products.tags', 'LIKE', "%{$request->q}%");
                    });
                } else if ($request->home_spm || $request->banner) {

                    if ($request->home_spm) {
                        // Products of slider
                        $source = HomeSlider::with('source_brands.brand')
                            ->leftJoin('home_slider_langs as cl', function ($join) use ($lang) {
                                $join->on('cl.home_slider_id', '=', 'home_sliders.id');
                                $join->where('cl.lang', $lang);
                            })
                            ->select('home_sliders.*', 'cl.title')
                            ->with('source_categories.category')
                            ->with('source_sub_categories.sub_category')
                            ->with('source_products.product')
                            ->find($request->home_spm);

                    } else {
                        $source = Banner::with('source_brands.brand')
                            ->leftJoin('banner_langs as cl', function ($join) use ($lang) {
                                $join->on('cl.banner_id', '=', 'banners.id');
                                $join->where('cl.lang', $lang);
                            })
                            ->select('banners.*', 'cl.title')
                            ->with('source_categories.category')
                            ->with('source_sub_categories.sub_category')
                            ->with('source_products.product')
                            ->find($request->banner);
                    }

                }


                $query = $query->leftJoin('product_langs as pl', function ($join) use ($lang) {
                    $join->on('pl.product_id', '=', 'products.id');
                    $join->where('pl.lang', $lang);
                });

                $query = $query->select(['products.id', 'products.slug', 'pl.badge', 'pl.title',
                    'products.selling', 'products.offered',
                    'products.image', 'products.review_count', 'products.rating', 'flash_sale_products.price',
                    'flash_sales.end_time']);


                if ($sidebarData) {
                    /* if (!$noCategory) {*/
                    $allCategories = Category::leftJoin('category_langs as cl', function ($join) use ($lang) {
                        $join->on('cl.category_id', '=', 'categories.id');
                        $join->where('cl.lang', $lang);
                    })
                        ->select('categories.*', 'cl.title')
                        ->where('status', Config::get('constants.status.PUBLIC'))
                        ->get();
                    /*}*/


                    $allBrand = Brand::leftJoin('brand_langs as b', function ($join) use ($lang) {
                        $join->on('b.brand_id', '=', 'brands.id');
                        $join->where('b.lang', $lang);
                    })
                        ->where('brands.status', Config::get('constants.status.PUBLIC'))
                        ->select('brands.id', 'brands.title', 'b.title')
                        ->get();

                    $allCollection = ProductCollection::leftJoin('product_collection_langs as pcl',
                        function ($join) use ($lang) {
                            $join->on('pcl.product_collection_id', '=', 'product_collections.id');
                            $join->where('pcl.lang', $lang);
                        })
                        ->where('product_collections.status', Config::get('constants.status.PUBLIC'))
                        ->select('product_collections.id', 'product_collections.title', 'pcl.title')
                        ->get();

                    $allShipping = ShippingRule::leftJoin('shipping_rule_langs as srl',
                        function ($join) use ($lang) {
                            $join->on('srl.shipping_rule_id', '=', 'shipping_rules.id');
                            $join->where('srl.lang', $lang);
                        })
                        ->select('shipping_rules.id', 'shipping_rules.title', 'srl.title')
                        ->get();

                }


            } else {


                if ($request->q) {
                    $query = $query->where(function ($q) use ($request) {
                        $q->where('products.title', 'LIKE', "%{$request->q}%")
                            ->orWhere('products.tags', 'LIKE', "%{$request->q}%");
                    });
                } else if ($request->home_spm || $request->banner) {

                    if ($request->home_spm) {
                        // Products of slider
                        $source = HomeSlider::with('source_brands.brand')
                            ->with('source_categories.category')
                            ->with('source_sub_categories.sub_category')
                            ->with('source_products.product')
                            ->find($request->home_spm);
                    } else {
                        $source = Banner::with('source_brands.brand')
                            ->with('source_categories.category')
                            ->with('source_sub_categories.sub_category')
                            ->with('source_products.product')
                            ->find($request->banner);
                    }

                }


                $query = $query->select(['products.id', 'products.badge', 'products.title', 'products.slug',
                    'products.selling', 'products.offered',
                    'products.image', 'products.review_count', 'products.rating', 'flash_sale_products.price',
                    'flash_sales.end_time']);


                if ($sidebarData) {
                    if (!$noCategory) {
                        $allCategories = Category::where('status', Config::get('constants.status.PUBLIC'))->get();
                    }
                    $allBrand = Brand::where('status', Config::get('constants.status.PUBLIC'))->select('id', 'title')->get();
                    $allCollection = ProductCollection::where('status', Config::get('constants.status.PUBLIC'))
                        ->select('id', 'title')->get();

                    $allShipping = ShippingRule::select('id', 'title')->get();
                }

            }


            if (!is_null($source)) {

                $sourceResponse['id'] = $source->id;
                $sourceResponse['title'] = $source->title;

                if ((int)$source['source_type'] === Config::get('constants.sliderSourceType.CATEGORY')) {
                    $itemIds = [];
                    foreach ($source['source_categories'] as $item) {
                        array_push($itemIds, $item['category']['id']);
                    }
                    $query = $query->whereIn('products.category_id', $itemIds);
                } else if ((int)$source['source_type'] === Config::get('constants.sliderSourceType.SUB_CATEGORY')) {
                    $itemIds = [];
                    foreach ($source['source_sub_categories'] as $item) {
                        array_push($itemIds, $item['sub_category']['id']);
                    }
                    $query = $query->whereIn('products.subcategory_id', $itemIds);
                } else if ((int)$source['source_type'] === Config::get('constants.sliderSourceType.BRAND')) {
                    $itemIds = [];
                    foreach ($source['source_brands'] as $item) {
                        array_push($itemIds, $item['brand']['id']);
                    }
                    $query = $query->whereIn('products.brand_id', $itemIds);
                } else if ((int)$source['source_type'] === Config::get('constants.sliderSourceType.TAG')) {
                    foreach (explode(',', $source->tags) as $tag) {
                        if ($tag) {
                            $query = $query->where('products.tags', 'LIKE', "%{$tag}%");
                        }
                    }
                } else if ((int)$source['source_type'] === Config::get('constants.sliderSourceType.PRODUCT')) {
                    $itemIds = [];
                    foreach ($source['source_products'] as $item) {
                        array_push($itemIds, $item['product']['id']);
                    }
                    $query = $query->whereIn('products.id', $itemIds);
                }
            }


            $data['source'] = $sourceResponse;


            if ($request->brand) {
                $query = $query->whereIn('products.brand_id', explode(',', $request->brand));
            }

            if ($request->collection) {
                $query = $query
                    ->rightJoin('collection_with_products as cwp', function ($join) {
                        $join->on('products.id', '=', 'cwp.product_id');
                    })
                    ->rightJoin('product_collections as pc', function ($join) use ($request) {
                        $join->on('pc.id', '=', 'cwp.product_collection_id');
                        $join->where('pc.status', Config::get('constants.status.PUBLIC'))
                            ->whereIn('pc.id', explode(',', $request->collection));
                    });
            }

            if ($request->rating != 0) {
                $query = $query->where('products.rating', '>=', $request->rating);
            }

            if ($request->max > 0 || $request->min > 0 ) {
                if ($request->max == 0) {
                    $request->max = 999999;
                }
                /*
                    Price Filter By Currency
                */
                $min = floatval($request->min);
                $max = floatval($request->max);
                if($request->header('currency') == 'usd'){
                    $min *= getDollar()->price;
                    $max *= getDollar()->price;
                }
                $query = $query->where(function ($q) use ($min,$max) {
                    $q->where(function ($qr) use ($min,$max) {
                        $qr->whereNotNull('flash_sales.end_time');
                        $qr->whereBetween('flash_sale_products.price', [$min,$max]);
                    });
                    $q->orWhere(function ($qr) use ($min,$max) {
                        $qr->whereNull('flash_sales.end_time');
                        $qr->whereNotNull('products.offered');
                        $qr->whereBetween('products.offered', [$min, $max]);
                        return $qr;
                    });
                    $q->orWhere(function ($qr) use ($min,$max) {
                        $qr->whereNull('flash_sales.end_time');
                        $qr->whereNull('products.offered');
                        $qr->whereBetween('products.selling', [$min, $max]);
                    });

                });

            }


            $query = $query->where('products.status', Config::get('constants.status.PUBLIC'));


            if ($request->shipping) {
                $query = $query->whereIn('products.shipping_rule_id', explode(',', $request->shipping));
            }
            /*
                Sort Products By Price Hight To low Or Low to high
            */
            if ($request->sortby) {
                if ($request->sortby == 'price_low_to_high' || $request->sortby = 'price_high_to_low') {
                    $sort = $request->sortby == 'price_low_to_high' ? 'ASC' : 'DESC';
                    $query = $query->addSelect(DB::raw('(CASE
                        WHEN flash_sale_products.price IS NOT NULL AND (flash_sale_products.price < products.offered
                             OR products.offered IS NULL)
                            THEN flash_sale_products.price
                        WHEN products.offered IS NOT NULL
                            THEN products.offered
                        WHEN products.selling IS NOT NULL AND products.selling != 0
                            THEN products.selling

                 END) AS current_price,flash_sale_products.price AS flash_sale'))->orderBy('current_price',$sort);
                } else if ($request->sortby == 'avg_customer_review') {
                    $query = $query->orderBy('products.rating', 'desc');
                } else {
                    $query = $query->orderBy('products.created_at', 'desc');
                }
            } else {
                $query = $query->orderBy('products.updated_at', 'desc');
            }

            $pagination = Config::get('constants.listing.PAGINATION');
            if ($request->is_home_page) {
                $pagination = Config::get('constants.homeProduct.PAGINATION');
            }

            /*
             * $data['result'] ResourceCollection Added
             */
            $data['result'] = new ProductCollectionResource($query->paginate($pagination));
            $data['category'] = $category;
            $data['all_categories'] = $allCategories;
            $data['shipping'] = $allShipping;
            $data['brands'] = $allBrand;
            $data['collections'] = $allCollection;

            return response()->json(new Response($request->token, $data));

        } catch (\Exception $e) {

            throw $e;

//            if ($e instanceof \PDOException) {
//                return response()->json(Validation::error(null, explode('.', $e->getMessage())[0]));
//            } else {
//                return response()->json(Validation::error(null, $e->getMessage()));
//            }
        }
    }

    public function common(Request $request)
    {
        try {

            $lang = $request->header('lang');

            $cacheKey = "common" . $lang;
            if (!$lang) {
                $cacheKey = "common";
            }

            $commonData = Utils::cacheRemember($cacheKey, function () use ($request, $lang) {


                $languages = Language::where('status', Config::get('constants.status.PUBLIC'))
                    ->orderBy('default', 'DESC')
                    ->orderBy('created_at', 'DESC')
                    ->select('name', 'code', 'default', 'direction', 'predefined')
                    ->get();

                $data['languages'] = $languages;

                if (count($languages) > 0) {
                    $data['default_language'] = $languages[0];

                    if ($languages[0]->code == $lang) {
                        $lang = null;
                    }
                }


                // PAYMENT
                /*$paymentGateway = Payment::first();
                if ($paymentGateway) {
                    $data['payment_gateway'] = $paymentGateway;
                }*/

                $data['img_src_url'] = FileHelper::imgSrcUrl();
                $data['thumb_prefix'] = 'thumb-';
                $data['default_image'] = 'default-image.webp';
//                dd($data['default_image']);
//                throw new \Exception(env('DEFAULT_IMAGE'));

                if ($lang) {


                    // HEADER LINKS
                    $hl = HeaderLink::leftJoin('header_link_langs as hl', function ($join) use ($lang) {
                        $join->on('hl.header_link_id', '=', 'header_links.id');
                        $join->where('hl.lang', $lang);
                    })
                        ->orderBy('created_at', 'ASC')
                        ->select('header_links.*', 'hl.title')
                        ->get();


                    $headerLinks['left'] = [];
                    $headerLinks['right'] = [];

                    foreach ($hl as $i) {
                        if ((int)$i->type == Config::get('constants.headerLinkType.LEFT')) {
                            array_push($headerLinks['left'], $i);
                        } else {
                            array_push($headerLinks['right'], $i);
                        }
                    }
                    $data['header_links'] = $headerLinks;


                    // SETTING
                    $siteSetting = SiteSetting::leftJoin('site_setting_langs as cl', function ($join) use ($lang) {
                        $join->on('cl.site_setting_id', '=', 'site_settings.id');
                        $join->where('cl.lang', $lang);
                    })
                        ->select('site_settings.*', 'cl.site_name', 'cl.copyright_text', 'cl.meta_title', 'cl.meta_description')
                        ->first();


                    // FOOTER CATEGORIES
                    $query = Category::query();

                    $query = $query->with(['public_sub_categories' => function ($query) use ($lang) {

                        $query->leftJoin('sub_category_langs as scl', function ($join) use ($lang) {
                            $join->on('scl.sub_category_id', '=', 'sub_categories.id');
                            $join->where('scl.lang', $lang);
                        })
                            ->select('sub_categories.id', 'sub_categories.category_id',
                                'sub_categories.slug', 'scl.title');
                    }])
                        ->leftJoin('category_langs as cl', function ($join) use ($lang) {
                            $join->on('cl.category_id', '=', 'categories.id');
                            $join->where('cl.lang', $lang);
                        })
                        ->select('categories.id', 'cl.title', 'categories.slug')
                        ->orderBy('categories.created_at', 'desc')
                        ->where('categories.status', Config::get('constants.status.PUBLIC'));

                    $categories = $query->get();

                    // Top banner
                    $data['top_banner'] = Banner::where('type', Config::get('constants.banner.BANNER_8'))->get()->first();
                    $data['popup_banner'] = Banner::where('type', Config::get('constants.banner.BANNER_9'))->get()->first();


                    $footerLinks = FooterLink::with(['page' => function ($query) use ($lang) {

                        $query->leftJoin('page_langs as pl', function ($join) use ($lang) {
                            $join->on('pl.page_id', '=', 'pages.id');
                            $join->where('pl.lang', $lang);
                        })
                            ->select('pages.*', 'pl.title');
                    }])
                        ->orderBy('created_at', 'DESC')
                        ->get();

                } else {

                    // HEADER LINKS
                    $hl = HeaderLink::orderBy('created_at', 'ASC')
                        ->get();


                    $headerLinks['left'] = [];
                    $headerLinks['right'] = [];

                    foreach ($hl as $i) {
                        if ((int)$i->type == Config::get('constants.headerLinkType.LEFT')) {
                            array_push($headerLinks['left'], $i);
                        } else {
                            array_push($headerLinks['right'], $i);
                        }
                    }
                    $data['header_links'] = $headerLinks;


                    // SETTING
                    $siteSetting = SiteSetting::select()->first();

                    // FOOTER CATEGORIES
                    $categories = Category::with('public_sub_categories')
                        ->orderBy('created_at', 'desc')
                        ->where('status', Config::get('constants.status.PUBLIC'))
                        ->select('id', 'title', 'slug')
                        ->get();

                    // Top banner
                    $data['top_banner'] = Banner::where('type', Config::get('constants.banner.BANNER_8'))->get()->first();
                    $data['popup_banner'] = Banner::where('type', Config::get('constants.banner.BANNER_9'))->get()->first();


                    $footerLinks = FooterLink::with('page')
                        ->orderBy('created_at', 'DESC')
                        ->get();
                }


                if ($siteSetting) {
                    $data['site_setting'] = $siteSetting;
                }

                $data['site_setting']['api_base'] = url('/');

                $data['site_setting']['supported_currencies'] = [
                    [
                        'currency' => 'AFN',
                        'symbol' => '؋',
                        'position' => 2
                    ],
                    [
                        'currency' => getDollar()->code,
                        'symbol' => getDollar()->symbol,
                        'position' => getDollar()->position
                    ],
                ];
//                $currencies = getCurrencies();
//                $data['site_setting']['supported_currencies'] =
//                    foreach ($currencies as $currency)
//                    {
//                        array_push($data['site_setting']['supported_currencies'],[
//                            'currency' => $currency->code,
//                            'symbol' => $currency->symbol,
//                            'position' => $currency->position
//                        ]);
//                    }


                // SETTING
                $setting = Setting::select('currency', 'currency_icon', 'currency_position', 'phone', 'email',
                    'address_1', 'address_2', 'city', 'state', 'zip', 'country')
                    ->first();
                if ($setting) {
                    $data['setting'] = $setting;
                }


                $data['categories'] = $categories;


                // FOOTER PAGES
                $data['services'] = [];
                $data['about'] = [];
                foreach ($footerLinks as $item) {
                    if ($item->page->title) {
                        $page['id'] = $item->id;
                        $page['title'] = $item->page->title;
                        $page['slug'] = $item->page->slug;

                        if ((int)$item->type === Config::get('constants.footerLinkType.SERVICE')) {
                            array_push($data['services'], $page);
                        } else {
                            array_push($data['about'], $page);
                        }
                    }
                }

                $footerImageLinks = FooterImageLink::orderBy('created_at', 'desc')
                    ->where('status', Config::get('constants.status.PUBLIC'))
                    ->get();

                $data['payment'] = [];
                $data['social'] = [];
                foreach ($footerImageLinks as $item) {
                    if ((int)$item->type === Config::get('constants.footerImageLinkType.PAYMENT')) {
                        array_push($data['payment'], $item);
                    } else {
                        array_push($data['social'], $item);
                    }
                }

                /* return response()->json(new Response(null, $data));*/
                return $data;
            });

            return response()->json(new Response(null, $commonData));


        } catch (\Exception $e) {

            if ($e instanceof \PDOException) {
                return response()->json(Validation::error(null, explode('.', $e->getMessage())[0]));
            } else {
                return response()->json(Validation::error(null, $e->getMessage()));
            }
        }
    }


    public function home(Request $request)
    {
        try {

            $lang = $request->header('language');

            $cacheKey = "home" . $lang;

            if (!$lang) {
                $cacheKey = "home";
            }


            $homeData = Utils::cacheRemember($cacheKey . $lang, function () use ($request, $lang) {

                if ($lang) {


                    // SLIDER
                    $sliders = HomeSlider::where('status', Config::get('constants.status.PUBLIC'))
                        ->leftJoin('home_slider_langs as cl', function ($join) use ($lang) {
                            $join->on('cl.home_slider_id', '=', 'home_sliders.id');
                            $join->where('cl.lang', $lang);
                        })
                        ->select('home_sliders.*', 'cl.title')
                        ->get();

                    // Banners

                    $data['banners'] = Banner::where('status', Config::get('constants.status.PUBLIC'))
                        ->leftJoin('banner_langs as cl', function ($join) use ($lang) {
                            $join->on('cl.banner_id', '=', 'banners.id');
                            $join->where('cl.lang', $lang);
                        })
                        ->select('banners.*', 'cl.title')
                        ->get();

                    // FEATURED CATEGORIES
                    $featured_categories = SubCategory::with('category')
                        ->where('featured', Config::get('constants.status.PUBLIC'))
                        ->where('status', Config::get('constants.status.PUBLIC'))
                        ->offset(0)
                        ->leftJoin('sub_category_langs as scl', function ($join) use ($lang) {
                            $join->on('scl.sub_category_id', '=', 'sub_categories.id');
                            $join->where('scl.lang', $lang);
                        })
                        ->select('sub_categories.*', 'scl.title')
                        ->limit(Config::get('constants.homePagePagination.FEATURED_CATEGORIES'))
                        ->get();


                    // FLASH SALES
                    $flashSales = FlashSale::with(['public_products' => function ($query) use ($lang) {
                        $query->leftJoin('product_langs as avl',
                            function ($join) use ($lang) {
                                $join->on('p.id', '=', 'avl.product_id');
                                $join->where('avl.lang', $lang);
                            })
                            ->select('flash_sale_products.*', 'p.id', 'p.slug', 'p.selling', 'p.offered',
                                'p.image', 'p.review_count', 'p.rating', 'avl.title', 'avl.badge');
                    }])
                        ->leftJoin('flash_sale_langs as cl', function ($join) use ($lang) {
                            $join->on('cl.flash_sale_id', '=', 'flash_sales.id');
                            $join->where('cl.lang', $lang);
                        })
                        ->select('flash_sales.*', 'cl.title')
                        ->where('status', Config::get('constants.status.PUBLIC'))
                        ->where('end_time', '>=', date('Y-m-d H:i:s'))
                        ->get();


                    // PRODUCT COLLECTION
                    $collectionsQuery = ProductCollection::query();
                    $totalRecordCount = $collectionsQuery->count();

                    $collectionsQuery = $collectionsQuery->leftJoin('product_collection_langs as pcl',
                        function ($join) use ($lang) {
                            $join->on('pcl.product_collection_id', '=', 'product_collections.id');
                            $join->where('pcl.lang', $lang);
                        });
                    $collectionsQuery = $collectionsQuery->select('product_collections.*', 'pcl.title');



                    $data['collections'] = $collectionsQuery->with([
                        'product_collections' => function ($query) use ($totalRecordCount, $lang) {
                            $query->take(Config::get('constants.homePagePagination.COLLECTION') * $totalRecordCount);


                            $query->leftJoin('product_langs as avl',
                                function ($join) use ($lang) {
                                    $join->on('products.id', '=', 'avl.product_id');
                                    $join->where('avl.lang', $lang);
                                })
                                ->select('collection_with_products.*', 'products.id',
                                    'products.slug', 'avl.badge',
                                    'products.selling', 'products.offered',
                                    'products.image', 'products.review_count', 'products.rating',
                                    'products.shipping_rule_id',
                                    'flash_sale_products.price',
                                    'flash_sales.end_time', 'avl.title');

                        }
                    ])
                        ->where('status', Config::get('constants.status.PUBLIC'))
                        ->get();


                    // FEATURED BRANDS
                    $featured_brands = Brand::leftJoin('brand_langs as bl', function ($join) use ($lang) {
                        $join->on('bl.brand_id', '=', 'brands.id');
                        $join->where('bl.lang', $lang);
                    })
                        ->select('brands.*', 'bl.title')
                        ->where('featured', Config::get('constants.status.PUBLIC'))
                        ->where('status', Config::get('constants.status.PUBLIC'))
                        ->offset(0)
                        ->limit(Config::get('constants.homePagePagination.FEATURED_BRANDS'))
                        ->get();


                } else {


                    // SLIDER
                    $sliders = HomeSlider::where('status', Config::get('constants.status.PUBLIC'))
                        ->select('home_sliders.*')
                        ->get();

                    // Banners

                    $data['banners'] = Banner::where('status', Config::get('constants.status.PUBLIC'))
                        ->select('banners.*')
                        ->get();

                    // FEATURED CATEGORIES
                    $featured_categories = SubCategory::with('category')
                        ->where('featured', Config::get('constants.status.PUBLIC'))
                        ->where('status', Config::get('constants.status.PUBLIC'))
                        ->offset(0)
                        ->limit(Config::get('constants.homePagePagination.FEATURED_CATEGORIES'))
                        ->get();


                    // FLASH SALES
                    $flashSales = FlashSale::with('public_products')
                        ->where('status', Config::get('constants.status.PUBLIC'))
                        ->where('end_time', '>=', date('Y-m-d H:i:s'))
                        ->get();

                    // PRODUCT COLLECTION
                    $collections = ProductCollection::query();

                    $totalRecordCount = $collections->count();

                    $data['collections'] = $collections->with(['product_collections' =>
                        function ($query) use ($totalRecordCount) {
                            $query->take(Config::get('constants.homePagePagination.COLLECTION') * $totalRecordCount);
                        }
                    ])->where('status', Config::get('constants.status.PUBLIC'))
                        ->get();

                    // FEATURED BRANDS
                    $featured_brands = Brand::where('featured', Config::get('constants.status.PUBLIC'))
                        ->where('status', Config::get('constants.status.PUBLIC'))
                        ->select('brands.*')
                        ->offset(0)
                        ->limit(Config::get('constants.homePagePagination.FEATURED_BRANDS'))
                        ->get();
                }


                $sliderImages['main'] = [];
                foreach ($sliders as $item) {
                    if ((int)$item->type === Config::get('constants.homeSlider.MAIN')) {
                        array_push($sliderImages['main'], $item);
                    } else if ((int)$item->type === Config::get('constants.homeSlider.RIGHT_TOP')) {
                        $sliderImages['right_top'] = $item;
                    } else if ((int)$item->type === Config::get('constants.homeSlider.RIGHT_BOTTOM')) {
                        $sliderImages['right_bottom'] = $item;
                    }
                }

                $data['slider'] = $sliderImages;


                $data['featured_categories'] = $featured_categories;

                $pagination = Config::get('constants.listing.PAGINATION');
                $data['flash_sales'] = [];
//                $flashSales = $flashSales->get();

//                $publicProducts = FlashSaleResource::collection($item->public_products);

                /*
                 * Flash Resource Added in order to make User frontend receive correct data
                 * Based On Currencies
                 */
                foreach ($flashSales as $item) {
                    $end_time = $item->end_time;
                    if (count($item->public_products) > 0) {
                        $flashSale = $item->public_products;
                       $flashSale->map(function ($object) use($end_time){

                          $object->end_time = $end_time;

                          return $object;
                       });

                        unset($item->public_products);
                        $item->public_products = FlashSaleResource::collection($flashSale);
                        array_push($data['flash_sales'],$item);
                    }
                }

//                dd($data['flash_sales']);
                /*
                 * Same As Above But for Product Collections
                 */
            $my_collections = $data['collections'];
                $data['collections'] = [];
                foreach ($my_collections as $item)
                {
                    if (count($item->product_collections) > 0){
                        $product_collection = $item->product_collections;
                        unset($item->product_collections);
                        $item->product_collections = FeaturedProductsResource::collection($product_collection);
                        array_push($data['collections'], $item);
                    }

                }
                $data['time_zone'] = Carbon::now()->timezoneName;


                $data['featured_brands'] = $featured_brands;

                /*return response()->json(new Response(null, $data));*/
                return $data;
            });

            return response()->json(new Response(null, $homeData));

        } catch (\Exception $e) {

            if ($e instanceof \PDOException) {
                return response()->json(Validation::error(null, explode('.', $e->getMessage())[0]));
            } else {
                return response()->json(Validation::error(null, $e->getMessage()));
            }
        }
    }


    public function reviews(Request $request, $id)
    {
        try {
            if ($request->get_total && $request->get_total === 'true') {
                $data['total'] = RatingReview::select(DB::raw('count(user_id) as total'), DB::raw('rating'))
                    ->groupBy(DB::raw('rating'))
                    ->where('product_id', $id)
                    ->get();


                $data['banner'] = Banner::where('type', Config::get('constants.banner.BANNER_7'))
                    ->where('status', Config::get('constants.status.PUBLIC'))
                    ->first();
            }

            $data['all'] = RatingReview::with('user')
                ->with('guest_user')
                ->with('review_images')
                ->where('product_id', $id)
                ->orderBy($request->order_by, $request->type)
                ->paginate(Config::get('constants.pagination.FRONTEND_PRODUCT_RATING'));


            if ($request->time_zone) {
                foreach ($data['all'] as $item) {
                    $item['created'] = Utils::formatDate(Utils::convertTimeToUSERzone($item->created_at, $request->time_zone));
                }

            } else {
                foreach ($data['all'] as $item) {
                    $item['created'] = Utils::formatDate($item->created_at);
                }
            }

            return response()->json(new Response($request->token, $data));

        } catch (\Exception $e) {

            if ($e instanceof \PDOException) {
                return response()->json(Validation::error(null, explode('.', $e->getMessage())[0]));
            } else {
                return response()->json(Validation::error(null, $e->getMessage()));
            }
        }
    }

    public function product(Request $request, $id)
    {
        try {


            $lang = $request->header('language');

            $cacheKey = 'detail.' . $id . $lang;
            if (!$lang) {
                $cacheKey = 'detail.' . $id;
            }


            $productData = Utils::cacheRemember($cacheKey, function () use ($request, $id, $lang) {

                if ($lang) {


                    $query = Product::query();

                    $query = $query->with(['brand' => function ($query) use ($lang) {
                        $query->leftJoin('brand_langs as bl',
                            function ($join) use ($lang) {
                                $join->on('brands.id', '=', 'bl.brand_id');
                                $join->where('bl.lang', $lang);
                            })
                            ->select('brands.*', 'bl.title');
                    }])
                        ->with(['store' => function ($query) use ($lang) {

                            $query->leftJoin('store_langs as sl', function ($join) use ($lang) {
                                $join->on('sl.store_id', '=', 'stores.id');
                                $join->where('sl.lang', $lang);
                            })
                                ->select('stores.*', 'sl.name');

                        }])
                        ->with(['bundle_deal' => function ($query) use ($lang) {

                            $query->leftJoin('bundle_deal_langs as pcl', function ($join) use ($lang) {
                                $join->on('pcl.bundle_deal_id', '=', 'bundle_deals.id');
                                $join->where('pcl.lang', $lang);
                            })->select('bundle_deals.id', 'bundle_deals.buy', 'bundle_deals.free', 'pcl.title');

                        }])
                        ->with(['current_categories' => function ($query) use ($lang) {


                            $query->leftJoin('sub_category_langs as scl', function ($join) use ($lang) {
                                $join->on('scl.sub_category_id', '=', 'sub_categories.id');
                                $join->where('scl.lang', $lang);
                            })->select('sub_categories.id', 'sub_categories.category_id',
                                'sub_categories.slug', 'scl.title');


                        }])
                        ->with(['category' => function ($query) use ($lang) {

                            $query->leftJoin('category_langs as cl', function ($join) use ($lang) {
                                $join->on('cl.category_id', '=', 'categories.id');
                                $join->where('cl.lang', $lang);
                            })
                                ->select('categories.id', 'categories.slug', 'cl.title');


                        }])
                        ->with(['sub_category' => function ($query) use ($lang) {


                            $query->leftJoin('sub_category_langs as scl', function ($join) use ($lang) {
                                $join->on('scl.sub_category_id', '=', 'sub_categories.id');
                                $join->where('scl.lang', $lang);
                            })
                                ->select('sub_categories.id', 'sub_categories.category_id',
                                    'sub_categories.slug', 'scl.title');


                        }])
                        ->with('product_image_names')
                        ->with('shipping_rule.shipping_places')
                        ->with(['shipping_rule' => function ($query) use ($lang) {


                            $query->leftJoin('shipping_rule_langs as srl', function ($join) use ($lang) {
                                $join->on('srl.shipping_rule_id', '=', 'shipping_rules.id');
                                $join->where('srl.lang', $lang);
                            })
                                ->select('shipping_rules.id', 'srl.title');


                        }]);


                    $query = $query->leftJoin('flash_sales', function ($join) {

                        $join->on('products.id', '=', 'flash_sale_products.product_id');

                        $join->leftJoin('flash_sale_products', function ($join) {
                            $join->on('flash_sales.id', '=', 'flash_sale_products.flash_sale_id');
                        });
                        $join->where('flash_sales.end_time', '>=', date('Y-m-d H:i:s'))
                            ->where('flash_sales.status', Config::get('constants.status.PUBLIC'));
                    });

                    $query = $query->leftJoin('user_wishlists', function ($join) use ($request) {
                        $join->on('products.id', '=', 'user_wishlists.product_id');
                        $join->where('user_wishlists.user_id', $request->user_id);
                    });

                    $query = $query->leftJoin('product_langs as pl', function ($join) use ($lang) {
                        $join->on('pl.product_id', '=', 'products.id');
                        $join->where('pl.lang', $lang);
                    });

                    $query = $query->select('products.*', 'pl.title',
                        'pl.description', 'pl.overview', 'pl.unit', 'pl.badge', 'pl.meta_title',
                        'pl.meta_description',
                        'flash_sale_products.price', 'flash_sales.end_time',
                        'user_wishlists.id as wishlisted');


                    $query = $query->where('products.status', Config::get('constants.status.PUBLIC'));

                    $data = $query->find($id);

                    if (!$data) {
                        return response()->json(Validation::frontendError());
                    }


                    $productInventoryAttr = Attribute::whereHas('values', function ($q) use ($id) {
                        $q->join('inventory_attributes as ia', function ($join) {
                            $join->on('ia.attribute_value_id', '=', 'attribute_values.id');
                        })
                            ->join('updated_inventories as i', function ($join) use ($id) {
                                $join->on('i.id', '=', 'ia.inventory_id');
                                $join->where('i.product_id', $id);
                            });

                    })
                        ->leftJoin('attribute_langs as al', function ($join) use ($lang) {
                            $join->on('al.attribute_id', '=', 'attributes.id');
                            $join->where('al.lang', $lang);
                        })
                        ->select('attributes.*', 'al.title')
                        ->with(['values' => function ($q) use ($id, $lang) {
                            $q->join('inventory_attributes as ia', function ($join) {
                                $join->on('ia.attribute_value_id', '=', 'attribute_values.id');
                            })
                                ->join('updated_inventories as i', function ($join) use ($id) {
                                    $join->on('i.id', '=', 'ia.inventory_id');
                                    $join->where('i.product_id', $id);
                                })
                                ->groupBy('attribute_values.id')
                                ->leftJoin('attribute_value_langs as avl',
                                    function ($join) use ($lang) {
                                        $join->on('attribute_values.id', '=', 'avl.attribute_value_id');
                                        $join->where('avl.lang', $lang);
                                    })
                                ->select('attribute_values.*', 'i.*', 'ia.*', 'avl.title');
                        }])
                        ->get();


                    $data['inventory'] = UpdatedInventory::with('inventory_attributes')
                        ->where('product_id', $id)->get();

                    $currentTime = Carbon::now()->format('Y-m-d H:i:s');

                    $data['vouchers'] = Voucher::where('end_time', '>=', $currentTime)
                        ->where('start_time', '<=', $currentTime)
                        ->where('status', Config::get('constants.status.PUBLIC'))
                        ->select('title', 'price', 'type', 'code', 'min_spend', 'usage_limit', 'limit_per_customer')
                        ->get();


                } else {

                    // $productData = Utils::cacheRemember('detail.' . $id, function () use ($request, $id) {
                    $query = Product::query();
                    $query = $query->with(['brand' => function ($query) {
                        $query->select('brands.id', 'brands.title');
                    }])
                        ->with('store')
                        ->with('bundle_deal')
                        ->with('current_categories')
                        ->with('category')
                        ->with('sub_category')
                        ->with('product_image_names')
                        ->with('shipping_rule.shipping_places');

                    $query = $query->leftJoin('flash_sales', function ($join) {

                        $join->on('products.id', '=', 'flash_sale_products.product_id');

                        $join->leftJoin('flash_sale_products', function ($join) {
                            $join->on('flash_sales.id', '=', 'flash_sale_products.flash_sale_id');
                        });
                        $join->where('flash_sales.end_time', '>=', date('Y-m-d H:i:s'))
                            ->where('flash_sales.status', Config::get('constants.status.PUBLIC'));
                    });

                    $query = $query->leftJoin('user_wishlists', function ($join) use ($request) {
                        $join->on('products.id', '=', 'user_wishlists.product_id');
                        $join->where('user_wishlists.user_id', $request->user_id);
                    });

                    $query = $query->select('products.*', 'flash_sale_products.price', 'flash_sales.end_time',
                        'user_wishlists.id as wishlisted');


                    $query = $query->where('products.status', Config::get('constants.status.PUBLIC'));

                    $data = $query->find($id);

                    if (!$data) {
                        return response()->json(Validation::frontendError());
                    }


                    $productInventoryAttr = Attribute::whereHas('values', function ($q) use ($id) {
                        $q->join('inventory_attributes as ia', function ($join) {
                            $join->on('ia.attribute_value_id', '=', 'attribute_values.id');
                        })
                            ->join('updated_inventories as i', function ($join) use ($id) {
                                $join->on('i.id', '=', 'ia.inventory_id');
                                $join->where('i.product_id', $id);
                            });

                    })
                        ->with(['values' => function ($q) use ($id) {
                            $q->join('inventory_attributes as ia', function ($join) {
                                $join->on('ia.attribute_value_id', '=', 'attribute_values.id');
                            })
                                ->join('updated_inventories as i', function ($join) use ($id) {
                                    $join->on('i.id', '=', 'ia.inventory_id');
                                    $join->where('i.product_id', $id);
                                })
                                ->groupBy('attribute_values.id');
                        }])
                        ->get();


                    $data['inventory'] = UpdatedInventory::with('inventory_attributes')
                        ->where('product_id', $id)->get();

                    $currentTime = Carbon::now()->format('Y-m-d H:i:s');

                    $data['vouchers'] = Voucher::where('end_time', '>=', $currentTime)
                        ->where('start_time', '<=', $currentTime)
                        ->where('status', Config::get('constants.status.PUBLIC'))
                        ->select('title', 'price', 'type', 'code', 'min_spend', 'usage_limit', 'limit_per_customer')
                        ->get();


                }


                if (!$data->image) {
                    $data->image = Config::get('constants.media.DEFAULT_IMAGE');
                }

                if (count($data->product_image_names) > 0) {
                    $data['images'] = $data->product_image_names;
                }

                $slug = [];

                array_push($slug, $data->category);

                if ($data->sub_category) {
                    $subCat = $data->sub_category;
                    $subCat['category'] = $data->category;

                    array_push($slug, $subCat);
                }
                $data['self_slug'] = $data['slug'];
                $data['slug'] = $slug;

                $data['time_zone'] = Carbon::now()->timezoneName;

                $data['in_stock'] = false;


                $data['attribute'] = $productInventoryAttr;

                if (count($data['inventory']) > 0) {
                    foreach ($data['inventory'] as $i) {
                        if ($i['quantity'] > 0) {
                            $data['in_stock'] = true;
                            break;
                        }
                    }
                }


                // $productData['is_favorite'] = auth('api')->check() && auth('api')->user()->wishLists()->where('product_id', $productData['id'])->exists();


                //return response()->json(new Response(null, $data));
                return new ProductDetailResource($data);

            });
            return response()->json(new Response(null, $productData));


        } catch (\Exception $e) {

            if ($e instanceof \PDOException) {
                return response()->json(Validation::error(null, explode('.', $e->getMessage())[0]));
            } else {
                return response()->json(Validation::error(null, $e->getMessage()));
            }
        }
    }


    public function contactUs(Request $request)
    {
        try {
            ContactUs::create($request->all());

            return response()->json(new Response('', true));

        } catch (\Exception $e) {

            if ($e instanceof \PDOException) {
                return response()->json(Validation::error(null, explode('.', $e->getMessage())[0]));
            } else {
                return response()->json(Validation::error(null, $e->getMessage()));
            }
        }
    }


    public function trackOrder(Request $request)
    {
        try {
            $lang = $request->header('language');

            $order = Order::with('ordered_products.shipping_place')
                ->with('ordered_products.product')
                ->where('order', $request->tracking_id)->get()->first();

            if (is_null($order)) {
                return response()->json(Validation::nothing_found(201, null, 'form', $lang));
            }

            return response()->json(new Response('', $order));

        } catch (\Exception $e) {

            if ($e instanceof \PDOException) {
                return response()->json(Validation::error(null, explode('.', $e->getMessage())[0]));
            } else {
                return response()->json(Validation::error(null, $e->getMessage()));
            }
        }
    }


    public function page(Request $request, $slug)
    {
        try {

            $lang = $request->header('language');

            $cacheKey = 'pages.' . $slug . $lang;
            if (!$lang) {
                $cacheKey = 'pages.' . $slug;
            }


            $page = Utils::cacheRemember($cacheKey, function () use ($slug, $lang) {


                if ($lang) {


                    $query = Page::query();
                    $query = $query->where('slug', $slug);
                    $query = $query->leftJoin('page_langs as cl', function ($join) use ($lang) {
                        $join->on('cl.page_id', '=', 'pages.id');
                        $join->where('cl.lang', $lang);
                    });
                    $query = $query->select('pages.*', 'cl.description', 'cl.title');

                    $page = $query->first();

                    if ($page->description == 'Sitemap') {
                        $query = Category::with(['public_sub_categories' => function ($query) use ($lang) {

                            $query = $query->leftJoin('sub_category_langs as scl', function ($join) use ($lang) {
                                $join->on('scl.sub_category_id', '=', 'sub_categories.id');
                                $join->where('scl.lang', $lang);
                            })
                                ->select('sub_categories.id', 'scl.title', 'sub_categories.slug',
                                    'sub_categories.category_id');

                            $query->with(['products' => function ($query) use ($lang) {

                                $query->leftJoin('product_langs as pl', function ($join) use ($lang) {
                                    $join->on('pl.product_id', '=', 'products.id');
                                    $join->where('pl.lang', $lang);
                                });

                                $query->where('products.status', Config::get('constants.status.PUBLIC'))
                                    ->select('products.id', 'products.slug', 'products.subcategory_id', 'pl.title');

                            }])
                                ->where('sub_categories.status', Config::get('constants.status.PUBLIC'));
                        }]);


                        $query = $query->leftJoin('category_langs as cl', function ($join) use ($lang) {
                            $join->on('cl.category_id', '=', 'categories.id');
                            $join->where('cl.lang', $lang);
                        });
                        $page['categories'] = $query->where('categories.status', Config::get('constants.status.PUBLIC'))
                            ->select('categories.id', 'cl.title', 'categories.slug')
                            ->get();
                    }


                } else {


                    $page = Page::where('slug', $slug)
                        ->select('slug', 'title', 'description', 'meta_title', 'meta_description', 'page_from_component')
                        ->first();

                    if ($page->description == 'Sitemap') {
                        $page['categories'] = Category::with(['public_sub_categories' => function ($query) {
                            $query->with(['products' => function ($q) {
                                $q->where('status', Config::get('constants.status.PUBLIC'))
                                    ->select('id', 'subcategory_id', 'title');

                            }])
                                ->where('status', Config::get('constants.status.PUBLIC'))
                                ->select('id', 'category_id', 'title', 'slug');
                        }])
                            ->where('status', Config::get('constants.status.PUBLIC'))
                            ->select('id', 'title', 'slug')
                            ->get();
                    }

                }


                if (!is_null($page)) {


                    //return response()->json(new Response(null, $page));

                    return $page;
                }

                return [];


                //return response()->json(new Response(null, []));

            });

            return response()->json(new Response(null, $page));
        } catch (\Exception $e) {

            if ($e instanceof \PDOException) {
                return response()->json(Validation::error(null, explode('.', $e->getMessage())[0]));
            } else {
                return response()->json(Validation::error(null, $e->getMessage()));
            }
        }
    }


    public function flashSale(Request $request, $id = null)
    {
        try {

            $lang = $request->header('language');

            if (!is_null($id)) {
                $flashSaleQuery = FlashSale::query();

                if ($lang) {
                    $flashSaleQuery = $flashSaleQuery->leftJoin('flash_sale_langs as cl',
                        function ($join) use ($lang) {
                            $join->on('cl.flash_sale_id', '=', 'flash_sales.id');
                            $join->where('cl.lang', $lang);
                        });
                    $flashSaleQuery = $flashSaleQuery->select('flash_sales.*', 'cl.title');
                }


                $flashSale = $flashSaleQuery->where('flash_sales.id', $id)
                    ->where('flash_sales.status', Config::get('constants.status.PUBLIC'))
                    ->where('flash_sales.end_time', '>=', date('Y-m-d H:i:s'))
                    ->first();

                if (!is_null($flashSale)) {
                    $query = FlashSaleProduct::query();
                    $query = $query->where('flash_sale_id', $id);

                    if ($lang) {

                        $query = $query->join('products as p', function ($join) use ($lang) {
                            $join->on('p.id', '=', 'flash_sale_products.product_id');
                            $join->where('p.status', Config::get('constants.status.PUBLIC'));

                            $join->leftJoin('product_langs as avl',
                                function ($join) use ($lang) {
                                    $join->on('p.id', '=', 'avl.product_id');
                                    $join->where('avl.lang', $lang);
                                });

                        });

                        $query = $query->select('flash_sale_products.*', 'p.id', 'p.title',
                            'p.selling', 'p.offered', 'p.slug',
                            'p.image', 'p.review_count', 'p.rating', 'avl.title', 'avl.badge');


                    } else {
                        $query = $query->join('products as p', function ($join) {
                            $join->on('p.id', '=', 'flash_sale_products.product_id');
                            $join->where('p.status', Config::get('constants.status.PUBLIC'));
                        });

                        $query = $query->select('flash_sale_products.*', 'p.id', 'p.title',
                            'p.selling', 'p.offered', 'p.badge', 'p.slug',
                            'p.image', 'p.review_count', 'p.rating');
                    }


                    $data = $query->paginate(Config::get('constants.frontend.PAGINATION'));

                    return response()->json(new Response(null, $data));
                }

                return response()->json(Validation::frontendError());

            } else {

                $flashSaleQuery = FlashSale::query();
                if ($lang) {
                    $flashSaleQuery = $flashSaleQuery->leftJoin('flash_sale_langs as cl', function ($join) use ($lang) {
                        $join->on('cl.flash_sale_id', '=', 'flash_sales.id');
                        $join->where('cl.lang', $lang);
                    });
                    $flashSaleQuery = $flashSaleQuery->select('flash_sales.*', 'cl.title');

                    $flashSaleQuery = $flashSaleQuery->with(['public_products' =>
                        function ($flashSaleQuery) use ($lang) {

                            $flashSaleQuery->leftJoin('product_langs as avl',
                                function ($join) use ($lang) {
                                    $join->on('flash_sale_products.product_id', '=', 'avl.product_id');
                                    $join->where('avl.lang', $lang);
                                })
                                ->select('flash_sale_products.*', 'p.id',
                                    'p.selling', 'p.offered',
                                    'p.image', 'p.review_count', 'p.rating', 'avl.badge', 'avl.title');

                        }]);

                } else {
                    $flashSaleQuery = $flashSaleQuery->with('public_products');
                }


                $flashSales = $flashSaleQuery
                    ->where('flash_sales.status', Config::get('constants.status.PUBLIC'))
                    ->where('flash_sales.end_time', '>=', date('Y-m-d H:i:s'))
                    ->get();

                return response()->json(new Response(null, $flashSales));
            }

        } catch (\Exception $e) {

            if ($e instanceof \PDOException) {
                return response()->json(Validation::error(null, explode('.', $e->getMessage())[0]));
            } else {
                return response()->json(Validation::error(null, $e->getMessage()));
            }
        }
    }


    public function productSuggestion(Request $request, $id)
    {

        try {
            $lang = $request->header('language');

            $product = Product::select('subcategory_id', 'category_id')->find($id);
            $data['suggestion_1'] = [];
            $data['suggestion_2'] = [];

            if ($product) {

                $query = Product::query();
                $query = $query->where('products.status', Config::get('constants.status.PUBLIC'))
                    ->leftJoin('flash_sales', function ($join) {

                        $join->on('products.id', '=', 'flash_sale_products.product_id');

                        $join->leftJoin('flash_sale_products', function ($join) {
                            $join->on('flash_sales.id', '=', 'flash_sale_products.flash_sale_id');
                        });
                        $join->where('flash_sales.end_time', '>=', date('Y-m-d H:i:s'))
                            ->where('flash_sales.status', Config::get('constants.status.PUBLIC'));
                    });


                if ($lang) {

                    $query = $query->leftJoin('product_langs as pl', function ($join) use ($lang) {
                        $join->on('pl.product_id', '=', 'products.id');
                        $join->where('pl.lang', $lang);
                    });

                    $query = $query->select('products.id', 'pl.title', 'pl.badge',
                        'products.selling', 'products.offered', 'products.slug',
                        'products.image', 'products.review_count', 'products.rating', 'flash_sale_products.price',
                        'flash_sales.end_time');
                } else {
                    $query = $query->select('products.id', 'products.title', 'products.badge',
                        'products.selling', 'products.offered', 'products.slug',
                        'products.image', 'products.review_count', 'products.rating', 'flash_sale_products.price',
                        'flash_sales.end_time');
                }


                $query = $query->where('products.status', Config::get('constants.status.PUBLIC'));

                $query2 = clone $query;


                if ($product->subcategory_id) {

                    $tempQuery = clone $query;


                    $query = $query->where('products.id', '!=', $id);
                    $query = $query->where('products.subcategory_id', $product->subcategory_id);
                    $data['suggestion_1'] = $query->paginate(Config::get('constants.imageSlider.PAGINATION'));


                    $query2 = $query2->where('products.category_id', $product->category_id);
                    $query2 = $query2->where('products.subcategory_id', '!=', $product->subcategory_id);
                    $data['suggestion_2'] = $query2->paginate(Config::get('constants.imageSlider.PAGINATION'));

                    $count1 = Config::get('constants.imageSlider.PAGINATION') - count($data['suggestion_1']);
                    $count2 = Config::get('constants.imageSlider.PAGINATION') - count($data['suggestion_2']);

                    if ($request->page == 1 && ($count1 > 0 || $count2 > 0)) {
                        $tempQuery = $tempQuery->where('products.id', '!=', $id);
                        $tempQuery = $tempQuery->where('products.category_id', '!=', $product->category_id);
                        $productsOtherCategory = $tempQuery->limit($count1 + $count2)->get();

                        if ($count1 > 0) {
                            $spliced1 = array_slice($productsOtherCategory->toArray(), 0, $count1);
                            $updated1 = $data['suggestion_1']->toBase()->merge($spliced1);
                            $data['suggestion_1'] = $data['suggestion_1']->setCollection($updated1);
                        }

                        if ($count2 > 0) {
                            $spliced2 = array_slice($productsOtherCategory->toArray(), $count1 - 1, $count2);
                            $updated2 = $data['suggestion_2']->toBase()->merge($spliced2);
                            $data['suggestion_2'] = $data['suggestion_2']->setCollection($updated2);
                        }
                    }

                } else {
                    $query2 = $query2->where('products.category_id', $product->category_id);
                    $query2 = $query2->where('products.id', '!=', $id);
                    $data['suggestion_2'] = $query2->paginate(Config::get('constants.imageSlider.PAGINATION'));
                }
            }

            return response()->json(new Response(null, $data));

        } catch (\Exception $e) {

            if ($e instanceof \PDOException) {
                return response()->json(Validation::error(null, explode('.', $e->getMessage())[0]));
            } else {
                return response()->json(Validation::error(null, $e->getMessage()));
            }
        }


    }
}
