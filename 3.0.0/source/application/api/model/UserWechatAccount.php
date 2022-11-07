<?php

namespace app\api\model;

use think\Cache;
use app\common\library\wechat\WxUser;
use app\common\exception\BaseException;
use app\common\model\UserWechatAccount as UserWechatAccountModel;
use app\api\model\dealer\Referee as RefereeModel;
use app\api\model\dealer\Setting as DealerSettingModel;

/**
 * 用户模型类
 * Class User
 * @package app\api\model
 */
class UserWechatAccount extends UserWechatAccountModel
{

    /**
     * 隐藏字段
     * @var array
     */
    protected $hidden = [
        'open_id',
        'union_id',
        'is_delete',
        'wxapp_id',
        'create_time',
        'update_time'
    ];

   
}
