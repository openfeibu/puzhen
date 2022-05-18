<?php

namespace app\factory\model;

use app\store\model\Goods as GoodsModel;
use app\store\service\Goods as GoodsService;

/**
 * 商品模型
 * Class Goods
 * @package app\store\model
 */
class Goods extends GoodsModel
{
    /**
     * 添加商品
     * @param array $data
     * @return bool
     * @throws \think\exception\PDOException
     */
    public function add(array $data)
    {
        $data['factory_id'] = $data['sku']['factory_id'] = self::$factory_id;
        return $this->add($data);
    }


}
