<?php

namespace app\common\library\sms\engine;

use app\common\library\sms\package\aliyun\SignatureHelper;
use app\common\exception\BaseException;
use app\common\exception\RequestTooFrequentException;
use think\Log;
use AlibabaCloud\SDK\Dysmsapi\V20170525\Dysmsapi;
use \Exception;
use AlibabaCloud\Tea\Exception\TeaError;
use AlibabaCloud\Tea\Utils\Utils;
use Darabonba\OpenApi\Models\Config;
use AlibabaCloud\SDK\Dysmsapi\V20170525\Models\SendSmsRequest;
use AlibabaCloud\SDK\Dysmsapi\V20170525\Models\QuerySendDetailsRequest;
use AlibabaCloud\Tea\Utils\Utils\RuntimeOptions;
use AlibabaCloud\Tea\Model;


/**
 * 阿里云短信模块引擎
 * Class Aliyun
 * @package app\common\library\sms\engine
 */
class Aliyun extends Server
{
    private $config;

    /**
     * 构造方法
     * Qiniu constructor.
     * @param $config
     */
    public function __construct($config)
    {
        $this->config = $config;
    }
    public function createClient(): Dysmsapi
    {
        $config = new Config([
            // 您的 AccessKey ID
            "accessKeyId" => $this->config['AccessKeyId'],
            // 您的 AccessKey Secret
            "accessKeySecret" => $this->config['AccessKeySecret']
        ]);
        // 访问的域名
        $config->endpoint = "dysmsapi.aliyuncs.com";
        return new Dysmsapi($config);
    }

    /**
     * 发送短信通知 新版本
     * @param $msgType
     * @param $phoneNumbers
     * @param $templateParams
     * @return bool|\stdClass
     * @throws BaseException
     */
    public function sendSms($msgType, $phoneNumbers, $templateParams)
    {
        $params = [];
        // *** 需用户填写部分 ***

        // 必填: 短信接收号码
        $params["phoneNumbers"] = $phoneNumbers;

        // 必填: 短信签名，应严格按"签名名称"填写，请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/sign
        $params["signName"] = $this->config['sign'];

        // 必填: 短信模板Code，应严格按"模板CODE"填写, 请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/template
        $params["templateCode"] = $this->config[$msgType]['template_code'];

        // 可选: 设置模板参数, 假如模板中存在变量需要替换则为必填项
        $params['templateParam'] = $templateParams;

        // 可选: 设置发送短信流水号
        // $params['OutId'] = "12345";

        // 可选: 上行短信扩展码, 扩展码字段控制在7位或以下，无特殊需求用户请忽略此字段
        // $params['SmsUpExtendCode'] = "1234567";

        // *** 需用户填写部分结束, 以下代码若无必要无需更改 ***
        if (!empty($params["templateParam"]) && is_array($params["templateParam"])) {
            $params["templateParam"] = json_encode($params["templateParam"], JSON_UNESCAPED_UNICODE);
        }

        //发送短信
        $sendReq = new SendSmsRequest($params);
        $client = $this->createClient();
        try {
            // 复制代码运行请自行打印 API 的返回值
            $sendResp = $client->sendSms($sendReq);
            $code = $sendResp->body->code;
            if (!Utils::equalString($code, "OK")) {
                Log::error($sendResp->body->message);
                throw new BaseException(['msg' => $sendResp->body->message]);
                //throw new BaseException(['msg' => lang('sms_server_error')]);
            }
            $bizId = $sendResp->body->bizId;
            return true;
        } catch (Exception $error) {
            if (!($error instanceof TeaError)) {
                $error = new TeaError([], $error->getMessage(), $error->getCode(), $error);
            }
            // 如有需要，请打印 error
            Log::error($error->message);
            //throw new BaseException(['msg' => lang('sms_server_error')]);
            throw new BaseException(['msg' =>  Utils::assertAsString($error->message)]);
        }
    }

    /**
     * 发送短信通知 旧版本
     * @param $msgType
     * @param $phoneNumbers
     * @param $templateParams
     * @return bool|\stdClass
     */
    /*
    public function sendSms($msgType, $phoneNumbers, $templateParams)
    {
        $params = [];
        // *** 需用户填写部分 ***

        // 必填: 短信接收号码
        $params["PhoneNumbers"] = $phoneNumbers;

        // 必填: 短信签名，应严格按"签名名称"填写，请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/sign
        $params["SignName"] = $this->config['sign'];

        // 必填: 短信模板Code，应严格按"模板CODE"填写, 请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/template
        $params["TemplateCode"] = $this->config[$msgType]['template_code'];

        // 可选: 设置模板参数, 假如模板中存在变量需要替换则为必填项
        $params['TemplateParam'] = $templateParams;

        // 可选: 设置发送短信流水号
        // $params['OutId'] = "12345";

        // 可选: 上行短信扩展码, 扩展码字段控制在7位或以下，无特殊需求用户请忽略此字段
        // $params['SmsUpExtendCode'] = "1234567";

        // *** 需用户填写部分结束, 以下代码若无必要无需更改 ***
        if (!empty($params["TemplateParam"]) && is_array($params["TemplateParam"])) {
            $params["TemplateParam"] = json_encode($params["TemplateParam"], JSON_UNESCAPED_UNICODE);
        }

        // 初始化SignatureHelper实例用于设置参数，签名以及发送请求
        $helper = new SignatureHelper;

        // 此处可能会抛出异常，注意catch
        $response = $helper->request(
            $this->config['AccessKeyId']
            , $this->config['AccessKeySecret']
            , "dysmsapi.aliyuncs.com"
            , array_merge($params, [
                "RegionId" => "cn-hangzhou",
                "Action" => "SendSms",
                "Version" => "2017-05-25",
            ])
            // 选填: 启用https
            , true
        );
        // 记录日志
        log_write([
            'config' => $this->config,
            'params' => $params
        ]);
        log_write($response);
        $this->error = $response->Message;
        return $response->Code === 'OK';
    }
    */


}
