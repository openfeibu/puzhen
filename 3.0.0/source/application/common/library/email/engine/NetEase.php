<?php

namespace app\common\library\email\engine;

use app\common\exception\BaseException;
use think\Log;

class NetEase extends Server
{
    protected $config;
    protected $template;
    /**
     * 构造方法
     * Qiniu constructor.
     * @param $config
     */
    public function __construct($config, $template)
    {
        $this->config = $config;
        $this->template = $template;
    }

    /**
     * 发送邮件通知
     * @param $msgType
     * @param $email
     * @param $templateParams
     * @return bool|\stdClass
     * @throws BaseException
     */
    public function sendEmail($msgType, $email, $templateParams)
    {
        return $this->send($msgType, $email, $templateParams);
    }
}