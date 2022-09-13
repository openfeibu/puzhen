<?php

namespace app\factory\model\factory;

use app\common\model\factory\Access as AccessModel;
use app\common\traits\model\admin\Access as AccessTrait;
/**
 * 商家用户权限模型
 * Class Access
 * @package app\factory\model\factory
 */
class Access extends AccessModel
{
    use AccessTrait;

    public static function init()
    {
        parent::init();
        //parent::$is_factory = 0;
    }
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