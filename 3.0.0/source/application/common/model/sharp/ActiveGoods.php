<?php

namespace app\common\model\sharp;

use app\common\library\helper;
use app\common\model\BaseModel;
use app\common\model\sharp\Goods as GoodsModel;

/**
 * 整点秒杀-活动会场与产品关联模型
 * Class ActiveGoods
 * @package app\common\model\sharp
 */
class ActiveGoods extends BaseModel
{
    protected $name = 'sharp_active_goods';

    /**
     * 关联活动会场表
     * @return \think\model\relation\BelongsTo
     */
    public function active()
    {
        return $this->belongsTo('Active', 'active_id');
    }

    /**
     * 关联活动会场场次表
     * @return \think\model\relation\BelongsTo
     */
    public function activeTime()
    {
        return $this->belongsTo('ActiveTime', 'active_time_id');
    }

    /**
     * 根据活动场次ID获取产品列表
     * @param int $activeTimeId
     * @param array $goodsParam
     * @return false|\PDOStatement|string|\think\Collection
     */
    public static function getGoodsListByActiveTimeId($activeTimeId, $goodsParam = [])
    {
        // 产品关联列表
        $model = new static;
        $activeGoodsList = $model->getSharpGoodsByActiveTimeId($activeTimeId);
        // 将列表的索引值设置为产品ID
        $activeGoodsList = helper::arrayColumn2Key($activeGoodsList, 'sharp_goods_id');
        // 获取产品列表
        $sharpGoodsList = $model->getGoodsListByIds(array_keys($activeGoodsList), $goodsParam);
        // 整理活动产品信息
        foreach ($sharpGoodsList as &$item) {
            // 活动产品的销量
            $item['sales_actual'] = $activeGoodsList[$item['sharp_goods_id']]['sales_actual'];
            // 产品销售进度
            $item['progress'] = $model->getProgress($item['sales_actual'], $item['seckill_stock']);
        }
        /* @var $sharpGoodsList \think\model\Collection */
        return $sharpGoodsList->hidden(['sku', 'goods']);
    }

    /**
     * 计算产品销售进度
     * @param $value1
     * @param $value2
     * @return mixed
     */
    protected function getProgress($value1, $value2)
    {
        if ($value2 <= 0) return 100;
        $progress = helper::bcdiv($value1, $value2);
        return min(100, (int)helper::bcmul($progress, 100, 0));
    }

    /**
     * 获取秒杀产品模型
     * @return Goods
     */
    protected function getGoodsModel()
    {
        return new GoodsModel;
    }

    /**
     * 根据活动场次ID获取产品集
     * @param $activeTimeId
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    private function getSharpGoodsByActiveTimeId($activeTimeId)
    {
        return $this->where('active_time_id', '=', $activeTimeId)->select();
    }

    /**
     * 根据产品ID集获取产品列表
     * @param array $sharpGoodsIds
     * @param array $param
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    private function getGoodsListByIds($sharpGoodsIds, $param = [])
    {
        return $this->getGoodsModel()->getListByIds($sharpGoodsIds, $param);
    }

}