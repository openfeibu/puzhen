<?php

namespace app\factory\model\factory;

use app\common\model\factory\UserRole as UserRoleModel;

/**
 * 商家用户角色模型
 * Class UserRole
 * @package app\factory\model\factory
 */
class UserRole extends UserRoleModel
{
    /**
     * 新增关系记录
     * @param $factory_user_id
     * @param array $roleIds
     * @return array|false
     * @throws \Exception
     */
    public function add($factory_user_id, $roleIds)
    {
        $data = [];
        foreach ($roleIds as $role_id) {
            $data[] = [
                'factory_user_id' => $factory_user_id,
                'role_id' => $role_id,
                'wxapp_id' => self::$wxapp_id,
                'factory_id' => self::$factory_id,
            ];
        }
        return $this->saveAll($data);
    }

    /**
     * 更新关系记录
     * @param $factory_user_id
     * @param array $newRole 新的角色集
     * @return array|false
     * @throws \Exception
     */
    public function edit($factory_user_id, $newRole)
    {
        // 已分配的角色集
        $assignRoleIds = self::getRoleIds($factory_user_id);

        /**
         * 找出删除的角色
         * 假如已有的角色集合是A，界面传递过得角色集合是B
         * 角色集合A当中的某个角色不在角色集合B当中，就应该删除
         * 使用 array_diff() 计算补集
         */
        if ($deleteRoleIds = array_diff($assignRoleIds, $newRole)) {
            self::deleteAll(['factory_user_id' => $factory_user_id, 'role_id' => ['in', $deleteRoleIds]]);
        }

        /**
         * 找出添加的角色
         * 假如已有的角色集合是A，界面传递过得角色集合是B
         * 角色集合B当中的某个角色不在角色集合A当中，就应该添加
         * 使用 array_diff() 计算补集
         */
        $newRoleIds = array_diff($newRole, $assignRoleIds);
        $data = [];
        foreach ($newRoleIds as $role_id) {
            $data[] = [
                'factory_user_id' => $factory_user_id,
                'role_id' => $role_id,
                'wxapp_id' => self::$wxapp_id,
            ];
        }
        return $this->saveAll($data);
    }

    /**
     * 获取指定管理员的所有角色id
     * @param $factory_user_id
     * @return array
     */
    public static function getRoleIds($factory_user_id)
    {
        return (new self)->where('factory_user_id', '=', $factory_user_id)->column('role_id');
    }

    /**
     * 删除记录
     * @param $where
     * @return int
     */
    public static function deleteAll($where)
    {
        return self::destroy($where);
    }

}