<?php

namespace app\common\model\user;

use app\common\model\BaseModel;
use think\Session;

/**
 * 超管后台用户模型
 * Class User
 * @package app\common\model\user
 */
class User extends BaseModel
{
    protected $name = 'user';

    /**
     * 关联微信小程序表
     * @return \think\model\relation\BelongsTo
     */
    public function wxapp()
    {
        $module = self::getCalledModule() ?: 'common';
        return $this->belongsTo("app\\{$module}\\model\\Wxapp");
    }

    /**
     * 保存登录状态
     * @param $user
     */
    public function loginState($user)
    {
        $wxapp = $user['wxapp'];
        Session::set('fbshop_user', [
            'user' => [
                'user_id' => $user['user_id'],
                'phone_number' => $user['phone_number'],
                'email' => $user['email'],
                'avatarUrl' => $user['avatarUrl'],
            ],
            'wxapp' => $wxapp->toArray(),
            'is_login' => true,
        ]);
    }
}