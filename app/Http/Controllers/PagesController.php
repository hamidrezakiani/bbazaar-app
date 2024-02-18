<?php

namespace App\Http\Controllers;

use App\Models\EditorImage;
use App\Models\FooterLink;
use App\Models\Helper\ControllerHelper;
use App\Models\Helper\Response;
use App\Models\Helper\Utils;
use App\Models\Helper\Validation;
use App\Models\Page;
use App\Models\PageLang;
use App\Models\PageWysiwygImage;
use App\Models\WysiwygImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use App\Models\Helper\FileHelper;

class PagesController extends ControllerHelper
{
    public function all(Request $request)
    {
        try {
            $lang = $request->header('language');

            if($can = Utils::userCan($this->user, 'page.view')){
                return $can;
            }

            $query = Page::query();
            $query = $query->orderBy('pages.' . $request->orderby, $request->type);



            if ($lang) {
                $query = $query->leftJoin('page_langs as cl', function ($join) use ($lang) {
                    $join->on('cl.page_id', '=', 'pages.id');
                    $join->where('cl.lang', $lang);
                });
                $query = $query->select('pages.id', 'pages.title', 'pages.slug',
                    'pages.created_at', 'pages.page_from_component',
                    'cl.title');
            }

            if($this->isVendor) {
                $query = $query->where('admin_id', $this->user->id);
            }

            if($request->q){
                $query = $query->where('pages.title', 'LIKE', "%{$request->q}%");
            }

            $data = $query->paginate(Config::get('constants.api.PAGINATION'));

            foreach ($data as $item){
                $item['created'] = Utils::formatDate($item->created_at);
            }
            return response()->json(new Response($request->token, $data));


        } catch (\Exception $ex) {
            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }
    }

    public function allPages(Request $request)
    {

        try {
            $lang = $request->header('language');

            $query = Page::query();

            if ($lang) {
                $query = $query->leftJoin('page_langs as cl', function ($join) use ($lang) {
                    $join->on('cl.page_id', '=', 'pages.id');
                    $join->where('cl.lang', $lang);
                });
                $query = $query->select('pages.id', 'pages.title', 'cl.title');
            }
            $data = $query->orderBy('pages.created_at', 'ASC')->get();


            return response()->json(new Response($request->token, $data));

        } catch (\Exception $ex) {
            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }
    }

    public function action(Request $request, $id = null)
    {

        try {
            $lang = $request->header('language');


            $validate = Validation::page($request);
            if($validate){
                return response()->json($validate);
            }

            $page_by_slug = Page::where('slug', $request['slug'])->get()->first();

            if($id){
                if($can = Utils::userCan($this->user, 'page.edit')){
                    return $can;
                }

                $existing = Page::find($id);
                if(!$this->isSuperAdmin && $isOwner = Utils::isDataOwner($this->user, $existing)) {
                    return $isOwner;
                }

                if($page_by_slug && $page_by_slug['id'] != $id){
                    return response()->json(Validation::error($request->token,
                        __('lang.slug_exists', [], $lang)
                    ));
                }

                if(trim($request->description == '')){
                    $request->description = '-1';
                }

                $filtered = array_filter($request->all(), function ($element) {
                    return  !is_array($element) && '' !== trim($element);
                });

                if($request->description == '-1'){
                    $filtered['description'] = '';
                }


                if ($lang) {
                    [$langData, $mainData] = Utils::seperateLangData($filtered, [
                        'title', 'description', 'meta_title', 'meta_description'
                    ]);
                    Page::where('id', $id)->update($mainData);
                    $existingLang = PageLang::where('page_id', $id)->where('lang', $lang)->first();

                    if (!$existingLang) {
                        $langData['page_id'] = $id;
                        $langData['lang'] = $lang;
                        PageLang::create($langData);

                    } else {
                        PageLang::where('id', $existingLang->id)->update($langData);
                    }
                } else {
                    Page::where('id', $id)->update($filtered);
                }


            }else{
                if($can = Utils::userCan($this->user, 'page.create')){
                    return $can;
                }

                if($page_by_slug){
                    return response()->json(Validation::error($request->token,
                        __('lang.slug_exists', [], $lang)
                    ));
                }

                $request['admin_id'] = $request->user()->id;

                if ($lang) {
                    [$langData, $mainData] = Utils::seperateLangData($request->all(), [
                        'title', 'description', 'meta_title', 'meta_description'
                    ]);
                    $page = Page::create($mainData);

                    $langData['page_id'] = $page->id;
                    $langData['lang'] = $lang;
                    PageLang::create($langData);
                    $id = $page->id;

                } else {
                    $page = Page::create($request->all());
                    $id = $page->id;
                }

                if($request['wysiwyg_image_id']){
                    foreach ($request['wysiwyg_image_id'] as $item){
                        WysiwygImage::where('id', $item)->update(array('item_id' => $id));
                    }
                }
            }


            $query = Page::query();

            if ($lang) {
                $query = $query->leftJoin('page_langs as cl', function ($join) use ($lang) {
                    $join->on('cl.page_id', '=', 'pages.id');
                    $join->where('cl.lang', $lang);
                });
                $query = $query->select('pages.*', 'cl.title',
                    'cl.description', 'cl.meta_title', 'cl.meta_description');
            }

            $data = $query->find($id);


            return response()->json(new Response($request->token, $data));


        } catch (\Exception $ex) {
            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }
    }


    public function find(Request $request, $id)
    {
        try {

            $lang = $request->header('language');


            if($can = Utils::userCan($this->user, 'page.view')){
                return $can;
            }

            $query = Page::query();

            if ($lang) {
                $query = $query->leftJoin('page_langs as cl', function ($join) use ($lang) {
                    $join->on('cl.page_id', '=', 'pages.id');
                    $join->where('cl.lang', $lang);
                });
                $query = $query->select('pages.*', 'cl.title',
                    'cl.description', 'cl.meta_title', 'cl.meta_description');
            }

            $page = $query->find($id);

            if(!$this->isSuperAdmin && $isOwner = Utils::isDataOwner($this->user, $page)) {
                return $isOwner;
            }

            if (is_null($page)){
                return response()->json(Validation::noDataLang($lang));
            }

            return response()->json(new Response($request->token, $page));

        } catch (\Exception $ex) {
            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }
    }



    public function delete(Request $request, $id)
    {
        try{

            $lang = $request->header('language');


            if($can = Utils::userCan($this->user, 'page.delete')){
                return $can;
            }

            $page = Page::find($id);

            if(!$this->isSuperAdmin && $isOwner = Utils::isDataOwner($this->user, $page)) {
                return $isOwner;
            }

            if (is_null($page)){
                return response()->json(Validation::noDataLang($lang));
            }

            $footer_link = FooterLink::where(['id' => $id])->first();

            if(!is_null($footer_link)){
                return response()->json(Validation::error($request->token,
                    __('lang.delete_footer', [], $lang)
                ));
            }

            $descriptionImages = PageWysiwygImage::where(['page_id' => $id])->get();
            foreach ($descriptionImages as $di){
                $di->delete();
                FileHelper::deleteFile($di->image);
            }

            PageLang::where('page_id', $id)->delete();

            if ($page->delete()){
                return response()->json(new Response($request->token, $page));
            }

            return response()->json(Validation::errorTokenLang($request->token, $lang));

        } catch (\Exception $ex) {
            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }



    }
}
