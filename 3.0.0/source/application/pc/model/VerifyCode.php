<?php

namespace app\pc\model;

use app\common\model\VerifyCode as VerifyCodeModel;


class VerifyCode extends VerifyCodeModel
{
    /**
     * 隐藏字段
     * @var array
     */
    protected $hidden = [
        'wxapp_id',
        'create_time',
        'update_time'
    ];



}
