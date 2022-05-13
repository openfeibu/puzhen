<?php

namespace app\store\controller\data;

use app\store\controller\Controller;
use app\store\model\Equipment as EquipmentModel;
use app\store\model\user\Grade as GradeModel;

/**
 * 用户数据控制器
 * Class Equipment
 * @package app\store\controller\data
 */
class Equipment extends Controller
{
    /* @var \app\store\model\Equipment $model */
    private $model;

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
        $this->model = new EquipmentModel;
        $this->view->engine->layout(false);
    }

    /**
     * 设备列表
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function lists()
    {
        // 设备列表
        $list = $this->model->getList();
        return $this->fetch('list', compact('list'));
    }

}