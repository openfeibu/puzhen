<?php

namespace app\pc\controller;

use app\common\service\Message as MessageService;
use app\pc\model\user\User as UserModel;
use Illuminate\Http\Request;
use think\Lang;
use think\Session;
use app\common\service\Sms as SmsService;

/**
 * 认证
 * Class Passport
 * @package app\pc\controller
 */
class Passport extends Controller
{

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
            if ($model->login($this->postData('User'))) {
                return $this->renderSuccess(lang('passport.login.success'),$_SERVER["HTTP_REFERER"]);
            }
            return $this->renderError($model->getError() ?: lang('passport.login.failed'));
        }
        if($this->user && $this->user['is_login'])
        {
            return $this->redirect('/');
        }
        $this->view->engine->layout('layouts/passport');
        return $this->fetch('login');
    }
    public function register()
    {
        $lang = Lang::detect();
        $model = new UserModel;
        if ($this->request->isAjax()) {
            if(!$model->register($this->postData('User')))
            {
                return $this->renderError($model->getError() ?: lang('passport.register.failed'));
            }

            switch ($lang) {
                case 'zh-cn':
                    //跳到微信绑定
                    $redirect_url = url('register_second_step');
                    break;
                default :
                    $redirect_url = $_SERVER["HTTP_REFERER"];
                    break;

            }
            return $this->renderSuccess(lang('passport.register.success'),$redirect_url);

        }
    }
    //
    public function register_second_step()
    {

    }

    /**
     */
    public function send_register_sms():array
    {
        $data = $this->postData('User');
        $result = $this->validate($data,
            [
                'phone_number' =>  ['require','regex'=>'/^1(3[0-9]|4[01456879]|5[0-35-9]|6[2567]|7[0-8]|8[0-9]|9[0-35-9])\d{8}$/'],
            ],
            [
                'phone_number.require' => lang('phone_number_empty'),
                'phone_number.regex' => lang('phone_number_error'),
        ]);
        if(true !== $result){
            // 验证失败 输出错误信息
            return $this->renderError($result);
        }

        MessageService::send('user.user', [
            'msg_type' => 'user_register',
            'phone_numbers' => $data['phone_number'],
            'wxapp_id' => $this->getWxappId(),
        ]);

        return $this->renderSuccess('发送成功');
    }
    /**
     * 退出登录
     */
    public function logout()
    {
        Session::clear('fbshop_user');
        $this->redirect('passport/login');
    }

}
