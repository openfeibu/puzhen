<?php

namespace app\store\model\sharp;

use app\common\model\sharp\GoodsSku as GoodsSkuModel;

/**
 * 整点秒杀-秒杀产品sku模型
 * Class Goods
 * @package app\store\model\sharp
 */
class GoodsSku extends GoodsSkuModel
{
    /**
     * 批量添加产品sku记录
     * @param $sharpGoodsId
     * @param $specList
     * @return array|false
     * @throws \Exception
     */
    public function addSkuList($sharpGoodsId, $specList)
    {
        $data = [];
        foreach ($specList as $item) {
            $data[] = array_merge($item['form'], [
                'spec_sku_id' => $item['spec_sku_id'],
                'sharp_goods_id' => $sharpGoodsId,
                'wxapp_id' => self::$wxapp_id,
            ]);
        }
        return $this->allowField(true)->saveAll($data);
    }

    /**
     * 移除指定产品的所有sku
     * @param $sharpGoodsId
     * @return int
     */
    public function removeAll($sharpGoodsId)
    {
        return $this->where('sharp_goods_id', '=', $sharpGoodsId)->delete();
    }

}