<?php

namespace app\factory\controller\statistics;

use app\factory\controller\Controller;
use app\factory\service\statistics\Data as StatisticsDataService;

/**
 * 数据概况
 * Class Data
 * @package app\store\controller\statistics
 */
class Data extends Controller
{
    /* @var $statisticsDataService StatisticsDataService 数据概况服务类 */
    private $statisticsDataService;

    /**
     * 构造方法
     * @throws \app\common\exception\BaseException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function _initialize()
    {
        parent::_initialize();
        $this->statisticsDataService = new StatisticsDataService;
    }

    /**
     * 数据统计主页
     * @return mixed
     * @throws \think\Exception
     */
    public function index()
    {
        return $this->fetch('index', [
            // 数据概况
            'survey' => $this->statisticsDataService->getSurveyData(),
        ]);
    }

    /**
     * 数据概况API
     * @param null $startDate
     * @param null $endDate
     * @return array
     * @throws \think\Exception
     */
    public function survey($startDate = null, $endDate = null)
    {
        return $this->renderSuccess('', '',
            $this->statisticsDataService->getSurveyData($startDate, $endDate));
    }

}