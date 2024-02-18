<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\RatingReview;
use Illuminate\Database\Seeder;

class RatingReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            [
                'id' => 1,
                'product_id' => 88630111,
                'user_id' => 1,
                'order_id' => 1,
                'rating' => 5,
                'review' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining'
            ],
            [
                'id' => 2,
                'product_id' => 88630111,
                'user_id' => 1,
                'order_id' => 1,
                'rating' => 5,
                'review' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining'
            ],
            [
                'id' => 3,
                'product_id' => 88630111,
                'user_id' => 1,
                'order_id' => 1,
                'rating' => 4,
                'review' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining'
            ],[
                'id' => 4,
                'product_id' => 88630111,
                'user_id' => 1,
                'order_id' => 1,
                'rating' => 4,
                'review' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining'
            ]
            ,[
                'id' => 5,
                'product_id' => 88630111,
                'user_id' => 1,
                'order_id' => 1,
                'rating' => 4,
                'review' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining'
            ],
            [
                'id' => 6,
                'product_id' => 88630112,
                'user_id' => 1,
                'order_id' => 1,
                'rating' => 5,
                'review' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining'
            ],
            [
                'id' => 7,
                'product_id' => 88630112,
                'user_id' => 1,
                'order_id' => 1,
                'rating' => 4,
                'review' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining'
            ],
            [
                'id' => 8,
                'product_id' => 88630112,
                'user_id' => 1,
                'order_id' => 1,
                'rating' => 5,
                'review' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining'
            ],[
                'id' => 9,
                'product_id' => 88630112,
                'user_id' => 1,
                'order_id' => 1,
                'rating' => 4,
                'review' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining'
            ]
            ,[
                'id' => 10,
                'product_id' => 88630113,
                'user_id' => 1,
                'order_id' => 1,
                'rating' => 5,
                'review' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining'
            ]
            ,[
                'id' => 11,
                'product_id' => 88630113,
                'user_id' => 1,
                'order_id' => 1,
                'rating' => 5,
                'review' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining'
            ],[
                'id' => 12,
                'product_id' => 88630113,
                'user_id' => 1,
                'order_id' => 1,
                'rating' => 5,
                'review' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining'
            ],[
                'id' => 13,
                'product_id' => 88630114,
                'user_id' => 1,
                'order_id' => 1,
                'rating' => 4,
                'review' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining'
            ]
            ,[
                'id' => 14,
                'product_id' => 88630114,
                'user_id' => 1,
                'order_id' => 1,
                'rating' => 4,
                'review' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining'
            ],[
                'id' => 15,
                'product_id' => 88630115,
                'user_id' => 1,
                'order_id' => 1,
                'rating' => 5,
                'review' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining'
            ]
            ,[
                'id' => 16,
                'product_id' => 88630116,
                'user_id' => 1,
                'order_id' => 1,
                'rating' => 3,
                'review' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining'
            ]
            ,[
                'id' => 17,
                'product_id' => 88630117,
                'user_id' => 1,
                'order_id' => 1,
                'rating' => 3,
                'review' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining'
            ],[
                'id' => 18,
                'product_id' => 88630117,
                'user_id' => 1,
                'order_id' => 1,
                'rating' => 4,
                'review' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining'
            ],[
                'id' => 19,
                'product_id' => 88630118,
                'user_id' => 1,
                'order_id' => 1,
                'rating' => 5,
                'review' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining'
            ],[
                'id' => 20,
                'product_id' => 88630118,
                'user_id' => 1,
                'order_id' => 1,
                'rating' => 5,
                'review' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining'
            ],[
                'id' => 21,
                'product_id' => 88630118,
                'user_id' => 1,
                'order_id' => 1,
                'rating' => 5,
                'review' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining'
            ],[
                'id' => 22,
                'product_id' => 88630119,
                'user_id' => 1,
                'order_id' => 1,
                'rating' => 5,
                'review' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining'
            ],[
                'id' => 23,
                'product_id' => 88630119,
                'user_id' => 1,
                'order_id' => 1,
                'rating' => 5,
                'review' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining'
            ],[
                'id' => 24,
                'product_id' => 88630119,
                'user_id' => 1,
                'order_id' => 1,
                'rating' => 4,
                'review' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining'
            ],[
                'id' => 25,
                'product_id' => 88630119,
                'user_id' => 1,
                'order_id' => 1,
                'rating' => 4,
                'review' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining'
            ],[
                'id' => 26,
                'product_id' => 88630120,
                'user_id' => 1,
                'order_id' => 1,
                'rating' => 5,
                'review' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining'
            ],[
                'id' => 27,
                'product_id' => 88630120,
                'user_id' => 1,
                'order_id' => 1,
                'rating' => 5,
                'review' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining'
            ],[
                'id' => 28,
                'product_id' => 88630120,
                'user_id' => 1,
                'order_id' => 1,
                'rating' => 3,
                'review' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining'
            ],[
                'id' => 29,
                'product_id' => 88630120,
                'user_id' => 1,
                'order_id' => 1,
                'rating' => 4,
                'review' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining'
            ],[
                'id' => 30,
                'product_id' => 88630120,
                'user_id' => 1,
                'order_id' => 1,
                'rating' => 4,
                'review' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining'
            ],[
                'id' => 31,
                'product_id' => 88630121,
                'user_id' => 1,
                'order_id' => 1,
                'rating' => 5,
                'review' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining'
            ],[
                'id' => 32,
                'product_id' => 88630121,
                'user_id' => 1,
                'order_id' => 1,
                'rating' => 4,
                'review' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining'
            ],[
                'id' => 33,
                'product_id' => 88630121,
                'user_id' => 1,
                'order_id' => 1,
                'rating' => 3,
                'review' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining'
            ],[
                'id' => 34,
                'product_id' => 88630121,
                'user_id' => 1,
                'order_id' => 1,
                'rating' => 4,
                'review' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining'
            ],[
                'id' => 35,
                'product_id' => 88630122,
                'user_id' => 1,
                'order_id' => 1,
                'rating' => 5,
                'review' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining'
            ],[
                'id' => 36,
                'product_id' => 88630122,
                'user_id' => 1,
                'order_id' => 1,
                'rating' => 4,
                'review' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining'
            ],[
                'id' => 37,
                'product_id' => 88630122,
                'user_id' => 1,
                'order_id' => 1,
                'rating' => 5,
                'review' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining'
            ],[
                'id' => 38,
                'product_id' => 88630123,
                'user_id' => 1,
                'order_id' => 1,
                'rating' => 5,
                'review' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining'
            ],[
                'id' => 39,
                'product_id' => 88630123,
                'user_id' => 1,
                'order_id' => 1,
                'rating' => 5,
                'review' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining'
            ],[
                'id' => 40,
                'product_id' => 88630124,
                'user_id' => 1,
                'order_id' => 1,
                'rating' => 4,
                'review' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining'
            ],[
                'id' => 41,
                'product_id' => 88630125,
                'user_id' => 1,
                'order_id' => 1,
                'rating' => 4,
                'review' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining'
            ],[
                'id' => 42,
                'product_id' => 88630126,
                'user_id' => 1,
                'order_id' => 1,
                'rating' => 5,
                'review' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining'
            ],[
                'id' => 43,
                'product_id' => 88630126,
                'user_id' => 1,
                'order_id' => 1,
                'rating' => 4,
                'review' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining'
            ],[
                'id' => 44,
                'product_id' => 88630127,
                'user_id' => 1,
                'order_id' => 1,
                'rating' => 5,
                'review' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining'
            ],[
                'id' => 45,
                'product_id' => 88630127,
                'user_id' => 1,
                'order_id' => 1,
                'rating' => 2,
                'review' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining'
            ],[
                'id' => 46,
                'product_id' => 88630127,
                'user_id' => 1,
                'order_id' => 1,
                'rating' => 5,
                'review' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining'
            ],[
                'id' => 47,
                'product_id' => 88630128,
                'user_id' => 1,
                'order_id' => 1,
                'rating' => 3,
                'review' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining'
            ],[
                'id' => 48,
                'product_id' => 88630128,
                'user_id' => 1,
                'order_id' => 1,
                'rating' => 4,
                'review' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining'
            ],[
                'id' => 49,
                'product_id' => 88630128,
                'user_id' => 1,
                'order_id' => 1,
                'rating' => 3,
                'review' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining'
            ],[
                'id' => 50,
                'product_id' => 88630128,
                'user_id' => 1,
                'order_id' => 1,
                'rating' => 5,
                'review' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining'
            ],[
                'id' => 51,
                'product_id' => 88630129,
                'user_id' => 1,
                'order_id' => 1,
                'rating' => 4,
                'review' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining'
            ],[
                'id' => 52,
                'product_id' => 88630129,
                'user_id' => 1,
                'order_id' => 1,
                'rating' => 4,
                'review' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining'
            ],[
                'id' => 53,
                'product_id' => 88630129,
                'user_id' => 1,
                'order_id' => 1,
                'rating' => 4,
                'review' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining'
            ],[
                'id' => 54,
                'product_id' => 88630129,
                'user_id' => 1,
                'order_id' => 1,
                'rating' => 4,
                'review' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining'
            ],[
                'id' => 55,
                'product_id' => 88630129,
                'user_id' => 1,
                'order_id' => 1,
                'rating' => 4,
                'review' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining'
            ],[
                'id' => 56,
                'product_id' => 88630130,
                'user_id' => 1,
                'order_id' => 1,
                'rating' => 5,
                'review' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining'
            ],[
                'id' => 57,
                'product_id' => 88630130,
                'user_id' => 1,
                'order_id' => 1,
                'rating' => 5,
                'review' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining'
            ],[
                'id' => 58,
                'product_id' => 88630130,
                'user_id' => 1,
                'order_id' => 1,
                'rating' => 5,
                'review' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining'
            ],[
                'id' => 59,
                'product_id' => 88630130,
                'user_id' => 1,
                'order_id' => 1,
                'rating' => 5,
                'review' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining'
            ],[
                'id' => 60,
                'product_id' => 88630131,
                'user_id' => 1,
                'order_id' => 1,
                'rating' => 4,
                'review' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining'
            ],[
                'id' => 61,
                'product_id' => 88630131,
                'user_id' => 1,
                'order_id' => 1,
                'rating' => 5,
                'review' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining'
            ],[
                'id' => 62,
                'product_id' => 88630131,
                'user_id' => 1,
                'order_id' => 1,
                'rating' => 4,
                'review' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining'
            ],[
                'id' => 63,
                'product_id' => 88630132,
                'user_id' => 1,
                'order_id' => 1,
                'rating' => 5,
                'review' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining'
            ],[
                'id' => 64,
                'product_id' => 88630132,
                'user_id' => 1,
                'order_id' => 1,
                'rating' => 5,
                'review' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining'
            ],[
                'id' => 65,
                'product_id' => 88630133,
                'user_id' => 1,
                'order_id' => 1,
                'rating' => 4,
                'review' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining'
            ],[
                'id' => 66,
                'product_id' => 88630134,
                'user_id' => 1,
                'order_id' => 1,
                'rating' => 4,
                'review' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining'
            ],[
                'id' => 67,
                'product_id' => 88630135,
                'user_id' => 1,
                'order_id' => 1,
                'rating' => 3,
                'review' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining'
            ],[
                'id' => 68,
                'product_id' => 88630135,
                'user_id' => 1,
                'order_id' => 1,
                'rating' => 4,
                'review' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining'
            ],[
                'id' => 69,
                'product_id' => 88630136,
                'user_id' => 1,
                'order_id' => 1,
                'rating' => 2,
                'review' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining'
            ],[
                'id' => 70,
                'product_id' => 88630136,
                'user_id' => 1,
                'order_id' => 1,
                'rating' => 2,
                'review' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining'
            ],[
                'id' => 71,
                'product_id' => 88630136,
                'user_id' => 1,
                'order_id' => 1,
                'rating' => 4,
                'review' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining'
            ],[
                'id' => 72,
                'product_id' => 88630137,
                'user_id' => 1,
                'order_id' => 1,
                'rating' => 4,
                'review' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining'
            ],[
                'id' => 73,
                'product_id' => 88630137,
                'user_id' => 1,
                'order_id' => 1,
                'rating' => 4,
                'review' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining'
            ],[
                'id' => 74,
                'product_id' => 88630137,
                'user_id' => 1,
                'order_id' => 1,
                'rating' => 5,
                'review' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining'
            ],[
                'id' => 75,
                'product_id' => 88630137,
                'user_id' => 1,
                'order_id' => 1,
                'rating' => 5,
                'review' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining'
            ],[
                'id' => 76,
                'product_id' => 88630138,
                'user_id' => 1,
                'order_id' => 1,
                'rating' => 4,
                'review' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining'
            ],[
                'id' => 77,
                'product_id' => 88630138,
                'user_id' => 1,
                'order_id' => 1,
                'rating' => 5,
                'review' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining'
            ],[
                'id' => 78,
                'product_id' => 88630138,
                'user_id' => 1,
                'order_id' => 1,
                'rating' => 5,
                'review' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining'
            ],[
                'id' => 79,
                'product_id' => 88630138,
                'user_id' => 1,
                'order_id' => 1,
                'rating' => 5,
                'review' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining'
            ],[
                'id' => 80,
                'product_id' => 88630138,
                'user_id' => 1,
                'order_id' => 1,
                'rating' => 4,
                'review' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining'
            ],[
                'id' => 81,
                'product_id' => 88630139,
                'user_id' => 1,
                'order_id' => 1,
                'rating' => 3,
                'review' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining'
            ],[
                'id' => 82,
                'product_id' => 88630139,
                'user_id' => 1,
                'order_id' => 1,
                'rating' => 4,
                'review' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining'
            ],[
                'id' => 83,
                'product_id' => 88630139,
                'user_id' => 1,
                'order_id' => 1,
                'rating' => 5,
                'review' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining'
            ],[
                'id' => 84,
                'product_id' => 88630139,
                'user_id' => 1,
                'order_id' => 1,
                'rating' => 4,
                'review' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining'
            ],[
                'id' => 85,
                'product_id' => 88630140,
                'user_id' => 1,
                'order_id' => 1,
                'rating' => 2,
                'review' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining'
            ],[
                'id' => 86,
                'product_id' => 88630140,
                'user_id' => 1,
                'order_id' => 1,
                'rating' => 4,
                'review' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining'
            ],[
                'id' => 87,
                'product_id' => 88630140,
                'user_id' => 1,
                'order_id' => 1,
                'rating' => 4,
                'review' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining'
            ],[
                'id' => 88,
                'product_id' => 88630141,
                'user_id' => 1,
                'order_id' => 1,
                'rating' => 5,
                'review' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining'
            ]
            ,[
                'id' => 89,
                'product_id' => 88630141,
                'user_id' => 1,
                'order_id' => 1,
                'rating' => 5,
                'review' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining'
            ],[
                'id' => 90,
                'product_id' => 88630142,
                'user_id' => 1,
                'order_id' => 1,
                'rating' => 3,
                'review' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining'
            ],[
                'id' => 91,
                'product_id' => 88630142,
                'user_id' => 1,
                'order_id' => 1,
                'rating' => 4,
                'review' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining'
            ],[
                'id' => 92,
                'product_id' => 88630143,
                'user_id' => 1,
                'order_id' => 1,
                'rating' => 3,
                'review' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining'
            ],[
                'id' => 93,
                'product_id' => 88630144,
                'user_id' => 1,
                'order_id' => 1,
                'rating' => 4,
                'review' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining'
            ],[
                'id' => 94,
                'product_id' => 88630145,
                'user_id' => 1,
                'order_id' => 1,
                'rating' => 1,
                'review' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining'
            ],[
                'id' => 95,
                'product_id' => 88630145,
                'user_id' => 1,
                'order_id' => 1,
                'rating' => 4,
                'review' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining'
            ],[
                'id' => 96,
                'product_id' => 88630146,
                'user_id' => 1,
                'order_id' => 1,
                'rating' => 5,
                'review' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining'
            ],[
                'id' => 97,
                'product_id' => 88630146,
                'user_id' => 1,
                'order_id' => 1,
                'rating' => 5,
                'review' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining'
            ],[
                'id' => 98,
                'product_id' => 88630146,
                'user_id' => 1,
                'order_id' => 1,
                'rating' => 4,
                'review' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining'
            ],[
                'id' => 99,
                'product_id' => 88630147,
                'user_id' => 1,
                'order_id' => 1,
                'rating' => 4,
                'review' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining'
            ],[
                'id' => 100,
                'product_id' => 88630147,
                'user_id' => 1,
                'order_id' => 1,
                'rating' => 4,
                'review' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining'
            ],[
                'id' => 101,
                'product_id' => 88630147,
                'user_id' => 1,
                'order_id' => 1,
                'rating' => 5,
                'review' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining'
            ],[
                'id' => 102,
                'product_id' => 88630147,
                'user_id' => 1,
                'order_id' => 1,
                'rating' => 5,
                'review' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining'
            ],[
                'id' => 103,
                'product_id' => 88630148,
                'user_id' => 1,
                'order_id' => 1,
                'rating' => 4,
                'review' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining'
            ],[
                'id' => 104,
                'product_id' => 88630148,
                'user_id' => 1,
                'order_id' => 1,
                'rating' => 4,
                'review' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining'
            ],[
                'id' => 105,
                'product_id' => 88630148,
                'user_id' => 1,
                'order_id' => 1,
                'rating' => 4,
                'review' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining'
            ],[
                'id' => 106,
                'product_id' => 88630148,
                'user_id' => 1,
                'order_id' => 1,
                'rating' => 4,
                'review' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining'
            ],[
                'id' => 107,
                'product_id' => 88630148,
                'user_id' => 1,
                'order_id' => 1,
                'rating' => 4,
                'review' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining'
            ],[
                'id' => 108,
                'product_id' => 88630149,
                'user_id' => 1,
                'order_id' => 1,
                'rating' => 4,
                'review' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining'
            ],[
                'id' => 109,
                'product_id' => 88630149,
                'user_id' => 1,
                'order_id' => 1,
                'rating' => 5,
                'review' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining'
            ],[
                'id' => 110,
                'product_id' => 88630149,
                'user_id' => 1,
                'order_id' => 1,
                'rating' => 5,
                'review' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining'
            ],[
                'id' => 111,
                'product_id' => 88630149,
                'user_id' => 1,
                'order_id' => 1,
                'rating' => 4,
                'review' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining'
            ],[
                'id' => 112,
                'product_id' => 88630150,
                'user_id' => 1,
                'order_id' => 1,
                'rating' => 5,
                'review' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining'
            ],[
                'id' => 113,
                'product_id' => 88630150,
                'user_id' => 1,
                'order_id' => 1,
                'rating' => 4,
                'review' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining'
            ],[
                'id' => 114,
                'product_id' => 88630150,
                'user_id' => 1,
                'order_id' => 1,
                'rating' => 4,
                'review' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining'
            ]
        ];


        $product1 = Product::where('id', '88630150')->first();
        $product2 = Product::where('id', '88630149')->first();
        $product3 = Product::where('id', '88630147')->first();
        $product4 = Product::where('id', '88630141')->first();



        if(!RatingReview::first() && $product1 && $product2 && $product3 && $product4){
            foreach ($items as $i) {
                RatingReview::create($i);
            }
        }


    }
}
