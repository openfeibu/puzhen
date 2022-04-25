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
}