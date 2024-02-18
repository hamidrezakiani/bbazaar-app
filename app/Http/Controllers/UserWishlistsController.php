<?php

namespace App\Http\Controllers;

use App\Models\Helper\Response;
use App\Models\Helper\Utils;
use App\Models\Helper\Validation;
use App\Models\UserWishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class UserWishlistsController extends Controller
{
    public function wishlistAction(Request $request)
    {

        try {

            $lang = $request->header('language');


            $validate = Validation::user_wishlist($request);
            if ($validate)
                return response()->json($validate);

            $user = Auth::user();

            $userWishlist = UserWishlist::where('product_id', $request->product_id)->where('user_id', $user->id)->get()->first();
            //  $removedUserWishlist = UserWishlist::where('product_id', $request->product_id)->where('user_id', $user->id)->select('product_id')->get()->first();

            if (is_null($userWishlist)) {
                $request['user_id'] = $user->id;
                $userWishlist = UserWishlist::create($request->all());

                $message = __('lang.added', [], $lang);
            } else {
                
                UserWishlist::where('id', $userWishlist->id)->delete();

                $message = __('lang.removed', [], $lang);
                $userWishlist = $userWishlist;
            }

            return Validation::success($request,
                __('lang.wishlist_message', ['message' => $message], $lang)
                , $userWishlist);


        } catch (\Exception $ex) {
            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }
    }


    public function wishlists(Request $request)
    {
        try {

            $lang = $request->header('language');


            $user = Auth::user();

            $query = UserWishlist::query();



            if ($lang) {
                $query = $query->with(['product' => function ($query) use ($lang) {

                    $query->leftJoin('product_langs as pl', function ($join) use ($lang) {
                        $join->on('pl.product_id', '=', 'products.id');
                        $join->where('pl.lang', $lang);
                    })
                        ->select(['products.id', 'products.slug', 'pl.badge', 'pl.title',
                            'products.selling', 'products.offered',
                            'products.image', 'products.review_count', 'products.rating', 'flash_sale_products.price',
                            'flash_sales.end_time']);

                }]);
            } else {
                $query = $query->with(['product']);
            
            }
            
            


            $data = $query->where('user_id', $user->id)
                ->orderBy($request->order_by, $request->type)
                ->paginate(Config::get('constants.api.PAGINATION'));
                


            if ($request->time_zone) {
                foreach ($data as $item) {
                    $item['created'] = Utils::formatDate(Utils::convertTimeToUSERzone($item->created_at, $request->time_zone));
                    
                    $item['wishlisted'] = auth('api')->check() && auth('api')->user()->wishLists()->where('product_id', $item->product_id)->exists();
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
}
