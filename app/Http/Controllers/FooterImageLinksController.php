<?php

namespace App\Http\Controllers;
use App\Models\Helper\FileHelper;
use App\Models\FooterImageLink;
use App\Models\Helper\Response;
use App\Models\Helper\Utils;
use App\Models\Helper\Validation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class FooterImageLinksController extends Controller
{
    public function all(Request $request)
    {
        $footer_image_links = FooterImageLink::orderBy('created_at', 'ASC')->get();

        $data['payment_links'] = [];
        $data['social_links'] = [];

        foreach ($footer_image_links as $i){

            if((int)$i->type == Config::get('constants.footerImageLinkType.PAYMENT'))
                array_push($data['payment_links'], $i);
            else
                array_push( $data['social_links'], $i);

            $i['created'] = Utils::formatDate($i->created_at);
        }

        return response()->json(new Response($request->token, $data));
    }

    public function find(Request $request, $id)
    {

        $lang = $request->header('language');

        $footerImageLink = FooterImageLink::find($id);
        if (is_null($footerImageLink)){
            return response()->json(Validation::noDataLang($lang));
        }

        return response()->json(new Response($request->token, $footerImageLink));
    }


    public function action(Request $request, FooterImageLink $footerImageLink)
    {
        $validate = Validation::footerImageLink($request);
        if($validate)
            return response()->json($validate);

        if($footerImageLink->id){
            $filtered = array_filter($request->all(), function ($element) {
                return '' !== trim($element);
            });

            $footerImageLink->update(array_filter($filtered));

        }else{

            $request['admin_id'] = $request->user()->id;
            $footerImageLink = FooterImageLink::create($request->all());
        }

        if($request->type === Config::get('constants.footerLinkType.PAYMENT'))
            $footerImageLink['payment_links'] = true;
        else
            $footerImageLink['social_links'] = true;

        $footerImageLink['created'] = Utils::formatDate($footerImageLink->created_at);

        return response()->json(new Response($request->token, $footerImageLink));
    }

    public function delete(Request $request, $id)
    {
        try{
            $lang = $request->header('language');


            $footerImageLink = FooterImageLink::find($id);

            if (is_null($footerImageLink))
                return response()->json(Validation::nothingFoundLang($lang));

            if ($footerImageLink->delete()){
                FileHelper::deleteFile($footerImageLink->image);
                return response()->json(new Response($request->token, $footerImageLink));
            }

            return response()->json(Validation::errorTokenLang($request->token, $lang));

        } catch (\Exception $ex) {
            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }
    }

    public function upload(Request $request, $id = null)
    {

        try{


            $validate = Validation::footerImage($request);
            if($validate){
                return response()->json($validate);
            }

            $image_info = FileHelper::uploadImage($request['photo'], 'footer');
            $request['image'] = $image_info['name'];

            $footer_image = $id ? FooterImageLink::find($id) : null;

            if (is_null($footer_image)){
                $request['admin_id'] = $request->user()->id;
                $footer_image = FooterImageLink::create($request->all());

            }else{
                $image = $footer_image->image;
                if($footer_image->update($request->all())){
                    FileHelper::deleteFile($image);
                }
            }

            $footer_image['created'] = Utils::formatDate($footer_image->created_at);
            return response()->json(new Response($request->token, $footer_image));


        } catch (\Exception $ex) {
            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }


    }
}
