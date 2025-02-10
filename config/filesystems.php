<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */

    'default' => env('FILESYSTEM_DISK', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been set up for each driver as an example of the required values.
    |
    | Supported Drivers: "local", "ftp", "sftp", "s3"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
            'throw' => false,
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL') . '/storage',
            'visibility' => 'public',
            'throw' => false,
        ],

        'snapshots' => [
            'driver' => 'local',
            'root' => database_path('snapshots'),
        ],

        'media' => [
            'driver' => 'local',
            'root'   => public_path('media'),
            'url'    => env('APP_URL') . '/media',
        ],
        'signatures' => [
            'driver' => 'local',
            'root'   => public_path('signatures'),
            'url'    => env('APP_URL') . '/signatures',
        ],
        'profile_photos' => [
            'driver' => 'local',
            'root'   => public_path('profile_photo'),
            'url'    => env('APP_URL') . '/profile_photo',
        ],
        'proof_of_release' => [
            'driver' => 'local',
            'root'   => public_path('proof_of_release'),
            'url'    => env('APP_URL') . '/proof_of_release',
        ],
        'rsbsa_two_by_two' => [
            'driver' => 'local',
            'root'   => public_path('rsbsa_two_by_two'),
            'url'    => env('APP_URL') . '/rsbsa_two_by_two',
        ],
        'documents' => [
            'driver' => 'local',
            'root'   => public_path('documents'),
            'url'    => env('APP_URL') . '/documents',
        ],
        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
            'throw' => false,
        ],

        'temp' => [
            'driver' => 'local',
            'root' => storage_path('app/livewire-tmp'),
            'throw' => false,
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    |
    | Here you may configure the symbolic links that will be created when the
    | `storage:link` Artisan command is executed. The array keys should be
    | the locations of the links and the values should be their targets.
    |
    */

    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],

];
