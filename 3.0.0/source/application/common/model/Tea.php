<?php

namespace app\common\model;

use think\Db;


class Tea extends BaseModel
{
    protected $name = 'tea';
    protected $updateTime = false;
    protected static $is_factory = 0;
  
    public static function getTeaName($tea)
    {
        return self::where('code',$tea)->value('name','未知');
    }
    public static function getAll()
    {
        return self::order('code','asc')->select();
    }
    public static function detail($tea_id)
    {
        return static::get($tea_id);
    }
}