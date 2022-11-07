<?php

namespace app\common\library\wechat;

use app\common\model\Wxapp as WxappModel;
use app\common\exception\BaseException;

/**
 * 微信扫码
 * Class WxQrLogin
 * @package app\common\library\wechat
 */
class WxQrLogin extends WxBase
{
    //检测微信登录
    public function wechatLoginCheck()
    {
        $res = db('login')->where('id', 2)->find();
        if ($res['status'] == 0) {
            $this->error("未启用微信登录");
        }
        if ($res['appid'] == "") {
            $this->error("微信登录APPID不能为空");
        }
        if ($res['appsecret'] == "") {
            $this->error("微信登录APPSECRET不能为空");
        }
        if ($res['notify'] == "") {
            $this->error("微信登录notify不能为空");
        }
        return $res;
    }

    //微信登录第一步
    public function gowechat()
    {
        $wechat = $this->wechatLoginCheck();
        $url = 'https://open.weixin.qq.com/connect/qrconnect?appid=' . $wechat['appid'] . '&redirect_uri=' . urlencode($wechat['notify']) . '&response_type=code&scope=snsapi_login&state=' . md5(time()) . '#wechat_redirect';
        $this->redirect($url);
    }

    //微信登录回调处理
    public function wechatLogin()
    {
        $wechat = $this->wechatLoginCheck();
        $code = input('code');
        $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=" . $wechat['appid'] . "&secret=" . $wechat['appsecret'] . "&code=" . $code . "&grant_type=authorization_code";
        $access_token = curl_get($url);
        $access_token = json_decode($access_token, true);
        if (!$access_token || isset($access_token['errcode'])) {
            $this->error("登录失败");
        }
        $url = "https://api.weixin.qq.com/sns/userinfo?access_token=" . $access_token['access_token'] . "&openid=" . $access_token['openid'];
        $user = curl_get($url);
        $user = json_decode($user, true);
        if (!$user) {
            $this->error("获取用户信息失败");
        }
        //user 为用户信息，下面继续业务逻辑
    }
}