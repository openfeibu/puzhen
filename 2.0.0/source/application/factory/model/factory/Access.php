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

}