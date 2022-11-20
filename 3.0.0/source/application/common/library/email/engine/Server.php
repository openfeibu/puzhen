<?php

namespace app\common\library\email\engine;

use app\common\exception\BaseException;
use PHPMailer\PHPMailer\PHPMailer; //这个是发邮件的类，引入进来
use PHPMailer\PHPMailer\Exception; //这个是发邮件失败了，报出异常
use app\common\library\helper;
use think\Cookie;

class Server
{
    protected $error;
    protected $config;
    protected $template;

    public function __construct()
    {

    }
    /**
     * 返回错误信息
     * @return mixed
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * @throws BaseException
     */
    public function send($msgType, $email, $templateParams)
    {
        $prefix = Cookie::get('think_var') == 'zh-cn' ? '' : 'en_';
        $body = $this->template[$msgType][$prefix.'body'] ?? $this->template[$msgType]['body'];
        $subject = $this->template[$msgType][$prefix.'subject'] ?? $this->template[$msgType]['subject'];
        $body = str_replace_template($body,$templateParams);
        $mail = new PHPMailer(true); //实例化加载这个类，如果说邮件发送失败了，可以抛出异常
        //开发环境下，是需要打开异常抛出的，实际情况下可以false关闭
        try {
            $mail->SMTPDebug = 0;        //这里是调试模式，2的话表示详细错误信息，1的话是简要错误信息，0的话是不显示错误信息。 启用详细的调试输出
            $mail->isSMTP();                     // 设置邮件使用SMTP
            $mail->Host = $this->config['host'];        // 指定主和备份SMTP服务器
            $mail->SMTPAuth = true;                               // 使SMTP认证
            $mail->Username = $this->config['username'];             // SMTP用户名
            $mail->Password =  $this->config['password'];                   // SMTP 密码,
            $mail->SMTPSecure = 'ssl';                            // 启用TLS加密，也接受“ssl”
            $mail->Port = $this->config['port'];                                    // 要连接的TCP端口
            $mail->CharSet = 'utf-8';                             //要发送的内容格式

            //Recipients
            $mail->setFrom('fspuzhen666@163.com', $templateParams['product']); //发邮件人
            $mail->addAddress($email, $email);    //收件人，可以设置好几个

            $mail->isHTML(true);                                  // 设置电子邮件格式为HTML
            $mail->Subject = $subject;
            $mail->Body    = $body;
            //  $mail->AltBody='发送错误';          //表示isHTML发送失败，就发送这个内容。

            $mail->send();       //这里是发送方法
            return true;
        }catch (Exception $e) {
            //exception($mail->ErrorInfo(), 1001);
            throw new BaseException(['mgs' => lang('email_server_error')]);
        }


    }

}
