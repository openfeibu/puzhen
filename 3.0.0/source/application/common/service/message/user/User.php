<?php

namespace app\common\service\message\user;

use app\common\service\message\Basics;
use app\common\model\Setting as SettingModel;
use app\store\model\Setting;
use think\Log;
use think\Session;
use app\common\exception\BaseException;
use app\common\exception\NotAuthException;
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
        $this->onSend();

    }

    /**
     * 短信通知用户
     * @return bool
     * @throws \think\Exception
     */
    private function onSend()
    {
        $wxappId = $this->param['wxapp_id'];
        $pcSetting = Setting::getItem('pc', $wxappId);
        $this->param['product'] = $this->param['product'] ?? $pcSetting['name'];

        if(isset($this->param['phone_numbers']))
        {
            $fun = "sendSms";
            $account = $this->param['phone_numbers'];
            $accountType = 'phone_number';
        }else{
            $fun = "sendEmail";
            $account = $this->param['email'];
            $accountType = 'email';
        }
        $seTime = time() - Session::get($account.'SMSLimit');
        if (Session::get($account.'SMSLimit') and ($seTime <= 60)) {
            //throw new RequestTooFrequentException(['msg' => (60-$seTime)]);
        }

        $code = rand(1000, 9999);

        if($this->$fun($this->param['msg_type'],$account, ['code' => $code, 'product' => $this->param['product']], $wxappId))
        {
            $verifyCodeModel = new VerifyCodeModel();
            $verifyCodeModel->save([
                'account_type' => $accountType,
                'account' => $account,
                'verify_code' => $code,
                'is_send' => 1,
                'msg_type' => $this->param['msg_type']
            ]);
            Session::set($account.'SMSLimit', time());
            return true;
        }else{
            return false;
        }
    }




}