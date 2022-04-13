<?php

namespace app\api\model;

use app\common\exception\BaseException;
use app\common\model\Distributor as DistributorModel;

/**
 * 经销商模型
 * Class Distributor
 * @package app\api\model
 */
class Distributor extends DistributorModel
{
    /**
     * 隐藏字段
     * @var array
     */
    protected $hidden = [
        'is_delete',
        'wxapp_id',
        'create_time',
        'update_time'
    ];

}