<?php

namespace app\pc\controller;

use app\common\exception\BaseException;
use app\common\service\Message as MessageService;
use app\pc\model\User as UserModel;
use app\store\model\Setting;
use think\Lang;
use think\Session;
use app\common\library\wechat\WxQrLogin;

/**
 * 认证
 * Class Passport
 * @package app\pc\controller
 */
class Passport extends Controller
{
    protected $checkLoginAction = [
        'passport/register_weixin_web_bind',
    ];
    /**
     * 登录
     * @return array|mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function login()
    {
        if ($this->request->isAjax()) {
            $model = new UserModel;
            if ($model->login($this->postData())) {
                return $this->renderSuccess([],lang('login.success'),$_SERVER["HTTP_REFERER"]);
            }
            return $this->renderError([],$model->getError() ?: lang('login.failed'));
        }
        if($this->pc && $this->pc['is_login'])
        {
            return redirect('user/index');
        }
        $this->view->engine->layout('layouts/passport');

        $WxQrLogin = new WxQrLogin;
        $state = $WxQrLogin->getState();
        $weixinLoginRedirectUrl = 'http://www.fspuzhen.cn/index.php?s=/pc/passport/register_weixin_web_bind';

        return $this->fetch('login',compact('state','weixinLoginRedirectUrl'));
    }
    public function register()
    {
        $lang = Lang::detect();
        $model = new UserModel;
        if ($this->request->isAjax()) {
            if(!$model->register($this->postData()))
            {
                return $this->renderError([],$model->getError() ?: lang('register.failed'));
            }

            switch ($lang) {
                case 'zh-cn':
                    //跳到微信绑定
                    $redirect_url = url('register_weixin_web_bind');
                    break;
                default :
                    $redirect_url = $_SERVER["HTTP_REFERER"];
                    break;

            }
            return $this->renderSuccess([],lang('register.success'),$redirect_url);

        }
        return $this->fetch('register');
    }

    /**
     * @throws BaseException
     */
    public function register_weixin_web_bind()
    {
        $data = $this->getData();
        $WxQrLogin = new WxQrLogin;
        if(isset($data['code']) && isset($data['state']))
        {
            $userInfo = $WxQrLogin->getInfo($data['code'],$data['state']);
//            $userInfo = [
//                'open_id' => '123',
//                'union_id' => 'olT6O59tHxnM_sITNCYrbU7RENFw',
//                'nickName' => 'G',
//                'avatarUrl' => 'https://thirdwx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTJUzv6S9wroyYD3mlLrBU0b6CfbpJJicibJeQf9vsK1EReVb9vaJKL1jcDaGZIiaR1ZRPZicxclmoWZfw/132'
//            ];
            $userModel = new UserModel();
            if(!$userModel->wxRegisterBind($this->pc['user'],$userInfo))
            {
                return redirect('register_weixin_web_bind', [],302, ['msg' => $userModel->getError() ?: lang('register.failed'), 'code' => 0]);
            }
            return redirect('user/index');
        }
        $state = $WxQrLogin->getState();
        $weixinLoginRedirectUrl = 'http://www.fspuzhen.cn/index.php?s=/pc/passport/register_weixin_web_bind';

        return $this->fetch('register_weixin_web_bind',compact('state','weixinLoginRedirectUrl'));

    }
    /**
     */
    public function send_register_sms():array
    {
        $data = $this->postData();
        $model = new UserModel;
        if(!$model->sendRegisterSms($data))
        {
            return $this->renderError([],$model->getError());
        }

        return $this->renderSuccess([],lang('send_success'));
    }
    /**
     */
    public function send_register_email():array
    {
        $data = $this->postData();
        $model = new UserModel;
        if(!$model->sendRegisterEmail($data))
        {
            return $this->renderError([],$model->getError());
        }

        return $this->renderSuccess([],lang('send_success'));
    }

    /**
     * 退出登录
     */
    public function logout()
    {
        Session::clear('fbshop_pc');
        $this->redirect('passport/login');
    }

}
