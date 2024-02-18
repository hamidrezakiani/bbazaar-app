<?php

namespace App\Http\Controllers;

use App\Models\CompareList;
use App\Models\Helper\ControllerHelper;
use App\Models\Helper\Response;

use App\Models\Helper\Utils;
use App\Models\Helper\Validation;
use App\Models\UserFollowStore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class UserFollowStoreController extends ControllerHelper
{

    public function all(Request $request)
    {
        try {
            $user = Auth::user();

            $data = UserFollowStore::with('store')
                ->where('user_id', $user->id)
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

    public function action(Request $request)
    {
        try {
            $validate = Validation::userFollowStore($request);
            if ($validate) {
                return response()->json($validate);
            }

            $user = Auth::user();

            $followed = UserFollowStore::where('user_id', $user->id)
                ->where('store_id', $request->store_id)
                ->first();

            if (!$followed) {
                UserFollowStore::create([
                    'user_id' => $user->id,
                    'store_id' => $request->store_id,
                ]);
            } else {

                UserFollowStore::where('user_id', $user->id)
                    ->where('store_id', $request->store_id)->delete();
            }

            return response()->json(new Response($request->token, true));

        } catch (\Exception $ex) {
            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }
    }
}
