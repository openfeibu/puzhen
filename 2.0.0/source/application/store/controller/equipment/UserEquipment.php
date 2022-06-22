<?php

namespace app\store\controller\equipment;

use app\store\controller\Controller;
use app\store\model\Equipment as EquipmentModel;
use app\store\model\UserEquipment as UserEquipmentModel;
use app\store\model\Setting as SettingModel;

/**
 * 用户设备管理
 * Class Equipment
 * @package app\store\controller
 */
class UserEquipment extends Controller
{
    /**
     * 审核列表
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function apply_list()
    {
       return $this->getList('待审核列表','10');
    }
    /**
     * 通过列表
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function audited_list()
    {
        return $this->getList('已通过列表','20');
    }
    /**
     * 订单导出
     * @throws \think\exception\DbException
     */
    public function export()
    {
        $model = new UserEquipmentModel;
        return $model->exportList('20');
    }
    /**
     * 拒绝列表
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function rejected_list()
    {
        return $this->getList('未通过列表','30');
    }
    /**
     * 订单列表
     * @param string $title
     * @param string $status
     * @return mixed
     * @throws \think\exception\DbException
     */
    private function getList($title, $status)
    {
        // 订单列表
        $model = new UserEquipmentModel;
        $list = $model->getList($status, $this->request->param());

        return $this->fetch('index', compact('title', 'status', 'list'));
    }

    /**
     * 添加设备
     * @return array|bool|mixed
     * @throws \Exception
     */
    public function add()
    {
        $model = new UserEquipmentModel;
        if (!$this->request->isAjax()) {
            $warranty_setting = SettingModel::getItem('warranty');
            return $this->fetch('add',compact('warranty_setting'));
        }
        // 新增记录
        if ($model->add($this->postData('user_equipment'))) {
            return $this->renderSuccess('添加成功', url('equipment.user_equipment/audited_list'));
        }
        return $this->renderError($model->getError() ?: '添加失败');
    }

    /**
     * 编辑设备
     * @param $user_equipment_id
     * @return array|bool|mixed
     * @throws \think\exception\DbException
     */
    public function edit($user_equipment_id)
    {
        // 设备详情
        $model = UserEquipmentModel::detail(['user_equipment_id' => $user_equipment_id]);
        if (!$this->request->isAjax()) {
            $warranty_setting = SettingModel::getItem('warranty');
            return $this->fetch('edit', compact('model','warranty_setting'));
        }
        // 新增记录
        if ($model->edit($this->postData('equipment'))) {
            return $this->renderSuccess('更新成功', url('equipment.user_equipment/audited_list'));
        }
        return $this->renderError($model->getError() ?: '更新失败');
    }

    public function audit($user_equipment_id)
    {
        if (!$this->request->isAjax()) {
            return false;
        }
        $model = UserEquipmentModel::detail(['user_equipment_id' => $user_equipment_id]);
        if ($model->audit($this->postData('user_equipment'))) {
            return $this->renderSuccess('操作成功');
        }
        return $this->renderError($model->getError() ?: '操作失败');
    }
    /**
     * 删除设备
     * @param $user_equipment_id
     * @return array
     * @throws \think\exception\DbException
     */
    public function delete($user_equipment_id)
    {
        if(is_array($user_equipment_id))
        {
            $model = new UserEquipmentModel;
            $rst = $model->batchRemove($user_equipment_id);
            if (!$rst['status']) {
                return $this->renderError($rst['message'] ?: '删除失败');
            }
            return $this->renderSuccess($rst['message'] ?: '删除成功');
        }else {
            // 设备详情
            $model = UserEquipmentModel::detail(['user_equipment_id' => $user_equipment_id]);
            if (!$model->delete()) {
                return $this->renderError($model->getError() ?: '删除失败');
            }
            return $this->renderSuccess('删除成功');
        }
    }


}