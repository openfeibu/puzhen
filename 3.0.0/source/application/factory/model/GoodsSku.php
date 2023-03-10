<?php

namespace app\factory\model;

use app\common\model\GoodsSku as GoodsSkuModel;

/**
 * 产品规格模型
 * Class GoodsSku
 * @package app\factory\model
 */
class GoodsSku extends GoodsSkuModel
{
    /**
     * 批量添加产品sku记录
     * @param $goods_id
     * @param $spec_list
     * @return array|false
     * @throws \Exception
     */
    public function addSkuList($goods_id, $spec_list)
    {
        $data = [];
        foreach ($spec_list as $item) {
            $data[] = array_merge($item['form'], [
                'spec_sku_id' => $item['spec_sku_id'],
                'goods_id' => $goods_id,
                'wxapp_id' => self::$wxapp_id,
            ]);
        }
        return $this->allowField(true)->saveAll($data);
    }

    /**
     * 添加产品规格关系记录
     * @param $goods_id
     * @param $spec_attr
     * @return array|false
     * @throws \Exception
     */
    public function addGoodsSpecRel($goods_id, $spec_attr)
    {
        $data = [];
        array_map(function ($val) use (&$data, $goods_id) {
            array_map(function ($item) use (&$val, &$data, $goods_id) {
                $data[] = [
                    'goods_id' => $goods_id,
                    'spec_id' => $val['group_id'],
                    'spec_value_id' => $item['item_id'],
                    'wxapp_id' => self::$wxapp_id,
                ];
            }, $val['spec_items']);
        }, $spec_attr);
        $model = new GoodsSpecRel;
        return $model->saveAll($data);
    }

    /**
     * 移除指定产品的所有sku
     * @param $goods_id
     * @return int
     */
    public function removeAll($goods_id)
    {
        $model = new GoodsSpecRel;
        $model->where('goods_id','=', $goods_id)->delete();
        return $this->where('goods_id','=', $goods_id)->delete();
    }

}
