<?php

namespace app\api\model\distributor;

use app\common\model\distributor\Goods as GoodsModel;
use app\api\service\Goods as GoodsService;
use app\api\model\Category;
use app\common\library\helper;

/**
 * 经销商-商品模型
 * Class Goods
 * @package app\store\model\sharp
 */
class Goods extends GoodsModel
{
    /**
     * 获取商品列表
     * @param $param
     * @param bool $userInfo
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function getList($param, $userInfo = false)
    {
        // 获取商品列表
        $data = parent::getList($param);
        // 隐藏api属性
        !$data->isEmpty() && $data->hidden(['category', 'content', 'image', 'sku','goods']);

        // 整理列表数据并返回
        return $this->setGoodsListDataFromApi($data, true, ['userInfo' => $userInfo]);
    }

    /**
     * 设置商品展示的数据 api模块
     * @param $data
     * @param bool $isMultiple
     * @param array $param
     * @return mixed
     */
    private function setGoodsListDataFromApi(&$data, $isMultiple, $param)
    {
        return parent::setGoodsListData($data, $isMultiple, function ($goods) use ($param) {
            // 计算并设置商品会员价
            $this->setGoodsGradeMoney($param['userInfo'], $goods);
        });
    }

    /**
     * 设置商品的会员价
     * @param $user
     * @param $goods
     */
    private function setGoodsGradeMoney($user, &$goods)
    {
        // 会员等级状态
        $gradeStatus = (!empty($user) && $user['grade_id'] > 0 && !empty($user['grade']))
            && (!$user['grade']['is_delete'] && $user['grade']['status']);
        // 判断商品是否参与会员折扣
        if (!$gradeStatus || !$goods['is_enable_grade']) {
            $goods['is_user_grade'] = false;
            return;
        }
        // 商品单独设置了会员折扣
        if ($goods['is_alone_grade'] && isset($goods['alone_grade_equity'][$user['grade_id']])) {
            // 折扣比例
            $discountRatio = helper::bcdiv($goods['alone_grade_equity'][$user['grade_id']], 10);
        } else {
            // 折扣比例
            $discountRatio = helper::bcdiv($user['grade']['equity']['discount'], 10);
        }
        if ($discountRatio > 0) {
            // 标记参与会员折扣
            $goods['is_user_grade'] = true;
            // 会员折扣价
            foreach ($goods['sku'] as &$skuItem) {
                $skuItem['goods_price'] = helper::number2(helper::bcmul($skuItem['goods_price'], $discountRatio), true);
            }
        }
    }
}