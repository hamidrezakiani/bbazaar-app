<?php

namespace App\Http\Controllers;

use App\Models\Cancellation;
use App\Models\Cart;
use App\Models\GuestUser;
use App\Models\Helper\ControllerHelper;
use App\Models\Helper\FileHelper;
use App\Models\Helper\Response;
use App\Models\Helper\Utils;
use App\Models\Helper\Validation;
use App\Models\Order;
use App\Models\OrderedProduct;
use App\Models\RatingReview;
use App\Models\ReviewImage;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class GuestUsersController extends ControllerHelper
{
    public function all(Request $request)
    {
        try {

            if ($can = Utils::userCan($this->user, 'user.view')) {
                return $can;
            }

            if ($request->q) {
                $data = GuestUser::query()
                    ->orderBy($request->orderby, $request->type)
                    ->where('name', 'LIKE', "%{$request->q}%")
                    ->orWhere('email', 'LIKE', "%{$request->q}%")
                    ->paginate(Config::get('constants.api.PAGINATION'));
            } else {
                $data = GuestUser::orderBy($request->orderby, $request->type)
                    ->paginate(Config::get('constants.api.PAGINATION'));
            }

            foreach ($data as $item) {
                $item['created'] = Utils::formatDate($item->created_at);
            }
            return response()->json(new Response($request->token, $data));
        } catch (\Exception $ex) {
            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }
    }


    public function delete(Request $request, $id)
    {
        try {

            $lang = $request->header('language');
            if ($can = Utils::userCan($this->user, 'user.delete')) {
                return $can;
            }
            $user = GuestUser::find($id);

            if (is_null($user)) {
                return response()->json(Validation::noDataLang($lang));
            }

            Cart::where('user_token', $user->user_token)
                ->where('user_id', '!=', null)
                ->update([
                    'user_token' => null
                ]);


            Cart::where('user_token', $user->user_token)
                ->where('user_id', null)
                ->delete();


            // Ordered products delete
            $orderedProducts = OrderedProduct::leftJoin('orders', 'ordered_products.order_id', '=', 'orders.id')
                ->where('orders.user_token', $user->user_token)
                ->where('orders.user_id', null);

            $orderedProducts->delete();


            // Cancellation message  delete

            Cancellation::where('user_token', $user->user_token)
                ->where('user_id', '!=', null)
                ->update([
                    'user_token' => null
                ]);


            $cancellation = Cancellation::leftJoin('orders', 'cancellations.order_id', '=', 'orders.id')
                ->where('orders.user_token', $user->user_token)
                ->where('orders.user_id', null);

            $cancellation->delete();


            Order::where('user_token', $user->user_token)
                ->where('user_id', '!=', null)
                ->update([
                    'user_token' => null
                ]);

            Order::where('user_token', $user->user_token)
                ->where('user_id', null)
                ->delete();

            // Review delete
            $reviewImages = ReviewImage::leftJoin('rating_reviews', 'review_images.rating_review_id', '=', 'rating_reviews.id')
                ->where('rating_reviews.user_token', $user->user_token)
                ->where('rating_reviews.user_id', null);

            $rimages = $reviewImages->get();
            foreach ($rimages as $img) {
                FileHelper::deleteFile($img->image);
            }

            $reviewImages->delete();


            RatingReview::where('user_token', $user->user_token)
                ->where('user_id', '!=', null)
                ->update([
                    'user_token' => null
                ]);

            RatingReview::where('user_token', $user->user_token)
                ->where('user_id', null)
                ->delete();

            // Address delete

            UserAddress::where('user_token', $user->user_token)
                ->where('user_id', '!=', null)
                ->update([
                    'user_token' => null
                ]);

            UserAddress::where('user_token', $user->user_token)
                ->where('user_id', null)
                ->delete();

            if ($user->delete()) {
                return response()->json(new Response($request->token, $user));
            }

            return response()->json(Validation::error($request->token, null, 'form', $lang));

        } catch (\Exception $ex) {
            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }
    }
}
