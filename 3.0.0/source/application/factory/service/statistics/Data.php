<?php

namespace app\factory\service\statistics;

use app\common\service\Basics;
use app\factory\service\statistics\data\Survey;


/**
 * 数据概况服务类
 * Class Data
 * @package app\store\service\statistics
 */
class Data extends Basics
{
    /**
     * 获取数据概况
     * @param null $startDate
     * @param null $endDate
     * @return array
     * @throws \think\Exception
     */
    public function getSurveyData($startDate = null, $endDate = null)
    {
        return (new Survey)->getSurveyData($startDate, $endDate);
    }



}