<?php

namespace App\Http\Controllers;

use App\Models\CompareList;
use App\Models\Helper\Response;
use App\Models\Helper\Utils;
use App\Models\Helper\Validation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class CompareListsController extends Controller
{
    public function action(Request $request)
    {
        try {

            $lang = $request->header('language');

            $validate = Validation::user_wishlist($request);
            if ($validate){
                return response()->json($validate);
            }

            $user = Auth::user();

            $list = CompareList::where('product_id', $request->product_id)
                ->where('user_id', $user->id)
                ->get()
                ->first();

            if (is_null($list)) {
                $request['user_id'] = $user->id;
                $list = CompareList::create($request->all());
                return Validation::success($request,
                    __('lang.compare_success', [], $lang),
                    $list);
            } else {
                CompareList::where('id', $list->id)->delete();
                return Validation::success($request,
                    __('lang.compare_removed', [], $lang),
                    null);
            }

        } catch (\Exception $ex) {
            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }
    }


    public function all(Request $request)
    {

        try {
            $lang = $request->header('language');

            $user = Auth::user();

            $query = CompareList::query();

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
