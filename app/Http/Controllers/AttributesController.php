<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use App\Models\AttributeLang;
use App\Models\AttributeValue;
use App\Models\AttributeValueLang;
use App\Models\Helper\ControllerHelper;
use App\Models\Inventory;
use App\Models\InventoryAttribute;
use Illuminate\Http\Request;
use App\Models\Helper\Response;
use App\Models\Helper\Utils;
use App\Models\Helper\Validation;
use Illuminate\Support\Facades\Config;

class AttributesController extends ControllerHelper
{
    public function all(Request $request)
    {
        try {


            $lang = $request->header('language');

            if ($can = Utils::userCan($this->user, 'attribute.view')) {
                return $can;
            }

            $query = Attribute::query();

            if ($lang) {
                $query = $query->leftJoin('attribute_langs as al', function ($join) use ($lang) {
                    $join->on('al.attribute_id', '=', 'attributes.id');
                    $join->where('al.lang', $lang);
                });
                $query = $query->select('attributes.*', 'al.title');

                $query = $query->with(['values' => function ($query) use ($lang) {
                    $query->leftJoin('attribute_value_langs as avl',
                        function ($join) use ($lang) {
                            $join->on('attribute_values.id', '=', 'avl.attribute_value_id');
                            $join->where('avl.lang', $lang);
                        })
                        ->select('attribute_values.*', 'avl.title');
                }]);


                if ($request->q) {
                    $query = $query->where('al.title', 'LIKE', "%{$request->q}%");
                }

            } else {
                $query = $query->with('values');


                if ($request->q) {
                    $query = $query->where('attributes.title', 'LIKE', "%{$request->q}%");
                }
            }

            $query = $query->orderBy('attributes.' . $request->orderby, $request->type);



            if ($this->isVendor) {
                $query = $query->where('attributes.admin_id', $this->user->id);
            }

            $data = $query->paginate(Config::get('constants.api.PAGINATION'));

            foreach ($data as $item) {
                $item['created'] = Utils::formatDate($item->created_at);
            }
            return response()->json(new Response($request->token, $data));


        } catch (\Exception $ex) {
            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }
    }


    public function allAttributes(Request $request)
    {
        try {
            $lang = $request->header('language');


            $query = Attribute::query();

            if ($lang) {
                $query = $query->leftJoin('attribute_langs as al', function ($join) use ($lang) {
                    $join->on('al.attribute_id', '=', 'attributes.id');
                    $join->where('al.lang', $lang);
                });
                $query = $query->select('attributes.*', 'al.title');

                $query = $query->with(['values' => function ($query) use ($lang) {
                    $query->leftJoin('attribute_value_langs as avl',
                        function ($join) use ($lang) {
                            $join->on('attribute_values.id', '=', 'avl.attribute_value_id');
                            $join->where('avl.lang', $lang);
                        })
                        ->select('attribute_values.*', 'avl.title');
                }]);

            } else {
                $query = $query->with('values');
            }

            $query = $query->orderBy('attributes.created_at');
            $data = $query->get();


            return response()->json(new Response($request->token, $data));

        } catch (\Exception $ex) {
            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }
    }


    public function find(Request $request, $id)
    {
        try {
            $lang = $request->header('language');

            if ($can = Utils::userCan($this->user, 'attribute.view')) {
                return $can;
            }

            $query = Attribute::query();
            if ($lang) {
                $query = $query->leftJoin('attribute_langs as al', function ($join) use ($lang) {
                    $join->on('al.attribute_id', '=', 'attributes.id');
                    $join->where('al.lang', $lang);
                });
                $query = $query->select('attributes.*', 'al.title');

                $query = $query->with(['values' => function ($query) use ($lang) {
                    $query->leftJoin('attribute_value_langs as avl',
                        function ($join) use ($lang) {
                            $join->on('attribute_values.id', '=', 'avl.attribute_value_id');
                            $join->where('avl.lang', $lang);
                        })
                        ->select('attribute_values.*', 'avl.title');
                }]);

            } else {
                $query = $query->with('values');
            }

            $attribute = $query->find($id);

            if (is_null($attribute)) {
                return response()->json(Validation::noDataLang($lang));
            }

            return response()->json(new Response($request->token, $attribute));

        } catch (\Exception $ex) {
            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }
    }


