<?php

namespace app\store\model\store;

use app\common\model\store\RoleAccess as RoleAccessModel;
use app\common\traits\model\admin\RoleAccess as RoleAccessTrait;

/**
 * 商家用户角色权限关系模型
 * Class RoleAccess
 * @package app\store\model\store
 */
class RoleAccess extends RoleAccessModel
{
    use RoleAccessTrait;
}