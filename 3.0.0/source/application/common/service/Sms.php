<?php

namespace app\common\service;

use app\common\enum\OrderType as OrderTypeEnum;
use app\common\model\VerifyCode as VerifyCodeModel;
use app\common\service\Message as MessageService;
use think\Log;
use think\Session;
use app\common\exception\BaseException;
use app\common\exception\NotAuthException;

use AlibabaCloud\SDK\Dysmsapi\V20170525\Dysmsapi;
use \Exception;
use AlibabaCloud\Tea\Exception\TeaError;
use AlibabaCloud\Tea\Utils\Utils;
use Darabonba\OpenApi\Models\Config;
use AlibabaCloud\SDK\Dysmsapi\V20170525\Models\SendSmsRequest;
use AlibabaCloud\SDK\Dysmsapi\V20170525\Models\QuerySendDetailsRequest;
use AlibabaCloud\Tea\Utils\Utils\RuntimeOptions;
use AlibabaCloud\Tea\Model;

class Sms extends Basics
{

    public static function createClient(): Dysmsapi
    {
        $config = new Config([
            // 您的 AccessKey ID
            "accessKeyId" => 'LTAI5t7jPKzbAH7E8fWuy5vg',
            // 您的 AccessKey Secret
            "accessKeySecret" => 'JteqklnrXRwaSINrT83nvadJvV8iM4'
        ]);
        // 访问的域名
        $config->endpoint = "dysmsapi.aliyuncs.com";
        return new Dysmsapi($config);
    }
    /**
     * 发送短信验证码到手机号码
     * @param $phone_numbers //逗号分割，目前不支持多手机
     * @throws NotAuthException
     * @throws BaseException
     */

    public function sendSMS($phone_numbers, $usage):bool
    {
        $se_time = time() - Session::get($phone_numbers . 'SMSLimit');
        if (Session::get($phone_numbers . 'SMSLimit') and ($se_time <= 60)) {
            throw new NotAuthException(['msg' => (60 - $se_time)]);
        }
        $verify_code = rand(1000, 9999);

        $result = MessageService::send('user.register', [
            'code' => $verify_code,
            'phone_numbers' => $phone_numbers,
            'wxapp_id' => 10001,
        ]);
        var_dump($result);exit;
    }
    /**
     * 发送短信验证码到手机号码
     * @param $phone_numbers //逗号分割，目前不支持多手机
     * @throws NotAuthException
     * @throws BaseException
     */
    /*
    public function sendSMS($phone_numbers, $usage):bool
    {
        $se_time = time() - Session::get($phone_numbers.'SMSLimit');
        if (Session::get($phone_numbers.'SMSLimit') and ($se_time <= 60)) {
            throw new RequestTooFrequentException(['msg' => (60-$se_time)]);
        }

        $sign_name = '飞步技';
        $verify_code = rand(1000, 9999);
        $template_param['code'] = $verify_code;
        $type = 'verify';
        switch ($usage) {
            case 'reg':
                $template_code = 'SMS_10840890';
                $template_param['product'] = '泡臣';

                break;
            case 'reset_password':

                break;

            default:
                throw new BaseException();
                break;
        }
        //发送短信
        $sendReq = new SendSmsRequest([
            "phoneNumbers" => $phone_numbers,
            "signName" => $sign_name,
            "templateCode" => $template_code,
            "templateParam" => json_encode($template_param),
        ]);

        $client = self::createClient();
        try {
            // 复制代码运行请自行打印 API 的返回值
            $sendResp = $client->sendSms($sendReq);
            $code = $sendResp->body->code;
            if (!Utils::equalString($code, "OK")) {
                throw new BaseException(['msg' => $sendResp->body->message]);
            }
            $bizId = $sendResp->body->bizId;
            //将手机及其对应的短信验证码保存到数据库
            $verifyCodeModel = new VerifyCodeModel();
            $verifyCodeModel->save([
                'account_type' => 'phone_number',
                'account' => $phone_numbers,
                'verify_code' => $verify_code,
                'is_send' => 1,
                'usage' => 'reg'
            ]);
            Session::set($phone_numbers.'SMSLimit', time());
            return true;
        } catch (Exception $error) {
            if (!($error instanceof TeaError)) {
                $error = new TeaError([], $error->getMessage(), $error->getCode(), $error);
            }
            // 如有需要，请打印 error
            Utils::assertAsString($error->message);
            Log::error($error->message);
            throw new BaseException(['msg' => lang('server_error')]);

            //throw new BaseException(['msg' =>  Utils::assertAsString($error->message)]);
        }


    }
    */
}