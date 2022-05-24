<?php

namespace app\factory\service\statistics\data;

use app\common\library\helper;
use app\common\service\Basics as BasicsService;
use app\factory\model\Goods as GoodsModel;
use app\factory\model\TeaQrcode as TeaQrcodeModel;


/**
 * 数据概况
 * Class Survey
 * @package app\store\service\statistics\data
 */
class Survey extends BasicsService
{
    /**
     * 获取数据概况
     * @param $startDate
     * @param $endDate
     * @return array
     * @throws \think\Exception
     */
    public function getSurveyData($startDate = null, $endDate = null)
    {
        return [
            // 用户数量
            // 产品总量
            'goods_total' => $this->getGoodsTotal($startDate, $endDate),
            'factory_tea_qrcode_total' => $this->getFactoryTeaQrcodeTotal($startDate, $endDate),
           // 'user_tea_qrcode_total' => $this->getUserTeaQrcodeTotal($startDate, $endDate),
        ];
    }

    /**
     * 获取产品总量
     * @param null $startDate
     * @param null $endDate
     * @return int|string
     * @throws \think\Exception
     */
    private function getGoodsTotal($startDate = null, $endDate = null)
    {
        $model = new GoodsModel;
        if (!is_null($startDate) && !is_null($endDate)) {
            $model->where('create_time', '>=', strtotime($startDate))
                ->where('create_time', '<', strtotime($endDate) + 86400);
        }
        $value = $model->where('is_delete', '=', 0)->count();
        return number_format($value);
    }


    /**
     * 获取冲泡码数量
     * @param null $startDate
     * @param null $endDate
     * @return string
     * @throws \think\Exception
     */
    private function getFactoryTeaQrcodeTotal($startDate = null, $endDate = null)
    {
        $model = new TeaQrcodeModel;
        if (!is_null($startDate) && !is_null($endDate)) {
            $model->where('create_time', '>=', strtotime($startDate))
                ->where('create_time', '<', strtotime($endDate) + 86400);
        }
        $value = $model->count();
        return number_format($value);
    }

}