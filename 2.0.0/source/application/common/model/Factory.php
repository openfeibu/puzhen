<?php

namespace app\common\model;

/**
 * 工厂模型
 * Class Factory
 * @package app\common\model
 */
class Factory extends BaseModel
{
    protected $name = 'factory';

    public static function detail($factory_id)
    {
        return static::get($factory_id);
    }
    public function getFactoryNameAttr($value, $data)
    {
        if($data['status'] == 0)
        {
            return $value."(禁用)";
        }
        return $value;
    }
}