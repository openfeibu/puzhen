<?php

namespace app\common\service\message\user;

use app\common\service\message\Basics;
use app\common\model\Setting as SettingModel;
use think\Log;
use think\Session;
use app\common\exception\BaseException;
use app\common\exception\RequestTooFrequentException;
use app\common\model\VerifyCode as VerifyCodeModel;

class User extends Basics
{
    /**
     * 参数列表
     * @var array
     */
    protected $param = [

    ];

    /**
     * 发送消息通知
     * @param array $param
     * @return mixed|void
     * @throws \think\Exception
     */
    public function send($param)
    {
        // 记录参数
        $this->param = $param;
        $this->onSendSms();
    }

    /**
     * 短信通知商家
     * @return bool
     * @throws \think\Exception
     */
    private function onSendSms()
    {
        $wxappId = $this->param['wxapp_id'];
        $phoneNumbers = $this->param['phone_numbers'];
        $seTime = time() - Session::get($phoneNumbers.'SMSLimit');
        if (Session::get($phoneNumbers.'SMSLimit') and ($seTime <= 60)) {
            throw new RequestTooFrequentException(['msg' => (60-$seTime)]);
        }

        $code = rand(1000, 9999);

        if($this->sendSms($this->param['msg_type'],$phoneNumbers, ['code' => $code, 'product' => '泡臣'], $wxappId))
        {
            $verifyCodeModel = new VerifyCodeModel();
            $verifyCodeModel->save([
                'account_type' => 'phone_number',
                'account' => $phoneNumbers,
                'verify_code' => $code,
                'is_send' => 1,
                'msg_type' => $this->param['msg_type']
            ]);
            Session::set($phoneNumbers.'SMSLimit', time());
            return true;
        }else{
            return false;
        }
    }




}