<?php

namespace app\pc\model;

use app\common\model\Banner as BannerModel;


/**
 * 轮播图模型
 * Class Banner
 * @package app\common\model
 */
class Banner extends BannerModel
{
    /**
     * 隐藏字段
     * @var array
     */
    protected $hidden = [
        'wxapp_id',
        'create_time',
        'update_time'
    ];


}