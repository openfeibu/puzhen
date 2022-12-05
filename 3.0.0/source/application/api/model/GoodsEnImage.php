<?php

namespace app\api\model;

use app\common\model\GoodsEnImage as GoodsEnImageModel;

/**
 * 产品图片模型
 * Class GoodsImage
 * @package app\api\model
 */
class GoodsEnImage extends GoodsEnImageModel
{
    /**
     * 隐藏字段
     * @var array
     */
    protected $hidden = [
        'wxapp_id',
        'create_time',
    ];

}
