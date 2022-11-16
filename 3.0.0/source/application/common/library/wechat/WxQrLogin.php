<?php

namespace app\common\library\wechat;

use app\common\model\Setting as SettingModel;
use app\common\model\Wxapp as WxappModel;
use app\common\exception\BaseException;
use think\Cache;
use think\Session;

/**
 * 微信扫码
 * Class WxQrLogin
 * @package app\common\library\wechat
 */
class WxQrLogin extends WxBase
{
    //配置APP参数

    private $re_url        = '';
    private $state         = 'state';
    private $openid        = '';
    private $code        = '';

    public function __construct()
    {
        $setting = SettingModel::getItem('weixin');
        parent::__construct($setting['web']['AppID'],$setting['web']['AppSecret']);
    }

    public function getCode()
    {
        $this->getState();
        $url = 'https://open.weixin.qq.com/connect/qrconnect?appId='.$this->appId.'&redirect_uri='.urlencode($this->re_url).'&response_type=code&scope=snsapi_login&state='.$_SESSION[$this->state].'#wechat_redirect';
        header('Location: '.$url);
    }

    /**
     * @throws BaseException
     */
    public function getInfo($code, $state): array
    {
        $this->code = $code;
        $this->state = $state;
        $accessToken = $this->getAccessToken();
        return $this->getUserInfo($accessToken);
    }

    /**
     * [getAccessToken 获取access_token]
     * @param [string] $code [登陆后返回的$_GET['code']]
     * @return [array] [expires_in 为有效时间 , access_token 为授权码 ; 失败返回 error , error_description ]
     * @throws BaseException
     */
    public function getAccessToken()
    {
        $this->isState();
        // 请求API获取 access_token
        $url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$this->appId.'&secret='.$this->appSecret.'&code='.$this->code.'&grant_type=authorization_code';
        $result = $this->get($url);
        $response = $this->jsonDecode($result);
        if (array_key_exists('errcode', $response)) {
            throw new BaseException(['msg' => "access_token获取失败，错误信息：{$result}"]);
        }
        // 记录日志
        $this->doLogs([
            'describe' => '获取access_token',
            'url' => $url,
            'appId' => $this->appId,
            'result' => $result
        ]);
        $this->openid = $response['openid'];
        return $response['access_token'];
    }
    /**
     * [getUserInfo 获取用户信息]
     * @param [string] $accessToken [授权码]
     * @param [string] $openid [用户唯一ID]
     * @return [array] [ret：返回码，为0时成功。msg为错误信息,正确返回时为空。...params]
     */
    public function getUserInfo($accessToken): array
    {

        $url              = 'https://api.weixin.qq.com/sns/userinfo?access_token='.$accessToken.'&openid='.$this->openid;
        $data             = json_decode($this->curlGetContent($url), TRUE);
        $user_info['nickName']    = $data['nickname'];
        $user_info['gender']     = $data['sex'];
        $user_info['avatarUrl']     = $data['headimgurl'];
        $user_info['open_id']  = $data['openid'];
        $user_info['union_id']    = $data['unionid'];

        return $user_info;
    }

    private function curlGetContent($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        //设置超时时间为3s
        curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, 3);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    //生成随机参数
    public function getState(): string
    {
        $str = str_shuffle('qazxswedcvfrtgbnhyujmkiol1234567890') . time();
        Session::set('state', md5(md5($str)));
        return $str;
    }

    //判断随机数

    /**
     * @throws BaseException
     */
    private function isState()
    {
        if(md5(md5($this->state))!==Session::get('state')){
            throw new BaseException(['msg' => '非法访问']);
        }
    }
}