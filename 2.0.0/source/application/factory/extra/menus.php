<?php
/**
 * 后台菜单配置
 *    'home' => [
 *       'name' => '首页',                // 菜单名称
 *       'icon' => 'icon-home',          // 图标 (class)
 *       'index' => 'index/index',         // 链接
 *     ],
 */
return [
    'index' => [
        'name' => '首页',
        'icon' => 'icon-home',
        'index' => 'index/index',
    ],
    'factory' => [
        'name' => '管理员',
        'icon' => 'icon-guanliyuan',
        'index' => 'factory.user/index',
        'submenu' => [
            [
                'name' => '管理员列表',
                'index' => 'factory.user/index',
                'uris' => [
                    'factory.user/index',
                    'factory.user/add',
                    'factory.user/edit',
                    'factory.user/delete',
                ],
            ],
            [
                'name' => '角色管理',
                'index' => 'factory.role/index',
                'uris' => [
                    'factory.role/index',
                    'factory.role/add',
                    'factory.role/edit',
                    'factory.role/delete',
                ],
            ],
        ]
    ],
    'goods' => [
        'name' => '产品管理',
        'icon' => 'icon-goods',
        'index' => 'goods/index',
        'submenu' => [
            [
                'name' => '产品列表',
                'index' => 'goods/index',
                'uris' => [
                    'goods/index',
                    'goods/add',
                    'goods/edit',
                    'goods/copy'
                ],
            ],
        ],
    ],
    'tea_qrcode' => [
        'name' => '冲泡码管理',
        'icon' => 'am-icon-qrcode',
        'index' => 'tea_qrcode.factory_tea_qrcode/index',
        'submenu' => [
            [
                'name' => '工厂冲泡码',
                'active' => true,
                'index' => 'tea_qrcode.factory_tea_qrcode/index',
                'submenu' => [
                    [
                        'name' => '冲泡码列表',
                        'index' => 'tea_qrcode.factory_tea_qrcode/index',
                        'uris' => [
                            'tea_qrcode.factory_tea_qrcode/index',
                            'tea_qrcode.factory_tea_qrcode/add',
                            'tea_qrcode.factory_tea_qrcode/edit',
                        ]
                    ],
                ]
            ],
        ]
    ],
];
