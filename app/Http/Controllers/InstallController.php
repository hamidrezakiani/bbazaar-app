<?php

namespace App\Http\Controllers;
use PDO;
use App\Models\Helper\Response;
use App\Models\Helper\Validation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class InstallController extends Controller
{
    public function install()
    {
        Artisan::call('config:clear');
        Artisan::call('route:clear ');
        Artisan::call('cache:clear');
        Artisan::call('view:clear');

        $data = env('SHARED_SERVER_CONFIGURED', false);

        if($data){
            return view('install', ["response" => new Response(null,
                ['configured' => __('lang.already_configured')], 201,
                __('lang.already_configured')), "step" => 3]);
        }  else {
            $res = new Response(null, $data);
        }

        return view('install', [
            "response" => $res,
            "request" => (object)[
                "appUrl" => "",
                "appName" => "",
                "dbName" => "",
                "dbUser" => "",
                "dbPassword" => ""
            ],
            "step" => 1
        ]);
    }


    public function update()
    {
        Artisan::call('config:clear');
        Artisan::call('route:clear ');
        Artisan::call('cache:clear');
        Artisan::call('view:clear');

        return view('update');
    }

    public function readUpdateLog(Request $request)
    {
        try {

            $data = file_get_contents(base_path() . '/update.log');

            return response()->json(new Response($request->token, $data));

        } catch (\Exception $e) {

            return response()->json(Validation::error($request->token, __('lang.update_log_msg')));
        }
    }


    public function updateEnv(Request $request)
    {
        try {
            $envPath = base_path('.env');

            $envFileLines = file($envPath);

            $envData = [];

            foreach ($envFileLines as $line) {
                if(trim($line) != '' && !str_starts_with($line, '#')){
                    // Do something with the line, for example, print it out
                    $parts = explode('=', $line, 2);

                    $key = trim($parts[0]);
                    $value = trim($parts[1]);
                    $envValue = env($key, $value);

                    $envData[$key] = $envValue;
                }
            }


            $envExamplePath = base_path('.env.example');

            $envExampleFileLines = file($envExamplePath);

            $outputData = "";

            foreach ($envExampleFileLines as $line) {
                if(trim($line) != '' && !str_starts_with($line, '#')){
                    // Do something with the line, for example, print it out
                    $parts = explode('=', $line, 2);

                    $key = trim($parts[0]);
                    $value = trim($parts[1]);
                    $envValue = env($key, $value);

                    if(!key_exists($key, $envData)){
                        $outputData .= "\n" . $key . '=' . $envValue . "\n";
                    }
                }
            }


            $envContents = file_get_contents($envPath);
            $envContents .= $outputData;

            file_put_contents($envPath, $envContents);

            return response()->json(new Response($request->token, true));

        } catch (\Exception $e) {

            return response()->json(Validation::error($request->token,$e->getMessage()));
        }
    }



    public function migration(Request $request)
    {
        try {

            Artisan::call('migrate');
            Artisan::call('db:seed');


            Artisan::call('cache:clear');
            Artisan::call('config:clear');
            Artisan::call('route:clear ');
            Artisan::call('view:clear');

            return response()->json(new Response($request->token, true));

        } catch (\Exception $e) {

            DB::table('products')->where('created_at', '0000-00-00 00:00:00')
                ->update(['created_at' => now()]);

            return response()->json(Validation::error($request->token, $e->getMessage()));
        }
    }


    public function createUser(Request $request)
    {
        try {


            $data = env('SHARED_SERVER_CONFIGURED', false);

            if($data) {
                return response()->json(Validation::error($request->token, __('lang.already_configured')));
            }

            // Run passport:install command
            Artisan::call('passport:install');

            $path = base_path('.env');
            if (file_exists($path)) {
                file_put_contents($path, str_replace(
                    'SHARED_SERVER_CONFIGURED=false', 'SHARED_SERVER_CONFIGURED=true', file_get_contents($path)
                ));

                Artisan::call('cache:clear');
                Artisan::call('config:clear');
                Artisan::call('route:clear ');
                Artisan::call('view:clear');
            }


            return response()->json(new Response($request->token, true));

        } catch (\Exception $e) {

            return response()->json(Validation::error($request->token, $e->getMessage()));
        }
    }


    public function freshMigration(Request $request)
    {
        try {


            $data = env('SHARED_SERVER_CONFIGURED', false);

            if($data) {
                return response()->json(Validation::error($request->token, __('lang.already_configured')));
            }

            Artisan::call('config:clear');
            Artisan::call('cache:clear');

            Artisan::call('migrate:fresh');
            Artisan::call('migrate', ['--path' => 'vendor/laravel/passport/database/migrations']);

            Artisan::call('db:seed');
            Artisan::call('cache:clear');
            Artisan::call('config:clear');

            return response()->json(new Response($request->token, true));

        } catch (\Exception $e) {

            return response()->json(Validation::error($request->token, $e->getMessage()));
        }
    }



    public function checkDb(Request $request)
    {


        $data = env('SHARED_SERVER_CONFIGURED', false);

        if($data) {
            return response()->json(Validation::error($request->token, __('lang.already_configured')));
        }

        $validate = Validation::install($request);
        if($validate){
            return response()->json($validate);
        }

        $host = env("DB_HOST");
        $port = env("DB_PORT");
        $dbname =  $request->dbName;
        $username = $request->dbUser;
        $password = $request->dbPassword;

        try {
            DB::connection()->setPdo(new PDO(
                "mysql:host=$host;port=$port;dbname=$dbname",
                $username,
                $password,
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            ))->getPdo();

            return response()->json(new Response($request->token, true));

        } catch (\Exception $e) {

            return response()->json(Validation::error($request->token, __('lang.not_connect')
            ));
        }
    }

    public function installPost(Request $request) {
        try {


            $validate = Validation::install($request);
            if($validate){
                return response()->json($validate);
            }

            $data = env('SHARED_SERVER_CONFIGURED', false);

            if($data) {
                return response()->json(Validation::error($request->token, __('lang.already_configured')));
            }

            $request["appUrl"] = url('/');

            $db = [
                "APP_URL" => "appUrl",
                "APP_NAME" => "appName",
                "CLIENT_BASE_URL" => "appUrl",
                "DB_DATABASE" => "dbName",
                "DB_USERNAME" => "dbUser",
                "DB_PASSWORD" => "dbPassword"
            ];

            $path = base_path('.env');
            if (file_exists($path)) {

                Artisan::call('config:clear');
                Artisan::call('route:clear ');
                Artisan::call('cache:clear');
                Artisan::call('view:clear');

                foreach($db as $key => $value){
                    file_put_contents($path, str_replace(
                        $key . '=' . env($key), $key . '=' . request($value), file_get_contents($path)
                    ));
                }

                Artisan::call('config:clear');
                Artisan::call('route:clear ');
                Artisan::call('cache:clear');
                Artisan::call('view:clear');
            }

            return response()->json(new Response($request->token, true));


        } catch (\Exception $e) {

            return response()->json(Validation::error($request->token, $e->getMessage()));
        }

    }

}
