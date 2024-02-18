<?php

namespace App\Http\Controllers;

use App\Models\HeaderLink;
use App\Models\HeaderLinkLang;
use App\Models\Helper\ControllerHelper;
use App\Models\Helper\Response;
use App\Models\Helper\Utils;
use App\Models\Helper\Validation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class HeaderLinksController extends ControllerHelper
{

    public function all(Request $request)
    {
        try {

            $lang = $request->header('language');

            if ($can = Utils::userCan($this->user, 'header_link.view')) {
                return $can;
            }

            $query = HeaderLink::orderBy('created_at', 'ASC');


            if ($this->isVendor) {
                $query = $query->where('admin_id', $this->user->id);
            }


            if ($lang) {
                $query = $query->leftJoin('header_link_langs as cl', function ($join) use ($lang) {
                    $join->on('cl.header_link_id', '=', 'header_links.id');
                    $join->where('cl.lang', $lang);
                });
                $query = $query->select('header_links.*', 'cl.title');
            }

            $headerLinks = $query->get();

            $data['left'] = [];
            $data['right'] = [];

            foreach ($headerLinks as $i) {
                if ((int)$i->type == Config::get('constants.headerLinkType.LEFT')) {
                    array_push($data['left'], $i);
                } else {
                    array_push($data['right'], $i);
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

            $lang = $request->header('language');

            $q = HeaderLink::orderBy('created_at', 'ASC');

            if ($this->isVendor) {
                $q = $q->where('admin_id', $this->user->id);
            }
            $headerLinks = $q->get();

            $left = [];
            $right = [];

            foreach ($headerLinks as $i) {
                if ((int)$i->type == Config::get('constants.headerLinkType.LEFT')) {
                    $left[$i->id] = $i;
                } else {
                    $right[$i->id] = $i;
                }
            }

            if ($request->left) {

                // Adding / Updating
                foreach ($request->left as $i) {
                    if (key_exists('id', $i) &&
                        (!key_exists('deleted', $i) || (key_exists('deleted', $i) && !$i['deleted']))) {

                        if (key_exists($i['id'], $left)) {
                            unset($left[$i['id']]);

                            if ($lang) {

                                HeaderLink::where('id', $i['id'])->update([
                                    'url' => $i['url']
                                ]);

                                $existingLang = HeaderLinkLang::where('header_link_id', $i['id'])
                                    ->where('lang', $lang)
                                    ->first();

                                if (!$existingLang) {
                                    $langData['header_link_id'] = $i['id'];
                                    $langData['lang'] = $lang;
                                    $langData['title'] = $i['title'];
                                    HeaderLinkLang::create($langData);

                                } else {
                                    HeaderLinkLang::where('id', $existingLang->id)
                                        ->update([
                                            'title' => $i['title']
                                        ]);
                                }


                            } else {
                                HeaderLink::where('id', $i['id'])
                                    ->update([
                                        'title' => $i['title'],
                                        'url' => $i['url']
                                    ]);
                            }

                        }
                    } else if (!key_exists('deleted', $i) || (key_exists('deleted', $i) && !$i['deleted'])) {


                        if ($lang) {
                            $headerLink =  HeaderLink::create([
                                'url' => $i['url'],
                                'admin_id' => $this->user->id,
                                'type' => Config::get('constants.headerLinkType.LEFT'),
                            ]);

                            HeaderLinkLang::create([
                                'header_link_id' => $headerLink->id,
                                'lang' => $lang,
                                'title' => $i['title'],
                            ]);

                        } else {

                            HeaderLink::create([
                                'url' => $i['url'],
                                'title' => $i['title'],
                                'admin_id' => $this->user->id,
                                'type' => Config::get('constants.headerLinkType.LEFT'),
                            ]);
                        }

                    }
                }

                // Deleting
                foreach ($left as $key => $i) {
                    HeaderLinkLang::where('header_link_id', $key)->delete();
                    HeaderLink::where('id', $key)->delete();
                }
            }

            if ($request->right) {

                // Adding / Updating
                foreach ($request->right as $i) {
                    if (key_exists('id', $i) &&
                        (!key_exists('deleted', $i) || (key_exists('deleted', $i) && !$i['deleted']))) {

                        if (key_exists($i['id'], $right)) {
                            unset($right[$i['id']]);

                            if ($lang) {

                                HeaderLink::where('id', $i['id'])->update([
                                    'url' => $i['url']
                                ]);

                                $existingLang = HeaderLinkLang::where('header_link_id', $i['id'])
                                    ->where('lang', $lang)
                                    ->first();

                                if (!$existingLang) {
                                    $langData['header_link_id'] = $i['id'];
                                    $langData['lang'] = $lang;
                                    $langData['title'] = $i['title'];
                                    HeaderLinkLang::create($langData);

                                } else {
                                    HeaderLinkLang::where('id', $existingLang->id)
                                        ->update([
                                            'title' => $i['title']
                                        ]);
                                }


                            } else {
                                HeaderLink::where('id', $i['id'])
                                    ->update([
                                        'title' => $i['title'],
                                        'url' => $i['url']
                                    ]);
                            }

                        }
                    } else if (!key_exists('deleted', $i) || (key_exists('deleted', $i) && !$i['deleted'])) {

                        if ($lang) {
                            $headerLink =  HeaderLink::create([
                                'url' => $i['url'],
                                'admin_id' => $this->user->id,
                                'type' => Config::get('constants.headerLinkType.RIGHT'),
                            ]);

                            HeaderLinkLang::create([
                                'header_link_id' => $headerLink->id,
                                'lang' => $lang,
                                'title' => $i['title'],
                            ]);

                        } else {

                            HeaderLink::create([
                                'url' => $i['url'],
                                'title' => $i['title'],
                                'admin_id' => $this->user->id,
                                'type' => Config::get('constants.headerLinkType.RIGHT'),
                            ]);
                        }

                    }
                }


                // Deleting
                foreach ($right as $key => $i) {

                    HeaderLinkLang::where('header_link_id', $key)->delete();
                    HeaderLink::where('id', $key)->delete();
                }
            }


            $query = HeaderLink::orderBy('created_at', 'ASC');

            if ($this->isVendor) {
                $query = $query->where('admin_id', $this->user->id);
            }

            if ($lang) {
                $query = $query->leftJoin('header_link_langs as cl', function ($join) use ($lang) {
                    $join->on('cl.header_link_id', '=', 'header_links.id');
                    $join->where('cl.lang', $lang);
                });
                $query = $query->select('header_links.*', 'cl.title');
            }


            $links = $query->get();

            $data['left'] = [];
            $data['right'] = [];

            foreach ($links as $i) {
                if ((int)$i->type == Config::get('constants.headerLinkType.LEFT')) {
                    array_push($data['left'], $i);
                } else {
                    array_push($data['right'], $i);
                }
            }

            return response()->json(new Response($request->token, $data));
        } catch (\Exception $ex) {
            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }
    }

}
