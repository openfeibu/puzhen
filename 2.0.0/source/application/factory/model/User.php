<?php

namespace app\factory\model;

use app\common\model\User as UserModel;

use app\store\model\dealer\User as DealerUserModel;
use app\store\model\user\GradeLog as GradeLogModel;
use app\store\model\user\PointsLog as PointsLogModel;
use app\store\model\user\BalanceLog as BalanceLogModel;
use app\common\enum\user\balanceLog\Scene as SceneEnum;
use app\common\enum\user\grade\log\ChangeType as ChangeTypeEnum;
use app\common\library\helper;

/**
 * 用户模型
 * Class User
 * @package app\store\model
 */
class User extends UserModel
{
    public static function init()
    {
        parent::init();
        parent::$is_factory = 0;
    }
}
