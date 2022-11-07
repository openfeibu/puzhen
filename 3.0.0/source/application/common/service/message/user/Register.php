<?php

namespace app\common\service\message\user;

use app\common\service\message\Basics;
use app\common\model\Setting as SettingModel;


class Register extends Basics
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
        //此处处理逻辑 todo
        $wxappId = $this->param['wxapp_id'];
        return $this->sendSms('reg',$this->param['phone_numbers'], ['code' => $this->param['code'], 'product' => '泡臣'], $wxappId);
    }




}