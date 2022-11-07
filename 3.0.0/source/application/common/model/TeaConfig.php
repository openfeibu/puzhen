<?php

namespace app\common\model;

use think\Db;

class TeaConfig extends BaseModel
{
    protected $name = 'tea_config';
    protected $updateTime = false;
    protected static $is_factory = 0;
  
    public static function getAll()
    {
        return self::order('tea_config_id','asc')->select();
    }

}