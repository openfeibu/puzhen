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
        'fillable'     => ['user_id','name','image','detail_image', 'data'],
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
        ],
        'tea' => [
            'A' => '绿茶',
            'B' => '红茶',
            'C' => '黑茶',
            'D' => '白茶',
            'E' => '乌龙茶',
            'F' => '生洱',
            'G' => '花茶',
            'H' => '黄茶',
        ],
    ],

];
