<?php

namespace app\store\controller\equipment;

use app\store\controller\Controller;
use app\store\model\Equipment as EquipmentModel;

/**
 * 设备管理
 * Class Equipment
 * @package app\store\controller
 */
class Equipment extends Controller
{
    /**
     * 设备列表
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function index()
    {
        $model = new EquipmentModel;
        $list = $model->getList($this->request->get());
        return $this->fetch('index', compact('list'));
    }

    /**
     * 添加设备
     * @return array|bool|mixed
     * @throws \Exception
     */
    public function add()
    {
        $model = new EquipmentModel;
        if (!$this->request->isAjax()) {
            return $this->fetch('add');
        }
        // 新增记录
        if ($model->add($this->postData('equipment'))) {
            return $this->renderSuccess('添加成功', url('equipment.equipment/index'));
        }
        return $this->renderError($model->getError() ?: '添加失败');
    }

    /**
     * 编辑设备
     * @param $equipment_id
     * @return array|bool|mixed
     * @throws \think\exception\DbException
     */
    public function edit($equipment_id)
    {
        // 设备详情
        $model = EquipmentModel::detail($equipment_id);
        if (!$this->request->isAjax()) {
            return $this->fetch('edit', compact('model'));
        }
        // 新增记录
        if ($model->edit($this->postData('equipment'))) {
            return $this->renderSuccess('更新成功', url('equipment.equipment/index'));
        }
        return $this->renderError($model->getError() ?: '更新失败');
    }

    /**
     * 删除设备
     * @param $equipment_id
     * @return array
     * @throws \think\exception\DbException
     */
    public function delete($equipment_id)
    {
        // 设备详情
        $model = EquipmentModel::detail($equipment_id);
        if (!$model->setDelete()) {
            return $this->renderError($model->getError() ?: '删除失败');
        }
        return $this->renderSuccess('删除成功');
    }


}