    public function action(Request $request, $id = null)
    {
        try {

            $lang = $request->header('language');

            $validate = Validation::attribute($request);
            if ($validate) {
                return response()->json($validate);
            }

            if ($id) {
                if ($can = Utils::userCan($this->user, 'attribute.edit')) {
                    return $can;
                }

                $filtered = array_filter($request->all(), function ($element) {
                    return !is_array($element) && '' !== trim($element);
                });

                $data = ['add' => [], 'delete' => []];
                foreach ($request->values as $value) {

                    if (!key_exists('id', $value) && ('' != trim($value['title']))) {
                        array_push($data['add'],
                            [
                                'title' => $value['title'],
                                'attribute_id' => $id,
                                'admin_id' => $request->user()->id
                            ]
                        );
                    } else if (key_exists('id', $value) && '' == trim($value['title'])) {

                        $inventoryAttribute = InventoryAttribute::where('attribute_value_id', $value['id'])
                            ->get()
                            ->first();


                        if (!is_null($inventoryAttribute)) {
                            return response()->json(Validation::error($request->token,
                                __('lang.used_inventory', [], $lang)));
                        }

                        array_push($data['delete'], $value['id']);
                    } else if (key_exists('id', $value) && '' != trim($value['title'])) {

                        if ($lang) {
                            $existingValue = AttributeValueLang::where('attribute_value_id', $value['id'])
                                ->where('lang', $lang)->first();

                            if ($existingValue) {
                                AttributeValueLang::where('id', $existingValue->id)
                                    ->update([
                                        'title' => $value['title']
                                    ]);
                            } else {
                                AttributeValueLang::create([
                                    'attribute_value_id' => $value['id'],
                                    'lang' => $lang,
                                    'title' => $value['title'],
                                ]);
                            }
                        } else {
                            AttributeValue::where('id', $value['id'])->update(['title' => $value['title']]);
                        }
                    }
                }


                if (count($data['add']) > 0) {
                    if ($can = Utils::userCan($this->user, 'attribute.create')) {
                        return $can;
                    }

                    if ($lang) {
                        foreach ($data['add'] as $i) {
                            $avid = AttributeValue::create([
                                'attribute_id' => $id,
                                'admin_id' => $request->user()->id
                            ]);

                            AttributeValueLang::create([
                                'attribute_value_id' => $avid->id,
                                'lang' => $lang,
                                'title' => $i['title'],
                            ]);
                        }
                    } else {
                        AttributeValue::insert($data['add']);
                    }
                }

                if (count($data['delete']) > 0) {
                    if ($can = Utils::userCan($this->user, 'attribute.delete')) {
                        return $can;
                    }

                    AttributeValueLang::whereIn('attribute_value_id', $data['delete'])->delete();
                    AttributeValue::whereIn('id', $data['delete'])->delete();
                }

                if ($lang) {


                    $existingAttrLang = AttributeLang::where('attribute_id', $id)->where('lang', $lang)->first();

                    if ($existingAttrLang) {
                        AttributeLang::where('id', $existingAttrLang->id)->update(['title' => $filtered['title']]);

                    } else {
                        AttributeLang::insert([
                            'lang' => $lang,
                            'attribute_id' => $id,
                            'title' => $request->title
                        ]);
                    }

                } else {

                    Attribute::where('id', $id)->update(['title' => $filtered['title']]);
                }


            } else {
                if ($can = Utils::userCan($this->user, 'attribute.create')) {
                    return $can;
                }

                $request['admin_id'] = $request->user()->id;


                if ($lang) {

                    $attribute = Attribute::create(['admin_id' => $request->user()->id]);

                    AttributeLang::create([
                        'attribute_id' => $attribute->id,
                        'title' => $request['title'],
                        'lang' => $lang,
                    ]);


                } else {
                    $attribute = Attribute::create($request->all());
                }


                $id = $attribute->id;

                $data = ['add' => []];
                foreach ($request->values as $value) {
                    if (!key_exists('id', $value) && ('' != trim($value['title']))) {
                        array_push($data['add'],
                            [
                                'title' => $value['title'],
                                'attribute_id' => $attribute->id,
                                'admin_id' => $request->user()->id
                            ]
                        );
                    }
                }


                if (count($data['add']) > 0) {
                    if ($can = Utils::userCan($this->user, 'attribute.create')) {
                        return $can;
                    }

                    if ($lang) {
                        foreach ($data['add'] as $i) {
                            $avid = AttributeValue::create([
                                'attribute_id' => $attribute->id,
                                'admin_id' => $request->user()->id
                            ]);

                            AttributeValueLang::create([
                                'attribute_value_id' => $avid->id,
                                'lang' => $lang,
                                'title' => $i['title'],
                            ]);
                        }
                    } else {
                        AttributeValue::insert($data['add']);
                    }

                }
            }


            //Fetching attribute data
            $query = Attribute::query();
            if ($lang) {
                $query = $query->leftJoin('attribute_langs as al', function ($join) use ($lang) {
                    $join->on('al.attribute_id', '=', 'attributes.id');
                    $join->where('al.lang', $lang);
                });
                $query = $query->select('attributes.*', 'al.title');

                $query = $query->with(['values' => function ($query) use ($lang) {
                    $query->leftJoin('attribute_value_langs as avl',
                        function ($join) use ($lang) {
                            $join->on('attribute_values.id', '=', 'avl.attribute_value_id');
                            $join->where('avl.lang', $lang);
                        })
                        ->select('attribute_values.*', 'avl.title');
                }]);

            } else {
                $query = $query->with('values');
            }

            $attr = $query->find($id);


            return response()->json(new Response($request->token, $attr));

        } catch (\Exception $ex) {
            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }
    }


    public function delete(Request $request, $id)
    {
        try {

            $lang = $request->header('language');

            if ($can = Utils::userCan($this->user, 'attribute.delete')) {
                return $can;
            }

            $attribute = Attribute::find($id);

            if (is_null($attribute)) {
                return response()->json(Validation::nothingFoundLang($lang));
            }

            if (!$this->isSuperAdmin && $isOwner = Utils::isDataOwner($this->user, $attribute)) {
                return $isOwner;
            }

            $attributeValues = AttributeValue::where('attribute_id', $id)->get();

            foreach ($attributeValues as $attributeValue) {

                $inventoryAttribute = InventoryAttribute::where('attribute_value_id', $attributeValue->id)
                    ->first();

                if (!is_null($inventoryAttribute)) {
                    return response()->json(Validation::error($request->token,
                        __('lang.delete_attribute', [], $lang)));
                }
            }

            foreach ($attributeValues as $attributeValue) {
                AttributeValueLang::where('attribute_value_id', $attributeValue->id)->delete();

                AttributeValue::where('id', $attributeValue->id)->delete();
            }


            AttributeLang::where('attribute_id', $id)->delete();


            if ($attribute->delete()) {
                return response()->json(new Response($request->token, $attribute));
            }

            return response()->json(Validation::error($request->token, null, 'form', $lang));

        } catch (\Exception $ex) {
            return response()->json(Validation::error($request->token, $ex->getMessage()));
        }
    }
}
