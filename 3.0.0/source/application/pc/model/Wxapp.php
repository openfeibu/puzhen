<?php

namespace app\pc\model;

use app\common\model\Wxapp as WxappModel;

/**
 * 微信小程序模型
 * Class Wxapp
 * @package app\api\model
 */
class Wxapp extends WxappModel
{
    /**
     * 隐藏字段
     * @var array
     */
    protected $hidden = [
        'app_name',
        'app_id',
        'app_secret',
        'mchid',
        'apikey',
        'create_time',
        'update_time'
    ];

}
