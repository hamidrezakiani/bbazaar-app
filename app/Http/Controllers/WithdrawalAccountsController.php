<?php

namespace App\Http\Controllers;

use App\Models\Helper\ControllerHelper;
use App\Models\Helper\Response;
use App\Models\Helper\Utils;
use App\Models\Helper\Validation;
use App\Models\Withdrawal;
use App\Models\WithdrawalAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class WithdrawalAccountsController extends ControllerHelper
{
    public function all(Request $request)
    {
        try {
            if ($can = Utils::userCan($this->user, 'withdrawal_account.view')) {
                return $can;
            }

            $query = WithdrawalAccount::query()->orderBy($request->orderby, $request->type);

            if ($this->isVendor) {
                $query = $query->where('admin_id', $this->user->id);
            }

            if ($request->q) {
                $query = $query->where('title', 'LIKE', "%{$request->q}%")
                    ->orWhere('account_name', 'LIKE', "%{$request->q}%")
                    ->orWhere('account_number', 'LIKE', "%{$request->q}%")
                    ->orWhere('bank_name', 'LIKE', "%{$request->q}%")
                    ->orWhere('branch_name', 'LIKE', "%{$request->q}%");
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


    public function find(Request $request, $id)
    {
        try {
            $lang = $request->header('language');

            if ($can = Utils::userCan($this->user, 'withdrawal_account.view')) {
                return $can;
            }

            $withdrawalAccount = WithdrawalAccount::find($id);

            if (is_null($withdrawalAccount)) {
                return response()->json(Validation::noDataLang($lang));
            }

            if (!$this->isSuperAdmin && $isOwner = Utils::isDataOwner($this->user, $withdrawalAccount)) {
                return $isOwner;
            }

            return response()->json(new Response($request->token, $withdrawalAccount));
        } catch (\Exception $ex) {
            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }
    }

    public function action(Request $request, WithdrawalAccount $withdrawalAccount)
    {
        try {
            $lang = $request->header('language');
            $validate = Validation::withdrawalAccount($request);
            if ($validate) {
                return response()->json($validate);
            }

            if ($withdrawalAccount->id) {
                if ($can = Utils::userCan($this->user, 'withdrawal_account.edit')) {
                    return $can;
                }

                $existing = WithdrawalAccount::find($withdrawalAccount->id);
                if (!$this->isSuperAdmin && $isOwner = Utils::isDataOwner($this->user, $existing)) {
                    return $isOwner;
                }

                // Making sure there is only one default account
                if ((int)$existing->default == Config::get('constants.status.PRIVATE') &&
                    (int)$request->default == Config::get('constants.status.PUBLIC')
                ) {

                    WithdrawalAccount::where('default', Config::get('constants.status.PUBLIC'))
                        ->update(['default' => Config::get('constants.status.PRIVATE')]);

                } else if ((int)$existing->default == Config::get('constants.status.PUBLIC') &&
                    (int)$request->default == Config::get('constants.status.PRIVATE')) {

                    return response()->json(Validation::error($request->token,
                        __('lang.one_default', [], $lang)));
                }

                $filtered = array_filter($request->all(), function ($element) {
                    return '' !== trim($element);
                });

                $withdrawalAccount->update(array_filter($filtered));

            } else {
                if ($can = Utils::userCan($this->user, 'withdrawal_account.create')) {
                    return $can;
                }
                // Making sure there is only one default account
                if ((int)$request->default == Config::get('constants.status.PUBLIC')) {
                    WithdrawalAccount::where('default', Config::get('constants.status.PUBLIC'))
                        ->update(['default' => Config::get('constants.status.PRIVATE')]);
                }

                $request['admin_id'] = $request->user()->id;
                $withdrawalAccount = WithdrawalAccount::create($request->all());
            }

            return response()->json(new Response($request->token, $withdrawalAccount));
        } catch (\Exception $ex) {
            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }
    }


    public function delete(Request $request, $id)
    {
        try {
            $lang = $request->header('language');


            if ($can = Utils::userCan($this->user, 'withdrawal_account.delete')) {
                return $can;
            }

            $withdrawalAccount = WithdrawalAccount::find($id);

            if (!$this->isSuperAdmin && $isOwner = Utils::isDataOwner($this->user, $withdrawalAccount)) {
                return $isOwner;
            }

            if (is_null($withdrawalAccount)) {
                return response()->json(Validation::noDataLang($lang));
            }

            if (Withdrawal::where('withdrawal_account_id', $id)->get()->first()) {
                return response()->json(Validation::error($request->token,
                    __('lang.used_request', [], $lang)
                ));
            }


            if ($withdrawalAccount->delete()) {
                return response()->json(new Response($request->token, $withdrawalAccount));
            }

            return response()->json(Validation::errorTokenLang($request->token, $lang));
        } catch (\Exception $ex) {
            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }
    }
}
