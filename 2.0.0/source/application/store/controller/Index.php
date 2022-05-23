<?php

namespace app\store\controller;

use app\store\model\Store as StoreModel;
use app\store\service\statistics\Data as StatisticsDataService;
/**
 * 后台首页
 * Class Index
 * @package app\store\controller
 */
class Index extends Controller
{
    public function _initialize()
    {
        parent::_initialize();
        $this->statisticsDataService = new StatisticsDataService;
    }
    /**
     * 后台首页
     * @return mixed
     * @throws \think\Exception
     * @throws \think\exception\DbException
     */
    public function index()
    {
        // 当前用户菜单url
        $menus = $this->menus();
        $url = current(array_values($menus))['index'];
        if ($url !== 'index/index') {
            $this->redirect($url);
        }
        return $this->fetch('index', [
            // 数据概况
            'survey' => $this->statisticsDataService->getSurveyData(),
            // 近七日交易走势
            //'echarts7days' => $this->statisticsDataService->getTransactionTrend(),
            // 商品销售榜
            //'goodsRanking' => $this->statisticsDataService->getGoodsRanking(),
            // 用户消费榜
            //'userExpendRanking' => $this->statisticsDataService->geUserExpendRanking(),
        ]);
        /*
        $model = new StoreModel;

        return $this->fetch('index', ['data' => $model->getHomeData()]);
        */
    }

}
