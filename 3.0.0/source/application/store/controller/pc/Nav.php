<?php

namespace app\store\controller\pc;

use app\store\controller\Controller;
use app\store\model\Nav as NavModel;

/**
 * 工厂用户权限控制器
 * Class Nav
 * @package app\pc\controller
 */
class Nav extends Controller
{
    /**
     * 权限列表
     * @return mixed
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function index()
    {
        $model = new NavModel;
        $list = $model->getList();
        return $this->fetch('index', compact('list'));
    }

    /**
     * 添加权限
     * @return array|mixed
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function add()
    {
        $model = new NavModel;
        if (!$this->request->isAjax()) {
            // 权限列表
            $navList = $model->getList();
            return $this->fetch('add', compact('navList'));
        }
        // 新增记录
        if ($model->add($this->postData('nav'))) {
            return $this->renderSuccess('添加成功', url('pc.nav/index'));
        }
        return $this->renderError($model->getError() ?: '添加失败');
    }

    /**
     * 更新权限
     * @param $nav_id
     * @return array|mixed
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function edit($nav_id)
    {
        // 权限详情
        $model = NavModel::detail($nav_id);
        if (!$this->request->isAjax()) {
            // 权限列表
            $navList = $model->getList();
            return $this->fetch('edit', compact('model', 'navList'));
        }
        // 更新记录
        if ($model->edit($this->postData('nav'))) {
            return $this->renderSuccess('更新成功', url('pc.nav/index'));
        }
        return $this->renderError($model->getError() ?: '更新失败');
    }

    /**
     * 删除权限
     * @param $nav_id
     * @return array
     * @throws \think\exception\DbException
     */
    public function delete($nav_id)
    {
        // 权限详情
        $model = NavModel::detail($nav_id);
        if (!$model->remove()) {
            return $this->renderError($model->getError() ?: '删除失败');
        }
        return $this->renderSuccess('删除成功');
    }

    /**
     * 修改产品状态
     * @param $nav_id
     * @param boolean $state
     * @return array
     */
    public function state($nav_id, $state)
    {
        // 产品详情
        $model = NavModel::detail($nav_id);
        if (!$model->setStatus($state)) {
            return $this->renderError('操作失败');
        }
        return $this->renderSuccess('操作成功');
    }
}
