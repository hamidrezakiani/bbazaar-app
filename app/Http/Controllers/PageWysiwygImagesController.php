<?php

namespace App\Http\Controllers;

use App\Models\Helper\ControllerHelper;
use App\Models\Helper\FileHelper;
use App\Models\Helper\Response;
use App\Models\Helper\Utils;
use App\Models\Helper\Validation;
use App\Models\Page;
use App\Models\PageWysiwygImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class PageWysiwygImagesController extends ControllerHelper
{
    public function upload(Request $request)
    {
        try{

            if($request['item_id']){
                if($can = Utils::userCan($this->user, 'page.edit')){
                    return $can;
                }
            }else{
                if($can = Utils::userCan($this->user, 'page.create')){
                    return $can;
                }
            }

            $validate = Validation::page_wysiwyg_image($request);
            if($validate){
                return response()->json($validate);
            }

            $imageInfo = FileHelper::uploadImage($request['photo'], 'wysiwyg-image', false);
            $url = FileHelper::imageFullUrl($imageInfo['name']);

            if(!is_null($request['page'])){
                $page = json_decode($request['page'], true);
                $page['admin_id'] = $request->user()->id;

                $page['description'] = $page['description'] . "<img src='" . $url . "'>";

                if(trim($page['slug']) == ''){
                    $page['slug'] = Utils::generateRandomString(5);
                }
                if(trim($page['title']) == ''){
                    $page['title'] = 'title';
                }
                if(trim($page['meta_title']) == ''){
                    $page['meta_title'] = 'Meta title';
                }
                if(trim($page['meta_description']) == ''){
                    $page['meta_description'] = 'Meta description';
                }

                $filtered = array_filter($page, function ($element) {
                    return !is_array($element) && '' !== trim($element);
                });

                $page = Page::create($filtered);
                $request['page_id'] = $page['id'];

            }else if($request['item_id']){
                $page['description'] = $request['description'] . "<img src='" . $url . "'>";
                Page::where('id', $request['page_id'] )->update($page);
            }

            $request['image'] = $imageInfo['name'];
            $request['admin_id'] = $request->user()->id;

            $pageWysiwygImage = PageWysiwygImage::create($request->all());
            $pageWysiwygImage['url'] =  $url;

            return response()->json(new Response($request->token, $pageWysiwygImage));


        } catch (\Exception $ex) {
            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }

    }

    public function delete(Request $request, $image_name)
    {
        try{
            if($can = Utils::userCan($this->user, 'page.edit')){
                return $can;
            }

            FileHelper::deleteFile($image_name);

            $pageWysiwygImage = PageWysiwygImage::where('image', $image_name)->get()->first();

            if ($pageWysiwygImage){

                if(!$this->isSuperAdmin && $isOwner = Utils::isDataOwner($this->user, $pageWysiwygImage)) {
                    return $isOwner;
                }


                PageWysiwygImage::where('image', $image_name)->delete();
            }

            return response()->json(new Response($request->token, $pageWysiwygImage));

        } catch (\Exception $ex) {
            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }
    }
}
