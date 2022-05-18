<?php

namespace app\common\model\store;

use app\common\model\BaseModel;
use app\common\traits\model\admin\common\RoleAccess as RoleAccessTrait;
/**
 * 商家用户角色权限关系模型
 * Class RoleAccess
 * @package app\common\model\admin
 */
class RoleAccess extends BaseModel
{
    use RoleAccessTrait;

    protected $name = 'store_role_access';
    protected $updateTime = false;

}