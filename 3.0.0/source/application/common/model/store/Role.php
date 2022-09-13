<?php

namespace app\common\model\store;

use app\common\model\BaseModel;
use app\common\traits\model\admin\common\Role as RoleTrait;

/**
 * 商家用户角色模型
 * Class Role
 * @package app\common\model\admin
 */
class Role extends BaseModel
{
    use RoleTrait;

    protected $name = 'store_role';



}