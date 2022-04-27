<?php

namespace app\api\model;

use app\common\exception\BaseException;
use app\common\model\Equipment as EquipmentModel;

/**
 * 经销商模型
 * Class Equipment
 * @package app\api\model
 */
class Equipment extends EquipmentModel
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