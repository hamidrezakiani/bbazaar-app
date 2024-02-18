<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserVoucherCollection;
use App\Models\Cancellation;
use App\Models\Cart;
use App\Models\CompareList;
use App\Models\GuestUser;
use App\Models\Helper\ControllerHelper;
use App\Models\Helper\FileHelper;
use App\Models\Helper\MailHelper;
use App\Models\Helper\Response;
use App\Models\Helper\Utils;
use App\Models\Order;
use App\Models\OrderedProduct;
use App\Models\RatingReview;
use App\Models\ReviewImage;
use App\Models\User;
use App\Models\Helper\Validation;
use App\Models\UserAddress;
use App\Models\UserWishlist;
use App\Models\Voucher;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\Passport;
use Laravel\Socialite\Facades\Socialite;

class UsersController extends ControllerHelper
{
    public function redirectToProvider($service)
    {
        try {

            return Socialite::driver($service)->redirect();

        } catch (\Exception $ex) {
            return response()->json(Validation::error(null, $ex->getMessage()));
        }
    }

    public function handleProviderCallback($service)
    {
        try {
            $user = Socialite::driver($service)->stateless()->user();
            $socialVariable = $service . '_id';

            $existingUser = User::where($socialVariable, $user->id)
                ->orWhere('email', $user->email)
                ->first();

            if ($existingUser) {

                Auth::login($existingUser);

            } else {

                $newUser = [
                    'name' => $user->name,
                    'email' => $user->email,
                    $socialVariable => $user->id,
                    'password' => encrypt(rand(1000, 9999)),
                    'verified' => 1
                ];
                $newUser = User::create($newUser);
                Auth::login($newUser);
            }

            $authUser = Auth::user();
            $token = $authUser->createToken('user', ['user'])->accessToken;
            $id = $authUser->id;
            $name = $authUser->name;
            $email = $authUser->email;

            return redirect(env('FRONTEND_SOCIAL_REDIRECT', Utils::frontendSocialRedirect()) . '?token=' . $token . '&&user=' . $id . '&&email=' . $email . '&&name=' . $name);
        } catch (\Exception $ex) {
            return redirect(env('FRONTEND_SOCIAL_REDIRECT', Utils::frontendSocialRedirect()) . '?error=' . explode('response', $ex->getMessage())[0]);
        }
    }


