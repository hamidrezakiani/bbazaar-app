<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Google Cloud  configuration
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for Google Cloud
    |
    |
    |
    |
    */

    'project_id' => env('GOOGLE_CLOUD_PROJECT_ID'),
    'storage_bucket' => env('GOOGLE_CLOUD_STORAGE_BUCKET'),
    'path_prefix' => env('GOOGLE_CLOUD_STORAGE_PATH_PREFIX'),
    'gc_key_file' => env('GOOGLE_CLOUD_KEY_FILE'),


];