<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductDetailResource;
use App\Models\Attribute;
use App\Models\Brand;
use App\Models\BundleDeal;
use App\Models\Cart;
use App\Models\Category;
use App\Models\CollectionWithProduct;
use App\Models\CompareList;
use App\Models\FlashSaleProduct;
use App\Models\Helper\ControllerHelper;
use App\Models\Helper\FileHelper;
use App\Models\Helper\Response;
use App\Models\Helper\Utils;
use App\Models\Helper\Validation;
use App\Models\Inventory;
use App\Models\InventoryAttribute;
use App\Models\Order;
use App\Models\OrderedProduct;
use App\Models\Product;
use App\Models\ProductCollection;
use App\Models\ProductImage;
use App\Models\ProductLang;
use App\Models\RatingReview;
use App\Models\ReviewImage;
use App\Models\ShippingRule;
use App\Models\SubCategory;
use App\Models\TaxRules;
use App\Models\UpdatedInventory;
use App\Models\UserWishlist;
use App\Models\WysiwygImage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class ProductsController extends ControllerHelper
{

    public function all(Request $request)
    {
        try {
            $lang = $request->header('language');


            if ($can = Utils::userCan($this->user, 'product.view')) {
                return $can;
            }

            $query = Product::query();


            $query = $query->orderBy('products.' . $request->orderby, $request->type);

            if ($this->isVendor) {
                $query = $query->where('admin_id', $this->user->id);
            }




            if ($lang) {
                $query = $query->leftJoin('product_langs as pl', function ($join) use ($lang) {
                    $join->on('pl.product_id', '=', 'products.id');
                    $join->where('pl.lang', $lang);
                });

                $query = $query->with(['category' => function ($query) use ($lang) {
                    $query->leftJoin('category_langs as cl',
                        function ($join) use ($lang) {
                            $join->on('categories.id', '=', 'cl.category_id');
                            $join->where('cl.lang', $lang);
                        })
                        ->select('categories.title', 'categories.id', 'categories.slug', 'cl.title');
                }]);


                $query = $query->with(['sub_category' => function ($query) use ($lang) {
                    $query->leftJoin('sub_category_langs as scl',
                        function ($join) use ($lang) {
                            $join->on('sub_categories.id', '=', 'scl.sub_category_id');
                            $join->where('scl.lang', $lang);
                        })
                        ->select('sub_categories.title', 'sub_categories.id',
                            'sub_categories.category_id', 'sub_categories.slug', 'scl.title');
                }]);


                $query = $query->with(['brand' => function ($query) use ($lang) {
                    $query->leftJoin('brand_langs as bl',
                        function ($join) use ($lang) {
                            $join->on('brands.id', '=', 'bl.brand_id');
                            $join->where('bl.lang', $lang);
                        })
                        ->select('brands.title', 'brands.id', 'bl.title');
                }]);


                $query = $query->with(['tax_rules' => function ($query) use ($lang) {
                    $query->leftJoin('tax_rule_langs as trl',
                        function ($join) use ($lang) {
                            $join->on('tax_rules.id', '=', 'trl.tax_rule_id');
                            $join->where('trl.lang', $lang);
                        })
                        ->select('tax_rules.title', 'tax_rules.id', 'trl.*');
                }]);

                $query = $query->select('products.id', 'products.title', 'products.image',
                    'products.unit', 'products.category_id',
                    'products.subcategory_id', 'products.tax_rule_id', 'products.shipping_rule_id',
                    'products.brand_id', 'products.purchased',
                    'products.selling', 'products.offered', 'products.status',
                    'products.created_at', 'pl.title', 'pl.description',
                    'pl.overview', 'pl.unit', 'pl.badge',
                    'pl.meta_title', 'pl.meta_description');


                if ($request->q) {
                    $query = $query->where('pl.title', 'LIKE', "%{$request->q}%");
                }

            } else {

                $query = $query->with('sub_category')
                    ->with('brand')
                    ->with('category')
                    ->with('tax_rules');

                $query = $query->select('products.id', 'products.title', 'products.image',
                    'products.unit', 'products.category_id',
                    'products.subcategory_id', 'products.tax_rule_id', 'products.shipping_rule_id',
                    'products.brand_id', 'products.purchased',
                    'products.selling', 'products.offered', 'products.status',
                    'products.created_at');


                if ($request->q) {
                    $query = $query->where('products.title', 'LIKE', "%{$request->q}%");
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

    public function dropDownData(Request $request)
    {

        try {
            $lang = $request->header('language');

            if ($lang) {
                $res['sub_categories'] = SubCategory::leftJoin('sub_category_langs as scl',
                    function ($join) use ($lang) {
                        $join->on('sub_categories.id', '=', 'scl.sub_category_id');
                        $join->where('scl.lang', $lang);
                    })->select('sub_categories.title', 'sub_categories.id',
                    'sub_categories.category_id', 'sub_categories.slug', 'scl.title')
                    ->orderBy('sub_categories.created_at', 'ASC')->get();

                $res['brands'] = Brand::leftJoin('brand_langs as bl',
                    function ($join) use ($lang) {
                        $join->on('brands.id', '=', 'bl.brand_id');
                        $join->where('bl.lang', $lang);
                    })->select('brands.title', 'brands.id', 'bl.title')
                    ->orderBy('brands.created_at', 'ASC')->get();

                $res['categories'] = Category::leftJoin('category_langs as cl',
                    function ($join) use ($lang) {
                        $join->on('categories.id', '=', 'cl.category_id');
                        $join->where('cl.lang', $lang);
                    })->select('categories.title', 'categories.id', 'cl.title')
                    ->orderBy('categories.created_at', 'ASC')->get();

                $res['tax_rules'] = TaxRules::leftJoin('tax_rule_langs as trl',
                    function ($join) use ($lang) {
                        $join->on('tax_rules.id', '=', 'trl.tax_rule_id');
                        $join->where('trl.lang', $lang);
                    })->select('tax_rules.title', 'tax_rules.id', 'trl.title')
                    ->orderBy('tax_rules.created_at', 'ASC')->get();

                $res['shipping_rules'] = ShippingRule::leftJoin('shipping_rule_langs as srl',
                    function ($join) use ($lang) {
                        $join->on('shipping_rules.id', '=', 'srl.shipping_rule_id')->where('srl.lang', $lang);
                    })->select('shipping_rules.title', 'shipping_rules.id', 'srl.title')
                    ->orderBy('shipping_rules.created_at', 'ASC')->get();

                $res['product_collections'] = ProductCollection::leftJoin('product_collection_langs as pcl',
                    function ($join) use ($lang) {
                        $join->on('product_collections.id', '=', 'pcl.product_collection_id')
                            ->where('pcl.lang', $lang);
                    })->select('product_collections.title', 'product_collections.id', 'pcl.title')
                    ->orderBy('product_collections.created_at', 'ASC')->get();

                $res['bundle_deals'] = BundleDeal::leftJoin('bundle_deal_langs as bdl',
                    function ($join) use ($lang) {
                        $join->on('bundle_deals.id', '=', 'bdl.bundle_deal_id')
                            ->where('bdl.lang', $lang);
                    })->select('bundle_deals.title', 'bundle_deals.id', 'bdl.title')
                    ->orderBy('bundle_deals.created_at', 'ASC')->get();


                $res['attributes'] = Attribute::with(['values' => function ($query) use ($lang) {
                    $query->leftJoin('attribute_value_langs as avl',
                        function ($join) use ($lang) {
                            $join->on('attribute_values.id', '=', 'avl.attribute_value_id');
                            $join->where('avl.lang', $lang);
                        })
                        ->select('attribute_values.*', 'avl.title');
                }])->leftJoin('attribute_langs as al',
                    function ($join) use ($lang) {
                        $join->on('attributes.id', '=', 'al.attribute_id')
                            ->where('al.lang', $lang);
                    })->select('attributes.title', 'attributes.id', 'al.title')
                    ->orderBy('attributes.created_at', 'ASC')->get();

            } else {
                $res['sub_categories'] = SubCategory::orderBy('created_at', 'ASC')
                    ->get(['id', 'title', 'category_id']);
                $res['brands'] = Brand::orderBy('created_at', 'ASC')->get(['id', 'title']);
                $res['categories'] = Category::orderBy('created_at', 'ASC')->get(['id', 'title']);
                $res['tax_rules'] = TaxRules::orderBy('created_at', 'ASC')->get(['id', 'title']);
                $res['shipping_rules'] = ShippingRule::orderBy('created_at', 'ASC')->get(['id', 'title']);
                $res['product_collections'] = ProductCollection::orderBy('created_at', 'ASC')->get(['id', 'title']);
                $res['bundle_deals'] = BundleDeal::orderBy('created_at', 'ASC')->get(['id', 'title']);
                $res['attributes'] = Attribute::with('values')
                    ->orderBy('created_at', 'ASC')->get(['id', 'title']);
            }


            return response()->json(new Response($request->token, $res));


        } catch (\Exception $ex) {
            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }

    }


    public function find(Request $request, $id)
    {
        try {
            $lang = $request->header('language');

            if ($can = Utils::userCan($this->user, 'product.view')) {
                return $can;
            }

            $query = Product::query();
            $query = $query->with('product_images');
            $query = $query->with('flash_sale_product.flash_sale');
            $query = $query->with('product_collections');

            if ($lang) {
                $query = $query->leftJoin('product_langs as pl', function ($join) use ($lang) {
                    $join->on('pl.product_id', '=', 'products.id');
                    $join->where('pl.lang', $lang);
                });
                $query = $query->select('products.*', 'pl.title', 'pl.description',
                    'pl.overview', 'pl.unit', 'pl.badge',
                    'pl.meta_title', 'pl.meta_description');
            }

            $data = $query->find($id);

            if (!$this->isSuperAdmin && $isOwner = Utils::isDataOwner($this->user, $data)) {
                return $isOwner;
            }

            if (is_null($data)) {
                return response()->json(Validation::noDataLang($lang));
            }

            return response()->json(new Response($request->token, $data));
//            return response()->json(new ProductDetailResource($data));


        } catch (\Exception $ex) {
            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }
    }




    public function action(Request $request, $id = null)
    {
        try {

            $lang = $request->header('language');

            $validate = Validation::productMain($request);
            if ($validate) {
                return response()->json($validate);
            }


            $bySlug = Product::where('slug', $request['slug'])->first();

            if ($id) {
                if ($can = Utils::userCan($this->user, 'product.edit')) {
                    return $can;
                }

                $existing = Product::find($id);
                if (!$this->isSuperAdmin && $isOwner = Utils::isDataOwner($this->user, $existing)) {
                    return $isOwner;
                }

                if ($bySlug && $bySlug['id'] != $id) {
                    return response()->json(Validation::error($request->token,
                        __('lang.slug_exists', [], $lang)));
                }


                $filtered = array_filter($request->all(), function ($element) {
                    return !is_array($element);
                });




                if ($lang) {
                    [$langData, $mainData] = Utils::seperateLangData($filtered, [
                        'description', 'title', 'overview', 'unit', 'badge', 'meta_title', 'meta_description'
                    ]);
                    Product::where('id', $id)->update($mainData);
                    $existingLang = ProductLang::where('product_id', $id)
                        ->where('lang', $lang)->first();

                    if (!$existingLang) {
                        $langData['product_id'] = $id;
                        $langData['lang'] = $lang;
                        ProductLang::create($langData);

                    } else {

                        ProductLang::where('id', $existingLang->id)->update($langData);
                    }
                } else {
                    Product::where('id', $id)->update($filtered);
                }


            } else {
                if ($can = Utils::userCan($this->user, 'product.create')) {
                    return $can;
                }

                if ($bySlug) {
                    return response()->json(Validation::error($request->token,
                        __('lang.slug_exists', [], $lang)));
                }

                $request['image'] = Config::get('constants.media.DEFAULT_IMAGE');
                $request['admin_id'] = $request->user()->id;
                $request['id'] = Utils::idGenerator(new Product);


                if ($lang) {
                    [$langData, $mainData] = Utils::seperateLangData($request->all(), [
                        'description', 'title', 'overview', 'unit', 'badge', 'meta_title', 'meta_description'
                    ]);
                    $product = Product::create($mainData);

                    $langData['product_id'] = $product->id;
                    $langData['lang'] = $lang;
                    ProductLang::create($langData);
                    $id = $product->id;

                } else {
                    $product = Product::create($request->all());
                    $id = $product->id;
                }


            }

            //Product collection

            if (!is_null($request['product_collections'])) {


                CollectionWithProduct::where('product_id', $id)->delete();
                $productCollectionIds = $request['product_collections'];
                $now = Carbon::now();
                $productCollections = [];
                foreach ($productCollectionIds as $i) {
                    array_push($productCollections,
                        [
                            'product_collection_id' => $i,
                            'product_id' => $id,
                            'updated_at' => $now,
                            'created_at' => $now
                        ]
                    );
                }

                CollectionWithProduct::insert($productCollections);

            }

            $product = Product::with('product_images')
                ->with('product_collections')
                ->find($id);



            return response()->json(new Response($request->token, $product));

        } catch (\Exception $ex) {
            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }
    }


    public function delete(Request $request, $id)
    {
        try {

            $lang = $request->header('language');
            if ($can = Utils::userCan($this->user, 'product.delete')) {
                return $can;
            }
            $product = Product::find($id);

            if (!$this->isSuperAdmin && $isOwner = Utils::isDataOwner($this->user, $product)) {
                return $isOwner;
            }

            if (is_null($product)) {
                return response()->json(Validation::noDataLang($lang));
            }

            FlashSaleProduct::where('product_id', $id)->delete();


/*
            $orderedProduct = OrderedProduct::where('product_id', $id)->first();



            if ($orderedProduct) {
                return response()->json(Validation::error($request->token,
                    'Unable to delete. Product is being used in the order. Delete the order first.'));
            }*/


           OrderedProduct::where('product_id', $id)->delete();



            //Product collection
            CollectionWithProduct::where('product_id', $id)->delete();

            $product_inventories = UpdatedInventory::where('product_id', $id)->get();






            foreach ($product_inventories as $inv) {
                InventoryAttribute::where('inventory_id', $inv->id)->delete();
            }


            Cart::where('product_id', $id)->delete();
            CompareList::where('product_id', $id)->delete();



            UpdatedInventory::where('product_id', $id)->delete();




            $description_images = WysiwygImage::where('item_id', $id)->get();
            foreach ($description_images as $di) {
                $di->delete();
                FileHelper::deleteFile($di->image);
            }

            $product_images = ProductImage::where(['product_id' => $id])->get();

            foreach ($product_images as $img) {
                $img->delete();
                FileHelper::deleteFile($img->image);
            }

            UserWishlist::where('product_id', $id)->delete();


            //Review delete
            $reviewImages = ReviewImage::leftJoin('rating_reviews', 'review_images.rating_review_id', '=', 'rating_reviews.id')
                ->where('rating_reviews.product_id', $id);

            $rimages = $reviewImages->get();
            foreach ($rimages as $img) {
                FileHelper::deleteFile($img->image);
            }

            $reviewImages->delete();

            RatingReview::where('product_id', $id)->delete();

            ProductLang::where('product_id', $id)->delete();

            if ($product->delete()) {
                FileHelper::deleteFile($product->image);
                FileHelper::deleteFile($product->video);
                FileHelper::deleteFile($product->video_thumb);

                return response()->json(new Response($request->token, $product));
            }
            return response()->json(Validation::errorTokenLang($request->token, $lang));
        } catch (\Exception $ex) {
            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }
    }


    public function allImages(Request $request, $productId)
    {
        $data = ProductImage::orderBy('created_at', 'ASC')->where(['product_id' => $productId])->get();
        return response()->json(new Response($request->token, $data));
    }


    public function deleteProductImage(Request $request, $productImageId)
    {

        $lang = $request->header('language');

        if ($can = Utils::userCan($this->user, 'product.edit')) {
            return $can;
        }

        $product_image = ProductImage::find($productImageId);

        if (!$this->isSuperAdmin && $isOwner = Utils::isDataOwner($this->user, $product_image)) {
            return $isOwner;
        }

        if (is_null($product_image)) {
            return response()->json(Validation::nothingFoundLang($lang));
        }

        if ($product_image->delete()) {
            if (config('env.media.STORAGE') != config('env.media.URL')) {
                FileHelper::deleteFile($product_image->image);
            }

            $images = ProductImage::where('product_id', $product_image->product_id)->get();
            return response()->json(new Response($request->token, $images));
        }
        return response()->json($request->token, Validation::error());
    }


    public function multipleImageUpload(Request $request, $productId)
    {
        try {
            $lang = $request->header('language');


            if ($can = Utils::userCan($this->user, 'product.edit')) {
                return $can;
            }

            $product = Product::find($productId);

            if (is_null($product)) {
                return response()->json(Validation::noData(201, null, 'multiple_image'));
            }

            if (!$this->isSuperAdmin && $isOwner = Utils::isDataOwner($this->user, $product)) {
                return $isOwner;
            }

            // Checking if the image resource is URL
            if (config('env.media.STORAGE') == config('env.media.URL')) {
                $validate = Validation::image($request, 'multiple_image');
                if ($validate) {
                    return response()->json($validate);
                }

                $image_info = FileHelper::uploadImage($request['photo'], 'product');

                $product_image['image'] = $image_info['name'];
                $product_image['admin_id'] = $request->user()->id;
                $product_image['product_id'] = $productId;

                ProductImage::create($product_image);
                $images = ProductImage::where('product_id', $productId)->get();

                return response()->json(new Response($request->token, $images));
            }


            if ($request->hasFile('images')) {
                $images_arr = [];

                foreach ($request->images as $img) {

                    $validate = Validation::multipleImages(['photo' => $img], $request->token);
                    if ($validate) {
                        return response()->json($validate);
                    }

                    $image_info = FileHelper::uploadImage($img, 'product');

                    $product_image['image'] = $image_info['name'];
                    $product_image['admin_id'] = $request->user()->id;
                    $product_image['product_id'] = $productId;

                    array_push($images_arr, $product_image);
                }

                ProductImage::insert($images_arr);
                $images = ProductImage::where('product_id', $productId)->get();

                return response()->json(new Response($request->token, $images));
            }

            return response()->json(Validation::error($request->token,
                __('lang.invalid_parameter', [], $lang),
                'multiple_image'));
            // return response()->json(Validation::invalid_parameter($request->token));

        } catch (\Exception $ex) {
            return response()->json(Validation::error($request->token, $ex->getMessage(), 'multiple_image'));
        }
    }

    public function uploadVideo(Request $request, $id = null)
    {

        try {
            $lang = $request->header('language');


            $validate = Validation::video($request);
            if ($validate) {
                return response()->json($validate);
            }

            $image_info = FileHelper::uploadImage($request['video_file'], 'product-video', false);
            $thumb_info = FileHelper::uploadImage($request['thumb'], 'product-video-thumb', false);
            $request['video'] = null;


            $product = $id ? Product::with('product_images')
                    ->with('flash_sale_product.flash_sale')
                    ->with('product_collections')
                    ->find($id) : null;

            if (is_null($product)) {

                if ($can = Utils::userCan($this->user, 'product.create')) {
                    return $can;
                }

                $request['admin_id'] = $request->user()->id;
                $request['id'] = Utils::idGenerator(new Product);
                $request['video'] = $image_info['name'];
                $request['video_thumb'] = $thumb_info['name'];

                $product = Product::create($request->all());

                $id=$product->id;

            } else {

                if ($can = Utils::userCan($this->user, 'product.edit')) {
                    return $can;
                }

                if (!$this->isSuperAdmin && $isOwner = Utils::isDataOwner($this->user, $product)) {
                    return $isOwner;
                }

                $video = $product->video;
                $thumb = $product->video_thumb;
                if ($product->update([
                    'video' => $image_info['name'],
                    'video_thumb' => $thumb_info['name']
                ])) {
                    FileHelper::deleteFile($video);
                    FileHelper::deleteFile($thumb);
                }
            }


            $query = Product::query();
            $query = $query->with('product_images');
            $query = $query->with('flash_sale_product.flash_sale');
            $query = $query->with('product_collections');

            if ($lang) {
                $query = $query->leftJoin('product_langs as pl', function ($join) use ($lang) {
                    $join->on('pl.product_id', '=', 'products.id');
                    $join->where('pl.lang', $lang);
                });
                $query = $query->select('products.*', 'pl.title', 'pl.description',
                    'pl.overview', 'pl.unit', 'pl.badge',
                    'pl.meta_title', 'pl.meta_description');
            }

            $data = $query->find($id);

            return response()->json(new Response($request->token, $data));

        } catch (\Exception $ex) {
            dd($ex->getMessage());
            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }
    }


    public function upload(Request $request, $id = null)
    {
        try {
            $lang = $request->header('language');


            $validate = Validation::image($request);
            if ($validate)
                return response()->json($validate);

            $image_info = FileHelper::uploadImage($request['photo'], 'product');
            $request['image'] = $image_info['name'];



            $product = $id ? Product::with('product_images')
                ->with('flash_sale_product.flash_sale')
                ->with('product_collections')
                ->find($id) : null;

            if (is_null($product)) {

                if ($can = Utils::userCan($this->user, 'product.create')) {
                    return $can;
                }

                $request['admin_id'] = $request->user()->id;
                $request['id'] = Utils::idGenerator(new Product);
                $product = Product::create($request->all());
                $id = $product->id;

            } else {

                if ($can = Utils::userCan($this->user, 'product.edit')) {
                    return $can;
                }

                if (!$this->isSuperAdmin && $isOwner = Utils::isDataOwner($this->user, $product)) {
                    return $isOwner;
                }

                $image = $product->image;
                if ($product->update($request->all())) {
                    FileHelper::deleteFile($image);
                }
            }


            $query = Product::query();
            $query = $query->with('product_images');
            $query = $query->with('flash_sale_product.flash_sale');
            $query = $query->with('product_collections');

            if ($lang) {
                $query = $query->leftJoin('product_langs as pl', function ($join) use ($lang) {
                    $join->on('pl.product_id', '=', 'products.id');
                    $join->where('pl.lang', $lang);
                });
                $query = $query->select('products.*', 'pl.title', 'pl.description',
                    'pl.overview', 'pl.unit', 'pl.badge',
                    'pl.meta_title', 'pl.meta_description');
            }

            $data = $query->find($id);


            return response()->json(new Response($request->token, $data));

        } catch (\Exception $ex) {
            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }
    }
}
