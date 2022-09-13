<?php

namespace app\admin\model\factory;

use app\common\model\factory\Access as AccessModel;
use app\admin\traits\model\Access as AccessTrait;
/**
 * 商家用户权限模型
 * Class Access
 * @package app\admin\model\store
 */
class Access extends AccessModel
{
    use AccessTrait;
}