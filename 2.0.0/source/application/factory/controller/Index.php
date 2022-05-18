<?php

namespace app\factory\controller;

use app\factory\model\Factory as FactoryModel;

/**
 * 后台首页
 * Class Index
 * @package app\factory\controller
 */
class Index extends Controller
{
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
        $model = new FactoryModel;
        return $this->fetch('index', ['data' => $model->getHomeData()]);
    }

}
