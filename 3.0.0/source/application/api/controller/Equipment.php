<?php

namespace app\api\controller;

use app\api\model\Equipment as EquipmentModel;

/**
 * 设备控制器
 * Class Equipment
 * @package app\api\controller
 */
class Equipment extends Controller
{
    /**
     * 设备列表
     * @return array
     * @throws \think\exception\DbException
     */
    public function lists()
    {
        $param = $this->request->param();
        $list = EquipmentModel::getAllList($param);
        return $this->renderSuccess(compact('list'));
    }


}
