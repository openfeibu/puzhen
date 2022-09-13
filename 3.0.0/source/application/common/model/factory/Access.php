<?php

namespace app\common\model\factory;

use app\common\model\BaseModel;
use app\common\traits\model\admin\common\Access as AccessTrait;

/**
 * 商家用户权限模型
 * Class Access
 * @package app\common\model\admin
 */
class Access extends BaseModel
{
    use AccessTrait;
    protected $name = 'factory_access';




}