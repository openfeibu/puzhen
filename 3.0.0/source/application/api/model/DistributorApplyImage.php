<?php

namespace app\api\model;

use app\common\model\DistributorApplyImage as DistributorApplyImageModel;

/**
 * 图片模型
 * Class GoodsImage
 * @package app\api\model
 */
class DistributorApplyImage extends DistributorApplyImageModel
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
