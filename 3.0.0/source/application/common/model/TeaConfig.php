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
    public function getList()
    {
        $list = self::getAll()->toArray();
        $data = [];
        foreach ($list as $key => $item)
        {
            $data[$item['type']] = $item;
            $data[$item['type']]['data'] = [];
            $arr = [];
            for($i = (float)$item['min']; $i <= (float)$item['max']; $i=$i+(float)$item['interval'])
            {
                $arr['name'] = $i.$item['unit'];
                $arr['value'] = $i;
                $data[$item['type']]['data'][] = $arr;
            }

        }
        return $data;
    }
}