<?php
namespace app\common\service;

use app\common\service\Basics;
use app\common\model\VerifyCode as VerifyCodeModel;


class VerifyCode extends Basics
{

    /**
     * 检查手机号码跟短信验证码是否一致
     */
    public function checkCode($account, $verifyCode, $msgType): bool
    {
        //频率限制
        $verifyCodeModel = new VerifyCodeModel;
        $verifyCodeList = $verifyCodeModel->getCode($account, $verifyCode, $msgType);
        if (!$verifyCodeList) {
            $this->error = lang('verify_code.error');
            return false;
        }
        $verifyCodeList->save(['is_used' => 1]);
        return true;
    }

}
