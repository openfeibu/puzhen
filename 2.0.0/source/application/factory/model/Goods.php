<?php

namespace app\factory\model;

use app\store\model\Goods as GoodsModel;
use app\store\service\Goods as GoodsService;

/**
 * 产品模型
 * Class Goods
 * @package app\factory\model
 */
class Goods extends GoodsModel
{
    /**
     * 添加产品
     * @param $is_import
     * @param array $data
     * @return bool
     * @throws \think\exception\PDOException
     */
    public function add(array $data, $is_import=0)
    {
        $data['factory_id'] = $data['sku']['factory_id'] = self::$factory_id;
        return parent::add($data, $is_import);
    }
		public function goodsTeaQrcode()
		{
				return $this->hasOne('goods_tea_qrcode');
		}

}
