<?php

namespace App\Http\Controllers;

use App\Models\FooterImageLink;
use App\Models\Helper\ControllerHelper;
use App\Models\Helper\FileHelper;
use App\Models\Helper\Response;
use App\Models\Helper\Utils;
use App\Models\Helper\Validation;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class PaymentsController extends ControllerHelper
{
    public function save(Request $request)
    {
        try{
            if($can = Utils::userCan($this->user, 'setting.edit')){
                return $can;
            }

            $validate = Validation::payment($request);
            if($validate){
                return response()->json($validate);
            }

            $request['created_at'] =  null;
            $request['updated_at'] =  null;

            $data = Payment::first();

            if(is_null($data)){
                $request['admin_id'] = $this->user->id;

                Payment::create($request->all());
            }else{
                Payment::where('id', $data->id)->update($request->all());
            }

            return response()->json(new Response($request->token, $request->all()));

        } catch (\Exception $ex) {
            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }
    }


    public function find(Request $request)
    {
        $payment = Payment::first();

        return response()->json(new Response($request->token, $payment));
    }
}
