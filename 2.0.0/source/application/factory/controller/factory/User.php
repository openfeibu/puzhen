<?php

namespace app\factory\controller\factory;

use app\factory\controller\Controller;
use app\factory\model\factory\Role as RoleModel;
use app\factory\model\factory\User as FactoryUserModel;
use app\factory\model\factory\UserRole;

/**
 * 工厂用户控制器
 * Class FactoryUser
 * @package app\factory\controller
 */
class User extends Controller
{
    /**
     * 用户列表
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function index()
    {
        $model = new FactoryUserModel;
        $list = $model->getList();
        return $this->fetch('index', compact('list'));
    }

    /**
     * 添加管理员
     * @return array|mixed
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function add()
    {
        $model = new FactoryUserModel;
        if (!$this->request->isAjax()) {
            // 角色列表
            $roleList = (new RoleModel)->getList();
            return $this->fetch('add', compact('roleList'));
        }
        // 新增记录
        if ($model->add($this->postData('user'))) {
            return $this->renderSuccess('添加成功', url('factory.user/index'));
        }
        return $this->renderError($model->getError() ?: '添加失败');
    }

    /**
     * 更新管理员
     * @param $user_id
     * @return array|mixed
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function edit($user_id)
    {
        // 管理员详情
        $model = FactoryUserModel::detail($user_id);
        $model['roleIds'] = UserRole::getRoleIds($model['factory_user_id']);
        if (!$this->request->isAjax()) {
            return $this->fetch('edit', [
                'model' => $model,
                // 角色列表
                'roleList' => (new RoleModel)->getList(),
                // 所有角色id
                'roleIds' => UserRole::getRoleIds($model['factory_user_id']),
            ]);
        }
        // 更新记录
        if ($model->edit($this->postData('user'))) {
            return $this->renderSuccess('更新成功', url('factory.user/index'));
        }
        return $this->renderError($model->getError() ?: '更新失败');
    }

    /**
     * 删除管理员
     * @param $user_id
     * @return array
     * @throws \think\exception\DbException
     */
    public function delete($user_id)
    {
        // 管理员详情
        $model = FactoryUserModel::detail($user_id);
        if (!$model->setDelete()) {
            return $this->renderError($model->getError() ?: '删除失败');
        }
        return $this->renderSuccess('删除成功');
    }

    /**
     * 更新当前管理员信息
     * @return array|mixed
     * @throws \think\exception\DbException
     */
    public function renew()
    {
        // 管理员详情
        $model = FactoryUserModel::detail($this->factory['user']['factory_user_id']);
        if ($this->request->isAjax()) {
            if ($model->renew($this->postData('user'))) {
                return $this->renderSuccess('更新成功');
            }
            return $this->renderError($model->getError() ?: '更新失败');
        }
        return $this->fetch('renew', compact('model'));
    }
}
