<?php

namespace app\api\controller;

use app\api\model\Tea as TeaModel;
use app\api\model\TeaConfig as TeaConfigModel;

class Tea extends Controller
{
    /* @var \app\api\model\Tea $model */
    private $model;

	/* @var \app\api\model\TeaConfig $tea_config_model */
	private $tea_config_model;

    /**
     * 构造方法
     * @throws \app\common\exception\BaseException
     * @throws \think\exception\DbException
     */
    public function _initialize()
    {
        parent::_initialize();
        $this->model = new TeaModel;
	    $this->tea_config_model = new TeaConfigModel;
    }
    /**
     * 列表
     * @return array
     * @throws \think\exception\DbException
     */
    public function lists()
    {
        $list = TeaModel::getAll();
        return $this->renderSuccess(compact('list'));
    }

    public function config()
    {
	    $list = $this->tea_config_model->getList();
	    return $this->renderSuccess(compact('list'));
    }

	
}