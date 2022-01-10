<?php

return [

/*
 * Modules .
 */
    'modules'  => ['qrcode'],


/*
 * Views for the page  .
 */
    'views'    => ['default' => 'Default', 'left' => 'Left menu', 'right' => 'Right menu'],

// Modale variables for page module.
    'qrcode'     => [
        'model'        => 'App\Models\QrCode',
        'table'        => 'qrcodes',
        'primaryKey'   => 'id',
        'hidden'       => [],
        'visible'      => [],
        'guarded'      => ['*'],
        //'slugs'        => ['slug' => 'name'],
        'fillable'     => ['user_id','name','image', 'data'],
        'translate'    => [],
        'upload_folder' => '/qrcode',
        'encrypt'      => ['id'],
        'revision'     => ['title'],
        'perPage'      => '20',
        'search'        => [
            'title' => 'like',
            'url'  => 'like',
        ],
        'type' => [
            'weapp','web'
        ]
    ],

];
