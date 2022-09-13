<?php

namespace app\store\model\store;

use app\common\model\store\Access as AccessModel;
use app\common\traits\model\admin\Access as AccessTrait;

/**
 * 商家用户权限模型
 * Class Access
 * @package app\store\model\store
 */
class Access extends AccessModel
{
    use AccessTrait;
    /**
     * 获取指定角色的所有权限id
     * @param int|array $role_id 角色id (支持数组)
     * @return array
     */
    public static function getAccessIds($role_id)
    {
        return RoleAccess::getAccessIds($role_id);
    }
}