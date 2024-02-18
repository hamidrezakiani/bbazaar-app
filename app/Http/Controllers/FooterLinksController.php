<?php

namespace App\Http\Controllers;

use App\Models\FooterImageLink;
use App\Models\FooterLink;
use App\Models\Helper\ControllerHelper;
use App\Models\Helper\Response;
use App\Models\Helper\Utils;
use App\Models\Helper\Validation;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class FooterLinksController extends ControllerHelper
{

    public function all(Request $request)
    {
        try {
            if ($can = Utils::userCan($this->user, 'footer_link.view')) {
                return $can;
            }

            $query = FooterLink::orderBy('created_at', 'DESC');

            if ($this->isVendor) {
                $query = $query->where('admin_id', $this->user->id);
            }

            $footer_links = $query->select('id', 'page_id', 'type')->get();

            $data['about_links'] = [];
            $data['service_links'] = [];

            foreach ($footer_links as $i) {
                if ((int)$i->type == Config::get('constants.footerLinkType.SERVICE')) {
                    array_push($data['service_links'], $i);
                } else {
                    array_push($data['about_links'], $i);
                }
            }

            $footer_query = FooterImageLink::orderBy('created_at', 'DESC');

            if ($this->isVendor) {
                $footer_query = $footer_query->where('admin_id', $this->user->id);
            }

            $footer_image_links = $footer_query->get();

            $data['payment_links'] = [];
            $data['social_links'] = [];

            foreach ($footer_image_links as $i) {
                if ((int)$i->type == Config::get('constants.footerImageLinkType.PAYMENT')) {
                    array_push($data['payment_links'], $i);
                } else {
                    array_push($data['social_links'], $i);
                }
            }

            return response()->json(new Response($request->token, $data));
        } catch (\Exception $ex) {
            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }
    }


    public function serviceAndAboutAction(Request $request)
    {

        try {
            // Adding / deleting / updating
            $linksDeleted = [];
            $linksAdded = [];

            foreach ($request->about_links as $i) {
                if (key_exists('deleted', $i) && key_exists('id', $i) && $i['id'] && $i['deleted']) {
                    // Deleted
                    array_push($linksDeleted, $i['id']);
                } else if ((!key_exists('id', $i) || (key_exists('id', $i) && !$i['id']))
                    && ((key_exists('deleted', $i) && !$i['deleted']) || !key_exists('deleted', $i))
                    && $i['page_id']) {
                    // Added
                    array_push($linksAdded, [
                        'type' => Config::get('constants.footerLinkType.ABOUT'),
                        'page_id' => $i['page_id'],
                        'admin_id' => $request->user()->id
                    ]);
                } else if ($i['id'] && (key_exists('updated', $i) && $i['updated']) && $i['page_id']) {
                    // Updated
                    FooterLink::where('id', $i['id'])->update([
                        'page_id' => $i['page_id']
                    ]);
                }
            }

            // Adding / deleting / updating

            foreach ($request->service_links as $i) {
                if (key_exists('deleted', $i) && key_exists('id', $i) && $i['id'] && $i['deleted']) {
                    // Deleted
                    if ($can = Utils::userCan($this->user, 'footer_link.delete')) {
                        return $can;
                    }

                    array_push($linksDeleted, $i['id']);
                } else if ((!key_exists('id', $i) || (key_exists('id', $i) && !$i['id']))
                    && ((key_exists('deleted', $i) && !$i['deleted']) || !key_exists('deleted', $i))
                    && $i['page_id']) {
                    // Added
                    if ($can = Utils::userCan($this->user, 'footer_link.create')) {
                        return $can;
                    }

                    array_push($linksAdded, [
                        'type' => Config::get('constants.footerLinkType.SERVICE'),
                        'page_id' => $i['page_id'],
                        'admin_id' => $request->user()->id
                    ]);
                } else if ($i['id'] && (key_exists('updated', $i) && $i['updated']) && $i['page_id']) {
                    // Updated

                    if ($can = Utils::userCan($this->user, 'footer_link.edit')) {
                        return $can;
                    }
                    FooterLink::where('id', $i['id'])->update([
                        'page_id' => $i['page_id']
                    ]);
                }
            }

            FooterLink::whereIn('id', $linksDeleted)->delete();
            FooterLink::insert($linksAdded);


            $footer_links_query = FooterLink::orderBy('created_at', 'DESC');
            if ($this->isVendor) {
                $footer_links_query = $footer_links_query->where('admin_id', $this->user->id);
            }
            $footer_links = $footer_links_query->select('id', 'page_id', 'type')->get();

            $data['about_links'] = [];
            $data['service_links'] = [];

            foreach ($footer_links as $i) {
                if ((int)$i->type == Config::get('constants.footerLinkType.SERVICE')) {
                    array_push($data['service_links'], $i);
                } else {
                    array_push($data['about_links'], $i);
                }
            }

            return response()->json(new Response($request->token, $data));
        } catch (\Exception $ex) {
            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }
    }


    public function action(Request $request, FooterLink $footerLink)
    {

        try {


            $validate = Validation::footerLink($request);
            if ($validate) {
                return response()->json($validate);
            }

            if ($footerLink->id) {
                if ($can = Utils::userCan($this->user, 'footer_link.edit')) {
                    return $can;
                }

                $existing = FooterLink::find($footerLink->id);
                if (!$this->isSuperAdmin && $isOwner = Utils::isDataOwner($this->user, $existing)) {
                    return $isOwner;
                }

                $filtered = array_filter($request->all(), function ($element) {
                    return '' !== trim($element);
                });

                $footerLink->update(array_filter($filtered));

            } else {
                if ($can = Utils::userCan($this->user, 'footer_link.create')) {
                    return $can;
                }

                $request['admin_id'] = $request->user()->id;
                $footerLink = FooterLink::create($request->all());
            }

            if ($request->type === Config::get('constants.footerLinkType.SERVICE'))
                $footerLink['service_links'] = true;
            else
                $footerLink['about_links'] = true;

            return response()->json(new Response($request->token, $footerLink));
        } catch (\Exception $ex) {
            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }
    }

    public function delete(Request $request, $id)
    {
        try {
            $lang = $request->header('language');


            if ($can = Utils::userCan($this->user, 'footer_link.delete')) {
                return $can;
            }

            $footerLink = FooterLink::find($id);

            if (!$this->isSuperAdmin && $isOwner = Utils::isDataOwner($this->user, $footerLink)) {
                return $isOwner;
            }

            if (is_null($footerLink)) {
                return response()->json(Validation::noDataLang($lang));
            }

            if ($footerLink->delete()) {
                return response()->json(new Response($request->token, $footerLink));
            }

            return response()->json(Validation::errorTokenLang($request->token, $lang));


        } catch (\Exception $ex) {
            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }
    }
}
