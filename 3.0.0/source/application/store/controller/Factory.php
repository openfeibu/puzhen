<?php

namespace app\store\controller;

use app\store\model\Factory as FactoryModel;
use app\store\model\factory\User as FactoryUserModel;

/**
 * 工厂管理
 * Class Factory
 * @package app\store\controller
 */
class Factory extends Controller
{
    /**
     * 工厂列表
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function index()
    {
        $model = new FactoryModel;
        $list = $model->getList($this->request->get());
        return $this->fetch('index', compact('list'));
    }

    /**
     * 添加工厂
     * @return array|bool|mixed
     * @throws \Exception
     */
    public function add()
    {
        $model = new FactoryModel;
        if (!$this->request->isAjax()) {
            return $this->fetch('add');
        }
        // 新增记录
        if ($model->add($this->postData('factory'))) {
            return $this->renderSuccess('添加成功', url('factory/index'));
        }
        return $this->renderError($model->getError() ?: '添加失败');
    }

    /**
     * 编辑工厂
     * @param $factory_id
     * @return array|bool|mixed
     * @throws \think\exception\DbException
     */
    public function edit($factory_id)
    {
        // 工厂详情
        $model = FactoryModel::detail($factory_id);
        if (!$this->request->isAjax()) {
            return $this->fetch('edit', compact('model'));
        }
        // 新增记录
        if ($model->edit($this->postData('factory'))) {
            return $this->renderSuccess('更新成功', url('factory/index'));
        }
        return $this->renderError($model->getError() ?: '更新失败');
    }

    /**
     * 删除工厂
     * @param $factory_id
     * @return array
     * @throws \think\exception\DbException
     */
    public function delete($factory_id)
    {
        // 工厂详情
        $model = FactoryModel::detail($factory_id);
        if (!$model->setDelete()) {
            return $this->renderError($model->getError() ?: '删除失败');
        }
        return $this->renderSuccess('删除成功');
    }
    /**
     * 进入工厂
     * @param $factory_id
     * @throws \think\Exception
     * @throws \think\exception\DbException
     */
    public function enter($factory_id)
    {
        $model = new FactoryUserModel;
        $model->login($factory_id);
        $this->redirect('factory/index/index');
    }
}