    public function all(Request $request)
    {
        try {

            if ($can = Utils::userCan($this->user, 'user.view')) {
                return $can;
            }

            if ($request->q) {
                $data = User::query()
                    ->orderBy($request->orderby, $request->type)
                    ->where('email', 'LIKE', "%{$request->q}%")
                    ->orWhere('name', 'LIKE', "%{$request->q}%")
                    ->paginate(Config::get('constants.api.PAGINATION'));
            } else {
                $data = User::orderBy($request->orderby, $request->type)
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
            $user = User::find($id);

            if (is_null($user)) {
                return response()->json(Validation::noDataLang($lang));
            }

            Cart::where('user_id', $id)->delete();

            UserWishlist::where('user_id', $id)->delete();

            CompareList::where('user_id', $id)->delete();

            // Ordered products delete
            $orderedProducts = OrderedProduct::leftJoin('orders', 'ordered_products.order_id', '=', 'orders.id')
                ->where('orders.user_id', $id);

            $orderedProducts->delete();

            // Cancellation message  delete
            $cancellation = Cancellation::leftJoin('orders', 'cancellations.order_id', '=', 'orders.id')
                ->where('orders.user_id', $id);

            $cancellation->delete();

            Order::where('user_id', $id)->delete();

            // Review delete
            $reviewImages = ReviewImage::leftJoin('rating_reviews', 'review_images.rating_review_id', '=', 'rating_reviews.id')
                ->where('rating_reviews.user_id', $id);

            $rimages = $reviewImages->get();
            foreach ($rimages as $img) {
                FileHelper::deleteFile($img->image);
            }

            $reviewImages->delete();

            RatingReview::where('user_id', $id)->delete();


            // Address delete
            UserAddress::where('user_id', $id)->delete();

            if ($user->delete()) {
                return response()->json(new Response($request->token, $user));
            }

            return response()->json(Validation::error($request->token, null, 'form', $lang));

        } catch (\Exception $ex) {
            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }
    }


    public function login(Request $request)
    {
        try {
            $lang = $request->header('language');


            $validator = Validation::admin_login($request);
            if ($validator)
                return response()->json($validator);

            if ($request->input('token')) {
                $this->auth->setToken($request->input('token'));

                $user = $this->auth->authenticate();
                if ($user) {
                    return response()->json(new Response($request->input('token'), $request->user()));
                }
            }

            $user = User::where('email', request('email'))->first();

            $password_check = Validation::password_check($user, request('password'));
            if ($password_check) {
                return response()->json($password_check);
            }

            Auth::login($user);

            if (!$user->verified) {
                return response()->json(Validation::error(null,
                    __('lang.not_verified', [], $lang)
                ));
            }

            $data['expires_in'] = Carbon::now()
                ->addDays(Config::get('constants.auth.EXPIRATION_IN_DAYS'));


            if (request('remember_token')) {
                $data['expires_in'] = Carbon::now()->addMonth(12);
            } else {
                $data['expires_in'] = Carbon::now()->addMonth(2);
            }

            Passport::personalAccessTokensExpireIn($data['expires_in']);

            $data['token'] = Auth::user()->createToken('user', ['user'])->accessToken;

            $userArr['id'] = $user->id;
            $userArr['name'] = $user->name;
            $userArr['email'] = $user->email;


            if ($request->user_token) {

                GuestUser::where('user_token', $request->user_token)->update([
                    'name' => $user->name,
                    'email' => $user->email
                ]);

                Cart::where('user_id', null)
                    ->where('user_token', $request->user_token)
                    ->update([
                        'user_id' => $user->id
                    ]);

                Order::where('user_id', null)
                    ->where('user_token', $request->user_token)
                    ->update([
                        'user_id' => $user->id
                    ]);

                UserAddress::where('user_id', null)
                    ->where('user_token', $request->user_token)
                    ->update([
                        'user_id' => $user->id
                    ]);

                Cancellation::where('user_id', null)
                    ->where('user_token', $request->user_token)
                    ->update([
                        'user_id' => $user->id
                    ]);
            }


            $userArr['cart_count'] = intval(Cart::where('user_id', $user->id)->sum('quantity'));

            $data['user'] = $userArr;

            return response()->json(new Response($request->token, $data));


        } catch (\Exception $ex) {
            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }

    }

    public function updatePassword(Request $request)
    {
        try {
            $lang = $request->header('language');


            $validator = Validation::update_password($request);
            if ($validator) {
                return response()->json($validator);
            }

            $existingUser = User::where('email', $request->email)
                ->first();

            if (!$existingUser) {
                return response()->json(Validation::error(null,
                    __('lang.no_email', [], $lang)
                ));
            }


            if ($existingUser->code != $request->code) {
                return response()->json(Validation::error(null,
                    __('lang.code_invalid', [], $lang)
                ));
            }

            User::where('email', $request->email)->update([
                'password' => Hash::make($request->password)
            ]);

            return response()->json(new Response($request->token, $request->email));
        } catch (\Exception $ex) {
            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }
    }

    public function forgotPassword(Request $request)
    {
        try {
            $lang = $request->header('language');


            $validator = Validation::email_verification($request);
            if ($validator) {
                return response()->json($validator);
            }

            $existingUser = User::where('email', request('email'))
                ->first();

            if ($existingUser) {

                if (!$existingUser->verified) {
                    return response()->json(Validation::error(null,
                        __('lang.not_verified', [], $lang)
                    ));
                }

                try {
                    $code = MailHelper::codeSender($request, 'forgot_password', null, $lang);

                    User::where('email', $existingUser->email)->update(array('code' => $code));

                    return response()->json(new Response(null, $existingUser->email));

                } catch (\Exception $ex) {
                    return response()->json(Validation::error(null, explode('.', $ex->getMessage())[0]));
                }


            } else {
                return response()->json(Validation::error(null,
                    __('lang.not_exists', [], $lang)
                ));
            }
        } catch (\Exception $ex) {
            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }
    }


    public function verify(Request $request)
    {
        try {
            $lang = $request->header('language');


            $validator = Validation::user_verification($request);
            if ($validator) {
                return response()->json($validator);
            }

            $existingUser = User::where('email', request('email'))
                ->first();

            if ($existingUser) {
                if ($existingUser->code == request('code')) {

                    User::where('email', $existingUser->email)->update(array('verified' => true));

                    return response()->json(new Response($request->token, $existingUser));

                } else {
                    return response()->json(Validation::error(null,
                        __('lang.code_invalid', [], $lang)
                    ));
                }

            } else {
                return response()->json(Validation::error(null,
                    __('lang.not_exists', [], $lang)
                ));
            }
        } catch (\Exception $ex) {
            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }
    }


    public function signup(Request $request)
    {
        try {
            $lang = $request->header('language');


            $validator = Validation::user_signup($request);
            if ($validator) {
                return response()->json($validator);
            }

            $existingUser = User::where('email', request('email'))
                ->first();

            if ($existingUser && $existingUser->verified) {
                return response()->json(Validation::error(null,
                    __('lang.email_verified', [], $lang)
                ));
            }

            $request['password'] = Hash::make(request('password'));


            $request['code'] = MailHelper::codeSender($request, null,
                __('lang.account_registration', [], $lang),
                $lang
            );

            if (!$existingUser) {
                User::create($request->all());
            } else {
                User::where('email', $existingUser->email)->update([
                    'code' => $request['code'],
                    'password' => $request['password'],
                    'name' => $request['name']
                ]);
            }

            return response()->json(new Response(null, $request->email));

        } catch (\Exception $ex) {
            return response()->json(Validation::error(null, explode('.', $ex->getMessage())[0]));
        }
    }


    public function logout(Request $request)
    {
        try {
            $lang = $request->header('language');


            Auth::user()->tokens->each(function ($token, $key) {
                if ($token->name === "user") $token->delete();
            });
            return Validation::success($request,
                __('lang.logged_out', [], $lang)
            );
        } catch (\Exception $ex) {
            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }
    }


    public function updateProfile(Request $request)
    {
        try {
            $lang = $request->header('language');


            $validator = Validation::userProfile($request);
            if ($validator) {
                return response()->json($validator);
            }

            User::where('id', Auth::user()->id)->update([
                'name' => $request->name
            ]);

            return Validation::success($request, __('lang.profile_updated', [], $lang), ['name' => $request->name]);

        } catch (\Exception $ex) {
            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }
    }


    public function updateUserPassword(Request $request)
    {
        try {
            $lang = $request->header('language');

            $validator = Validation::updateUserPassword($request);
            if ($validator) {
                return response()->json($validator);
            }

            $user = User::where('id', Auth::user()->id)->first();

            $password_check = Validation::password_check($user, $request->current_password,
                __('lang.Password_matched', [], $lang)
            );
            if ($password_check) {
                return response()->json($password_check);
            }

            User::where('id', Auth::user()->id)->update([
                'password' => Hash::make($request->new_password)
            ]);

            return Validation::success($request,
                __('lang.password_updated', [], $lang)
            );
        } catch (\Exception $ex) {
            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }
    }


    public function profile(Request $request)
    {
        try {

            $lang = $request->header('language');


            if ($request->user('user')) {

                $user = $request->user('user');
                $user['cart_count'] = intval(Cart::where('user_id', $user->id)->sum('quantity'));
                $user['is_logged_in'] = true;
                unset($user['code']);


            } else if ($request->user_token) {


                $user = GuestUser::where('user_token', $request->user_token)->first();
                $user['cart_count'] = intval(Cart::where('user_token', $request->user_token)->sum('quantity'));
                $user['is_logged_in'] = false;

            } else {

                return response()->json(Validation::nothingFoundLang($lang, 201));

            }


            return response()->json(new Response($request->token, $user));

        } catch (\Exception $ex) {
            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }
    }


    public function addressAction(Request $request)
    {
        try {
            $lang = $request->header('language');

            $validate = Validation::user_address($request);
            if ($validate) {
                return response()->json($validate);
            }

            $userAddress = null;


            if ($request->user_token && !$request->user('user')) {

                $guestUser = GuestUser::where('user_token', $request->user_token)
                    ->first();


                if (!$guestUser) {

                    GuestUser::create([
                        'user_token' => $request->user_token,
                        'name' => $request->name,
                        'email' => $request->email
                    ]);

                } else {

                    GuestUser::where('id', $guestUser->id)
                        ->update([
                            'name' => $request->name,
                            'email' => $request->email
                        ]);

                }
            }





            if ($request->id) {

                $query = UserAddress::query();

                if ($request->user('user')) {

                    $query = $query->where('user_id', $request->user('user')->id);

                } else if ($request->user_token) {

                    $query = $query->where('user_token', $request->user_token);

                } else {
                    return response()->json(Validation::errorLang($lang));
                }


                $userAddress = $query->first();
            }

            $message = '';

            if (is_null($userAddress)) {

                if ($request->user('user')) {

                    $request['user_id'] = $request->user('user')->id;

                } else if ($request->user_token) {

                    $request['user_token'] = $request->user_token;

                } else {
                    return response()->json(Validation::errorLang($lang));
                }

                $userAddress = UserAddress::create($request->all());

                $message = __('lang.created', [], $lang);

            } else {

                $userAddress = $request->all();
                $request['created'] = null;
                $request['id'] = null;

                $filtered = array_filter($request->all(), function ($element) {
                    return !is_array($element) && '' !== trim($element);
                });

                UserAddress::where('id', $userAddress['id'])
                    ->update(array_filter($filtered));

                $message = __('lang.updated', [], $lang);
            }

            return Validation::success($request,
                __('lang.address_message', ['message' => $message], $lang), $userAddress);

        } catch (\Exception $ex) {

            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }
    }


    public function deleteAddress(Request $request, $id)
    {
        try {
            $lang = $request->header('language');

            $query = UserAddress::where('id', $id);

            if ($request->user('user')) {

                $query = $query->where('user_id', $request->user('user')->id);

            } else if ($request->user_token) {

                $query = $query->where('user_token', $request->user_token);

            } else {
                return response()->json(Validation::errorLang($lang));
            }

            $userAddress = $query->first();


            if (is_null($userAddress)) {
                return response()->json(Validation::nothingFoundLang($lang));
            }


            $order = Order::where('user_address_id', $id)->first();

            if ($order) {
                return response()->json(Validation::error($request->token,
                    __('lang.address_used', [], $lang)
                ));
            }


            if (UserAddress::where('id', $id)->delete()) {
                return Validation::success($request,
                    __('lang.address_message', ['message' => __('lang.deleted', [], $lang)], $lang),
                    $userAddress);
            }

            return response()->json(Validation::error($request->token, null, 'form', $lang));

        } catch (\Exception $ex) {
            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }
    }


    public function addresses(Request $request)
    {
        try {

            $lang = $request->header('language');

            $query = UserAddress::query();

            if ($request->q) {
                $query = $query->where('address_1', 'LIKE', "%{$request->q}%");
            }

            if ($request->user('user')) {

                $query = $query->where('user_id', $request->user('user')->id);
                $query = $query->with('user');


            } else if ($request->user_token) {

                $guestUser = GuestUser::where('user_token', $request->user_token)
                    ->first();

                if (!$guestUser) {
                    GuestUser::create([
                        'user_token' => $request->user_token,
                    ]);
                }


                $query = $query->where('user_token', $request->user_token);
                $query = $query->with('guest_user');

            } else {
                return response()->json(Validation::errorLang($lang));
            }


            if ($request->orderby && $request->type) {
                $query = $query->orderBy($request->orderby, $request->type);
            }

            $data = $query->paginate(Config::get('constants.frontend.PAGINATION'));


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


    public function vouchers(Request $request)
    {
        try {

            $lang = $request->header('language');

            $currentTime = Carbon::now()->format('Y-m-d H:i:s');


            $query = Voucher::query();
            $query = $query->where('end_time', '>=', $currentTime);
            $query = $query->where('start_time', '<=', $currentTime);
            $query = $query->orderBy($request->order_by, $request->type);
            $query = $query->where('status', Config::get('constants.status.PUBLIC'));


            if ($lang) {
                $query = $query->leftJoin('voucher_langs as pcl', function ($join) use ($lang) {
                    $join->on('pcl.voucher_id', '=', 'vouchers.id');
                    $join->where('pcl.lang', $lang);
                });
                $query = $query->select('vouchers.*', 'pcl.title');


                if ($request->q) {
                    $query = $query->where('pcl.title', 'LIKE', "%{$request->q}%");
                }

            } else {

                if ($request->q) {
                    $query = $query->where('title', 'LIKE', "%{$request->q}%");
                }

            }


            $data = $query->paginate(Config::get('constants.frontend.PAGINATION'));

            if ($request->time_zone) {
                foreach ($data as $item) {
                    $item['start_time'] = Utils::formatDate(Utils::convertTimeToUSERzone($item->start_time, $request->time_zone),
                        Config::get('constants.dateTime.ONLY_DATE'));
                    $item['end_time'] = Utils::formatDate(Utils::convertTimeToUSERzone($item->end_time, $request->time_zone),
                        Config::get('constants.dateTime.ONLY_DATE'));
                    $item['created'] = Utils::formatDate(Utils::convertTimeToUSERzone($item->created_at, $request->time_zone));
                }

            } else {
                foreach ($data as $item) {
                    $item['start_time'] = Utils::formatDate($item->start_time, Config::get('constants.dateTime.ONLY_DATE'));
                    $item['end_time'] = Utils::formatDate($item->end_time, Config::get('constants.dateTime.ONLY_DATE'));
                    $item['created'] = Utils::formatDate($item->created_at);
                }
            }
            $data = new UserVoucherCollection($data);
            return response()->json(new Response($request->token, $data));

        } catch (\Exception $ex) {
            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }
    }
}
