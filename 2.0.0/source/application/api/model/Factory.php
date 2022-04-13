<?php

namespace app\api\model;

use app\common\exception\BaseException;
use app\common\model\Factory as FactoryModel;

/**
 * 工厂模型
 * Class Factory
 * @package app\api\model
 */
class Factory extends FactoryModel
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