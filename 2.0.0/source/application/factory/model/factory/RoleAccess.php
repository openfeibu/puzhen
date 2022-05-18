<?php

namespace app\factory\model\factory;

use app\common\model\factory\RoleAccess as RoleAccessModel;
use app\common\traits\model\admin\RoleAccess as RoleAccessTrait;

/**
 * 商家用户角色权限关系模型
 * Class RoleAccess
 * @package app\factory\model\factory
 */
class RoleAccess extends RoleAccessModel
{
    use RoleAccessTrait;
}