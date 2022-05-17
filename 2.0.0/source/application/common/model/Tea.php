<?php

namespace app\common\model;

use think\Db;

/**
 * 商品评价模型
 * Class Comment
 * @package app\common\model
 */
class Tea extends BaseModel
{
    protected $name = 'tea';
    protected $updateTime = false;

    public static function getTeaName($tea)
    {
        return self::where('code',$tea)->value('name','未知');
    }
    public static function getAll()
    {
        return self::order('code','asc')->select();
    }
}