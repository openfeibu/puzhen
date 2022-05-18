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

}