<?php

namespace app\store\model\factory;

use app\common\exception\BaseException;
use app\common\model\factory\User as FactoryUserModel;

/**
 * 工厂用户模型
 * Class StoreUser
 * @package app\admin\model
 */
class User extends FactoryUserModel
{
    /**
     * 新增工厂用户记录
     * @param int $factory_id
     * @param array $data
     * @return bool|false|int
     */
    public function add($factory_id, $data)
    {
        return $this->save([
            'user_name' => $data['user_name'],
            'password' => fbshop_hash($data['password']),
            'is_super' => 1,
            'factory_id' => $factory_id,
            'wxapp_id' => self::$wxapp_id,
        ]);
    }

    /**
     * 工厂用户登录
     * @param int $factory_id
     * @throws \think\Exception
     * @throws \think\exception\DbException
     */
    public function login($factory_id)
    {
        // 获取获取商城超级管理员用户信息
        $user = $this->getSuperFactoryUser($factory_id);
        if (empty($user)) {
            throw new BaseException(['msg' => '超级管理员用户信息不存在']);
        }
        $this->loginState($user);
    }

    /**
     * 获取获取商城超级管理员用户信息
     * @param $factory_id
     * @return User|null
     * @throws \think\exception\DbException
     */
    private function getSuperFactoryUser($factory_id)
    {
        return static::detail(['factory_id' => $factory_id, 'is_super' => 1], ['factory']);
    }

    /**
     * 删除小程序下的工厂用户
     * @param $factory_id
     * @return false|int
     */
    public function setDelete($factory_id)
    {
        return $this->save(['is_delete' => 1], ['factory_id' => $factory_id]);
    }

}
