<?php

namespace app\admin\controller\factory;

use app\admin\controller\Controller;
use app\admin\model\factory\Access as AccessModel;

/**
 * 工厂用户权限控制器
 * Class Access
 * @package app\factory\controller
 */
class Access extends Controller
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
        $model = new AccessModel;
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
        $model = new AccessModel;
        if (!$this->request->isAjax()) {
            // 权限列表
            $accessList = $model->getList();
            return $this->fetch('add', compact('accessList'));
        }
        // 新增记录
        if ($model->add($this->postData('access'))) {
            return $this->renderSuccess('添加成功', url('factory.access/index'));
        }
        return $this->renderError($model->getError() ?: '添加失败');
    }

    /**
     * 更新权限
     * @param $access_id
     * @return array|mixed
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function edit($access_id)
    {
        // 权限详情
        $model = AccessModel::detail($access_id);
        if (!$this->request->isAjax()) {
            // 权限列表
            $accessList = $model->getList();
            return $this->fetch('edit', compact('model', 'accessList'));
        }
        // 更新记录
        if ($model->edit($this->postData('access'))) {
            return $this->renderSuccess('更新成功', url('factory.access/index'));
        }
        return $this->renderError($model->getError() ?: '更新失败');
    }

    /**
     * 删除权限
     * @param $access_id
     * @return array
     * @throws \think\exception\DbException
     */
    public function delete($access_id)
    {
        // 权限详情
        $model = AccessModel::detail($access_id);
        if (!$model->remove()) {
            return $this->renderError($model->getError() ?: '删除失败');
        }
        return $this->renderSuccess('删除成功');
    }

    /**
     * 修改商品状态
     * @param $access_id
     * @param boolean $state
     * @return array
     */
    public function state($access_id, $state)
    {
        // 商品详情
        $model = AccessModel::detail($access_id);
        if (!$model->setStatus($state)) {
            return $this->renderError('操作失败');
        }
        return $this->renderSuccess('操作成功');
    }
}
