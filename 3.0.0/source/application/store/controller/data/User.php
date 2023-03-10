<?php

namespace app\store\controller\data;

use app\store\controller\Controller;
use app\store\model\User as UserModel;
use app\store\model\user\Grade as GradeModel;

/**
 * 用户数据控制器
 * Class User
 * @package app\store\controller\data
 */
class User extends Controller
{
    /* @var \app\store\model\User $model */
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
        $this->model = new UserModel;
        $this->view->engine->layout(false);
    }

    /**
     * 用户列表
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function lists()
    {
        // 会员等级列表
        $gradeList = GradeModel::getUsableList();
        // 用户列表
        $list = $this->model->getList($this->request->param());
        return $this->fetch('list', compact('list', 'gradeList'));
    }

}