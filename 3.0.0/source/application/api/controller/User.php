<?php

namespace app\api\controller;

use app\api\model\User as UserModel;

/**
 * 用户管理
 * Class User
 * @package app\api
 */
class User extends Controller
{
    /**
     * 用户自动登录
     * @return array
     * @throws \app\common\exception\BaseException
     * @throws \think\Exception
     * @throws \think\exception\DbException
     */
    public function login()
    {
        $model = new UserModel;
        return $this->renderSuccess([
            'user_id' => $model->login($this->request->post()),
            'token' => $model->getToken()
        ]);
    }
    //静默登录
    public function code()
    {
        $model = new UserModel;
        $user_id = $model->code($this->request->post());
        return $this->renderSuccess([
            'user_id' => $user_id,
            'token' => $user_id ? $model->getToken() : ''
        ]);
    }
    /**
     * 当前用户详情
     * @return array
     * @throws \app\common\exception\BaseException
     * @throws \think\exception\DbException
     */
    public function detail()
    {
        // 当前用户信息
        $userInfo = $this->getUser();
        return $this->renderSuccess(compact('userInfo'));
    }
    /**
     * 更新当前用户信息
     * @return array|mixed
     * @throws \think\exception\DbException
     */
    public function renew()
    {
        $model = $this->getUser();
        // 管理员详情

        if ($model->renew($this->postData())) {
            return $this->renderSuccess([],lang('更新失败'));
        }
        return $this->renderError([],$model->getError() ?: '更新成功');

    }
}
