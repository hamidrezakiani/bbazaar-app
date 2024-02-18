<?php

use App\Models\Helper\Response;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InstallController;
use \Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => 'web'], function () {
    Route::get('install', [InstallController::class, 'install']);
    Route::get('update', [InstallController::class, 'update']);



    Route::get('{any}', function (\Illuminate\Http\Request $request) {


        if($request->expectsJson())
        {
            return response()->json([
                'message' => 'file not found!'
            ],404);
        }
        // Only for Laravel frontend. Should be removed in docker
        // if(str_contains(\Illuminate\Support\Facades\URL::current(), 'admin')){
        //  return view('admin');
        //  }

        return view('welcome');
    })->where('any', '.*');

});


/*
Route::get('/user-registration', function (\Illuminate\Http\Request $request) {
    $objDemo = new \stdClass();
    $objDemo->receiver = "John";
    $objDemo->code = "123";
    $objDemo->store_name = "Address";
    $objDemo->address = "Address";
    $objDemo->phone = "ww";

    return view('mail_templates.user_registration', ['data' => $objDemo]);
});
Route::get('/subscription', function (\Illuminate\Http\Request $request) {
    $body = "<h1>Test</h1>";
    $setting = \App\Models\Setting::get()->first();

    return view('mail_templates.subscription', [
        "body" => $body,
        "setting" => $setting
    ]);
});
Route::get('/package-delivered', function (\Illuminate\Http\Request $request) {
    $mailData = \App\Models\Helper\MailHelper::sendingOrderEmail($request, 1);
    if(is_null($mailData)){
        response()->json(\App\Models\Helper\Validation::error($request->token, 'Invalid.'));
    }
    return view('mail_templates.package_delivered', $mailData);
});
Route::get('/order-placed', function (\Illuminate\Http\Request $request) {
    $mailData = \App\Models\Helper\MailHelper::sendingOrderEmail($request, 1);
    if(is_null($mailData)){
        response()->json(\App\Models\Helper\Validation::error($request->token, 'Invalid.'));
    }
    return view('mail_templates.order_placed', $mailData);
});

Route::get('/order', function (\Illuminate\Http\Request $request) {
    $mailData = \App\Models\Helper\MailHelper::sendingOrderEmail($request, 1);
    if(is_null($mailData)){
        response()->json(\App\Models\Helper\Validation::error($request->token, 'Invalid.'));
    }
    return view('mail_templates.order_pdf', $mailData);
});
Route::get('forgot', function (){
    $objDemo = new \stdClass();
    $objDemo->receiver = "John";
    $objDemo->code = "123";
    $objDemo->store_name = "Address";
    $objDemo->address = "Address";
    $objDemo->phone = "ww";

    return view('mail_templates.forgot_password', ['data' => $objDemo]
    );
});

Route::get('{any}', function () {

   if(!env('SHARED_SERVER_CONFIGURED', false)){
        return redirect("/install");
    }

    if(str_contains(\Illuminate\Support\Facades\URL::current(), 'admin')){
        return view('admin');
    }

    return view('welcome');
})->where('any', '.*');

*/


