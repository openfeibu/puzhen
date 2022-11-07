<?php

namespace app\api\model;

use app\common\model\Tea;
use think\Cache;
use app\common\exception\BaseException;
use app\common\model\TeaConfig as TeaConfigModel;

class TeaConfig extends TeaConfigModel
{
    public function getList()
    {
        $list = TeaConfigModel::getAll()->toArray();
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
