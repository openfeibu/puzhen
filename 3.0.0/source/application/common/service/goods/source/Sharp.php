<?php

namespace app\common\service\goods\source;

use app\api\model\sharp\Goods as SharpGoodsModel;
use app\api\model\sharp\GoodsSku as GoodsSkuModel;
use app\common\enum\goods\DeductStockType as DeductStockTypeEnum;

/**
 * 产品来源-秒杀产品扩展类
 * Class Sharp
 * @package app\common\service\stock
 */
class Sharp extends Basics
{
    /**
     * 更新产品库存 (针对下单减库存的产品)
     * @param $goodsList
     * @return bool|mixed
     * @throws \Exception
     */
    public function updateGoodsStock($goodsList)
    {
        $goodsData = [];
        $goodsSkuData = [];
        foreach ($goodsList as $goods) {
            // 下单减库存
            if ($goods['deduct_stock_type'] == 10) {
                // 记录产品总库存
                $goodsData[] = [
                    'sharp_goods_id' => $goods['sharp_goods_id'],
                    'seckill_stock' => ['dec', $goods['total_num']]
                ];
                // 记录产品sku库存
                $goodsSkuData[] = [
                    'data' => ['seckill_stock' => ['dec', $goods['total_num']]],
                    'where' => [
                        'sharp_goods_id' => $goods['sharp_goods_id'],
                        'spec_sku_id' => $goods['spec_sku_id'],
                    ],
                ];
            }
        }
        // 更新产品总销量
        !empty($goodsData) && $this->updateGoods($goodsData);
        return !empty($goodsSkuData) && $this->updateGoodsSku($goodsSkuData);
    }

    /**
     * 更新产品库存销量（订单付款后）
     * @param $goodsList
     * @return bool
     * @throws \Exception
     */
    public function updateStockSales($goodsList)
    {
        $goodsData = [];
        $goodsSkuData = [];
        foreach ($goodsList as $goods) {
            // 产品id
            $sharpGoodsId = $goods['goods_source_id'];
            // 记录产品总销量
            $goodsItem = [
                'sharp_goods_id' => $sharpGoodsId,
                'total_sales' => ['inc', $goods['total_num']]
            ];
            // 付款减库存
            if ($goods['deduct_stock_type'] == 20) {
                // 记录产品总库存
                $goodsItem['seckill_stock'] = ['dec', $goods['total_num']];
                // 记录产品sku库存
                $goodsSkuData[] = [
                    'data' => ['seckill_stock' => ['dec', $goods['total_num']]],
                    'where' => [
                        'sharp_goods_id' => $sharpGoodsId,
                        'spec_sku_id' => $goods['spec_sku_id'],
                    ],
                ];
            }
            $goodsData[] = $goodsItem;
        }
        // 更新产品库存销量
        !empty($goodsData) && $this->updateGoods(array_values($goodsData));
        return !empty($goodsSkuData) && $this->updateGoodsSku($goodsSkuData);
    }

    /**
     * 回退产品库存
     * @param $goodsList
     * @param $isPayOrder
     * @return array|false
     * @throws \Exception
     */
    public function backGoodsStock($goodsList, $isPayOrder = false)
    {
        $goodsData = [];
        $goodsSkuData = [];
        foreach ($goodsList as $goods) {
            // 产品id
            $sharpGoodsId = $goods['goods_source_id'];
            $goodsItem = [
                'sharp_goods_id' => $sharpGoodsId,
                'seckill_stock' => ['inc', $goods['total_num']]
            ];
            $goodsSkuItem = [
                'where' => [
                    'sharp_goods_id' => $sharpGoodsId,
                    'spec_sku_id' => $goods['spec_sku_id'],
                ],
                'data' => ['seckill_stock' => ['inc', $goods['total_num']]],
            ];
            // 付款订单全部库存
            if ($isPayOrder == true) {
                $goodsData[] = $goodsItem;
                $goodsSkuData[] = $goodsSkuItem;
            }
            // 未付款订单，判断必须为下单减库存时才回退
            if ($isPayOrder == false
                && $goods['deduct_stock_type'] == DeductStockTypeEnum::CREATE) {
                $goodsData[] = $goodsItem;
                $goodsSkuData[] = $goodsSkuItem;
            }
        }
        // 更新产品总库存
        !empty($goodsData) && $this->updateGoods($goodsData);
        // 更新产品sku库存
        return !empty($goodsSkuData) && $this->updateGoodsSku($goodsSkuData);
    }

    /**
     * 更新产品信息
     * @param $data
     * @return array|false
     * @throws \Exception
     */
    private function updateGoods($data)
    {
        return (new SharpGoodsModel)->allowField(true)->isUpdate()->saveAll($data);
    }

    /**
     * 更新产品sku信息
     * @param $data
     * @return \think\Collection
     */
    private function updateGoodsSku($data)
    {
        return (new GoodsSkuModel)->updateAll($data);
    }

}