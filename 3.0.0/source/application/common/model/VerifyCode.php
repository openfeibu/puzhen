<?php

namespace app\common\model;

use think\Db;


class VerifyCode extends BaseModel
{
    protected $name = 'verify_code';
    protected static $is_factory = 0;

    /**
     * 检查手机号码或邮箱跟短信验证码是否一致
     */
    public function getCode($account, $verifyCode, $msgType)
    {
        return self::where('account', $account)
            ->where('verify_code', $verifyCode)
            ->where('msg_type', $msgType)
            ->where('is_used', 0)
            ->where('create_time', '>=', strtotime('-30 minute'))
            ->order('create_time', 'desc')
            ->find();
    }

}