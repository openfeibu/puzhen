<?php

namespace app\factory\model;

use app\common\library\helper;
use app\common\model\Factory as FactoryModel;

/**
 * 商城模型
 * Class Store
 * @package app\store\model
 */
class Factory extends FactoryModel
{
    /* @var Goods $GoodsModel */
    private $GoodsModel;

    /**
     * 构造方法
     */
    public function initialize()
    {
        parent::initialize();
        /* 初始化模型 */
        $this->GoodsModel = new Goods;
    }

    /**
     * 后台首页数据
     * @return array
     * @throws \think\Exception
     */
    public function getHomeData()
    {
        $today = date('Y-m-d');
        $yesterday = date('Y-m-d', strtotime('-1 day'));
        // 最近七天日期
        $lately7days = $this->getLately7days();
        $data = [
            'widget-card' => [
                // 商品总量
                'goods_total' => $this->getGoodsTotal(),

            ],
        ];


        return $data;
    }

    /**
     * 最近七天日期
     */
    private function getLately7days()
    {
        // 获取当前周几
        $date = [];
        for ($i = 0; $i < 7; $i++) {
            $date[] = date('Y-m-d', strtotime('-' . $i . ' days'));
        }
        return array_reverse($date);
    }

    /**
     * 获取商品总量
     * @return string
     * @throws \think\Exception
     */
    private function getGoodsTotal()
    {
        return number_format($this->GoodsModel->getGoodsTotal());
    }


}