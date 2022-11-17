<?php

namespace app\store\model;

use think\Db;
use app\common\model\TeaConfig as TeaConfigModel;
/**
 * 茶配置模型
 * Class Comment
 * @package app\common\model
 */
class TeaConfig extends TeaConfigModel
{

    public function edit($data): bool
    {
        foreach ($data['configs'] as $key => $val)
        {
            $this->where('type',$val)->update($data[$val]);
        }
        return true;
    }
}