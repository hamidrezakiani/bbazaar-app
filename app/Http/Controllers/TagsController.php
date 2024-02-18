<?php

namespace App\Http\Controllers;

use App\Models\Helper\Response;
use App\Models\Helper\Utils;
use App\Models\Helper\Validation;
use App\Models\SubscriptionEmail;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class TagsController extends Controller
{
    public function all(Request $request)
    {

        try {


            if ($request->q) {
                $data = Tag::query()
                    ->orderBy('created_at', 'DESC')
                    ->where('title', 'LIKE', "%{$request->q}%")
                    ->select('id', 'title')
                    ->paginate(Config::get('constants.api.PAGINATION'));
            } else {
                $data = Tag::orderBy('created_at', 'DESC')
                    ->select('id', 'title')
                    ->paginate(Config::get('constants.api.PAGINATION'));;
            }

            return response()->json(new Response($request->token, $data));
        } catch (\Exception $ex) {
            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }
    }


    public function action(Request $request, Tag $tag)
    {
        try {
            $validate = Validation::tag($request);
            if ($validate) {
                return response()->json($validate);
            }

            if ($tag->id) {
                $filtered = array_filter($request->all(), function ($element) {
                    return '' !== trim($element);
                });

                $tag->update(array_filter($filtered));

            } else {

                $existingTag = Tag::where('title', $request->title)->get()->first();

                if (!$existingTag)
                    $tag = Tag::create($request->all());
            }

            return response()->json(new Response($request->token, $tag));
        } catch (\Exception $ex) {
            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }
    }
}
