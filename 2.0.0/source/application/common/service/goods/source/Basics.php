<?php

namespace app\common\service\goods\source;

/**
 * 商品来源抽象类
 * Class Basics
 * @package app\common\service\stock
 */
abstract class Basics extends \app\common\service\Basics
{
    /**
     * 更新商品库存 (针对下单减库存的商品)
     * @param $goodsList
     * @return mixed
     */
    abstract function updateGoodsStock($goodsList);

    /**
     * 更新商品库存销量（订单付款后）
     * @param $goodsList
     * @return mixed
     */
    abstract function updateStockSales($goodsList);

    /**
     * 回退商品库存
     * @param $goodsList
     * @param $isPayOrder
     * @return mixed
     */
    abstract function backGoodsStock($goodsList, $isPayOrder);

}