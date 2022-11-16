<?php

namespace app\pc\model;

use app\common\library\helper;
use app\api\model\Goods as ApiGoodsModel;

/**
 * 产品模型
 * Class Goods
 * @package app\api\model
 */
class Goods extends ApiGoodsModel
{
    public function getRecommend($userInfo)
    {
        $param = [
            'category_id' => 10003,
            'listRows' => '8',
        ];
        return $this->getList($param,$userInfo);

    }

}
