<?php

namespace app\pc\controller;

use app\common\exception\BaseException;
use app\common\service\Message as MessageService;
use app\pc\model\User as UserModel;
use app\store\model\Setting;
use think\Lang;
use think\Session;
use app\common\library\wechat\WxQrLogin;
use app\pc\model\Article as ArticleModel;

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
        if($this->pc && isset($this->pc['is_login']) && $this->pc['is_login'])
        {
            return redirect('user/index');
        }
        $this->view->engine->layout('layouts/passport');

        $WxQrLogin = new WxQrLogin;
        $state = $WxQrLogin->getState();
        $weixinLoginRedirectUrl = config('web_domain').'index.php?s=/pc/passport/wx_web_login';

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
                    $redirect_url = url('passport/register_weixin_web_bind');
                    break;
                default :
                    $redirect_url = url('user/index');
                    break;

            }
            return $this->renderSuccess([],lang('register.success'),$redirect_url);

        }
        $WxQrLogin = new WxQrLogin;
        $state = $WxQrLogin->getState();
        $weixinLoginRedirectUrl = config('web_domain').'index.php?s=/pc/passport/wx_web_login';


        $privacyPolicy = ArticleModel::detail(4);
        $userAgreement = ArticleModel::detail(3);
        return $this->fetch('register',compact('state','weixinLoginRedirectUrl','userAgreement','privacyPolicy'));
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
            $userModel = new UserModel();
            if(!$userModel->wxRegisterBind($this->pc['user'],$userInfo))
            {
                return redirect('register_weixin_web_bind', [],302, ['msg' => $userModel->getError() ?: lang('register.failed'), 'code' => 0]);
            }
            return redirect('user/index');
        }
        $state = $WxQrLogin->getState();
        $weixinLoginRedirectUrl = config('web_domain').'index.php?s=/pc/passport/register_weixin_web_bind';

        return $this->fetch('register_weixin_web_bind',compact('state','weixinLoginRedirectUrl'));

    }
    public function wx_web_login()
    {
        $data = $this->getData();
        $WxQrLogin = new WxQrLogin;
        if(isset($data['code']) && isset($data['state']))
        {
            $userInfo = $WxQrLogin->getInfo($data['code'],$data['state']);
//            $userInfo = [
//                'open_id' => 'oV20U586VSmIV_UiKTC4sNCBxP2E',
//                'union_id' => 'olT6O5wVTXnqnjLnLCnWTpG1Xr28',
//                'nickName' => 'G',
//                'avatarUrl' => 'https://thirdwx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTJUzv6S9wroyYD3mlLrBU0b6CfbpJJicibJeQf9vsK1EReVb9vaJKL1jcDaGZIiaR1ZRPZicxclmoWZfw/132'
//            ];
            $userModel = new UserModel();
            if(!$userModel->wxWebLogin($userInfo))
            {
                return redirect('passport/login', [],302, ['msg' => $userModel->getError() ?: lang('login.failed'), 'code' => 0]);
            }
            return redirect('user/index');
        }
        return redirect('passport/login');
    }
    public function send_code()
    {
        $data = $this->postData();
        $model = new UserModel;
        if(!$model->sendCode($data))
        {
            return $this->renderError([],$model->getError());
        }

        return $this->renderSuccess([],lang('send_success'));
    }

    public function forget_pass()
    {
        $model = new UserModel;
        if ($this->request->isAjax()) {
            if(!$model->resetPass($this->postData()))
            {
                return $this->renderError([],$model->getError() ?: lang('update_failed'));
            }

            return $this->renderSuccess([],lang('update_success'),url('passport/login'));

        }

        return $this->fetch('forget_pass');
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
