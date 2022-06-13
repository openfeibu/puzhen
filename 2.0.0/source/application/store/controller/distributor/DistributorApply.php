<?php

namespace app\store\controller\Distributor;

use app\store\controller\Controller;
use app\store\model\DistributorApply as DistributorApplyModel;

/**
 * 服务网点申请申请管理
 * Class DistributorApply
 * @package app\store\controller
 */
class DistributorApply extends Controller
{
    /**
     * 服务网点申请列表
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function index()
    {
        $model = new DistributorApplyModel;
        $list = $model->getList($this->request->get());
        return $this->fetch('index', compact('list'));
    }

    public function edit($apply_id)
    {
        // 服务网点申请详情
        $model = DistributorApplyModel::detail($apply_id);
        if (!$this->request->isAjax()) {
            return $this->fetch('edit', compact('model'));
        }
        // 新增记录
        if ($model->edit($this->postData('distributor'))) {
            return $this->renderSuccess('更新成功', url('distributor.distributor_apply/index'));
        }
        return $this->renderError($model->getError() ?: '更新失败');
    }

    /**
     * 删除服务网点申请
     * @param $apply_id
     * @return array
     * @throws \think\exception\DbException
     */
    public function delete($apply_id)
    {
        // 服务网点申请详情
        $model = DistributorApplyModel::detail($apply_id);
        if (!$model->delete()) {
            return $this->renderError($model->getError() ?: '删除失败');
        }
        return $this->renderSuccess('删除成功');
    }

}