<?php

namespace app\store\controller;

use app\store\model\Distributor as DistributorModel;

/**
 * 服务网点管理
 * Class Distributor
 * @package app\store\controller
 */
class Distributor extends Controller
{
    /**
     * 服务网点列表
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function index()
    {
        $model = new DistributorModel;
        $list = $model->getList($this->request->get());
        return $this->fetch('index', compact('list'));
    }

    /**
     * 腾讯地图坐标选取器
     * @return mixed
     */
    public function getpoint()
    {
        $this->view->engine->layout(false);
        return $this->fetch('shop/getpoint');
    }

    /**
     * 添加服务网点
     * @return array|bool|mixed
     * @throws \Exception
     */
    public function add()
    {
        $model = new DistributorModel;
        if (!$this->request->isAjax()) {
            return $this->fetch('add');
        }
        // 新增记录
        if ($model->add($this->postData('distributor'))) {
            return $this->renderSuccess('添加成功', url('distributor/index'));
        }
        return $this->renderError($model->getError() ?: '添加失败');
    }

    /**
     * 编辑服务网点
     * @param $distributor_id
     * @return array|bool|mixed
     * @throws \think\exception\DbException
     */
    public function edit($distributor_id)
    {
        // 服务网点详情
        $model = DistributorModel::detail($distributor_id);
        if (!$this->request->isAjax()) {
            return $this->fetch('edit', compact('model'));
        }
        // 新增记录
        if ($model->edit($this->postData('distributor'))) {
            return $this->renderSuccess('更新成功', url('distributor/index'));
        }
        return $this->renderError($model->getError() ?: '更新失败');
    }

    /**
     * 删除服务网点
     * @param $distributor_id
     * @return array
     * @throws \think\exception\DbException
     */
    public function delete($distributor_id)
    {
        // 服务网点详情
        $model = DistributorModel::detail($distributor_id);
        if (!$model->setDelete()) {
            return $this->renderError($model->getError() ?: '删除失败');
        }
        return $this->renderSuccess('删除成功');
    }

}