<?php

namespace app\common\model\factory;

use think\Session;
use app\common\model\BaseModel;

/**
 * 工厂用户模型
 * Class User
 * @package app\common\model
 */
class User extends BaseModel
{
    protected $name = 'factory_user';

    /**
     * 关联工厂表
     * @return \think\model\relation\BelongsTo
     */
    public function factory()
    {
        $module = self::getCalledModule() ?: 'common';
        return $this->belongsTo("app\\{$module}\\model\\Factory");
    }

    /**
     * 关联用户角色表表
     * @return \think\model\relation\BelongsToMany
     */
    public function role()
    {
        return $this->belongsToMany('Role', 'StoreUserRole');
    }

    /**
     * 验证用户名是否重复
     * @param $userName
     * @return bool
     */
    public static function checkExist($userName)
    {
        return !!static::useGlobalScope(false)
            ->where('user_name', '=', $userName)
            ->where('is_delete', '=', 0)
            ->value('factory_user_id');
    }

    /**
     * 工厂用户详情
     * @param $where
     * @param array $with
     * @return static|null
     * @throws \think\exception\DbException
     */
    public static function detail($where, $with = [])
    {
        !is_array($where) && $where = ['factory_user_id' => (int)$where];
        return static::get(array_merge(['is_delete' => 0], $where), $with);
    }

    /**
     * 保存登录状态
     * @param $user
     * @throws \think\Exception
     */
    public function loginState($user)
    {
        /** @var \app\common\model\Factory $factory */
        $factory = $user['factory'];
        // 保存登录状态
        Session::set('yoshop_factory', [
            'user' => [
                'factory_user_id' => $user['factory_user_id'],
                'user_name' => $user['user_name'],
            ],
            'factory' => $factory->toArray(),
            'is_login' => true,
        ]);
    }

}
