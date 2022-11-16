<?php

namespace app\pc\controller;


use app\common\exception\BaseException;
use app\common\exception\NotAuthException;
use app\pc\model\Wxapp as WxappModel;
use app\pc\model\User as UserModel;
use app\pc\model\Setting;
use think\Cookie;
use think\Lang;
use think\Request;
use think\Session;

/**
 * 商户后台控制器基类
 * Class BaseController
 * @package app\pc\controller
 */
class Controller extends \think\Controller
{
    /* @ver $wxapp_id 小程序id */
    protected $wxapp_id;

    /** @var string $route 当前控制器名称 */
    protected $controller = '';

    /** @var string $route 当前方法名称 */
    protected $action = '';

    /** @var string $route 当前路由uri */
    protected $routeUri = '';

    protected $pc;

    /** @var string $route 当前路由：分组名称 */
    protected $group = '';

    /** @var array $allowAllAction 登录验证白名单 */
    protected $allowAllAction = [
        // 登录页面
        'passport/login',
        'passport/register',
        'passport/send_register_sms',
        'passport/send_register_email',
        //'passport/register_weixin_web_bind',

    ];
    protected $checkLoginAction= [
        'passport/register_weixin_web_bind',
    ];

    /* @var array $notLayoutAction 无需全局layout */
    protected $notLayoutAction = [
        // 登录页面
        'passport/login',
    ];

    /**
     * 后台初始化
     * @throws BaseException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function _initialize()
    {
        // 当前小程序id
        $this->wxapp_id = $this->getWxappId();
        // 用户登录信息
        $this->pc = Session::get('fbshop_pc');
        // 验证当前小程序状态
        $this->checkWxapp();
        // 当前路由信息
        $this->getRouteinfo();
        // 验证登录
        $this->checkLogin();
        // 全局layout
        $this->layout();

        if(!(Cookie::has('think_var'))){
            $this->lang();
        }
        $this->assign('think_lang',Cookie::get('think_var'));
        $this->assign('wxapp_id', $this->wxapp_id);
        $this->assign('lang_arr', json_encode(Lang::get()));
    }

    /**
     * 全局layout模板输出
     * @throws \think\exception\DbException
     * @throws \Exception
     */
    private function layout()
    {
        // 验证当前请求是否在白名单
        if (!in_array($this->routeUri, $this->notLayoutAction)) {
            // 输出到view
            $this->assign([
                'base_url' => base_url(),                      // 当前域名
                'pc_url' => url('/pc'),              // 模块url
                'group' => $this->group,                       // 当前控制器分组
                'request' => Request::instance(),              // Request对象
                'setting' => Setting::getAll() ?: null,
                'version' => get_version(),                    // 系统版本号
                'pc' => $this->pc,
                'routeUri' => $this->routeUri,
            ]);
        }
    }

    /**
     * 解析当前路由参数 （分组名称、控制器名称、方法名）
     */
    protected function getRouteinfo()
    {
        // 控制器名称
        $this->controller = toUnderScore($this->request->controller());
        // 方法名称
        $this->action = $this->request->action();
        // 控制器分组 (用于定义所属模块)
        $groupstr = strstr($this->controller, '.', true);
        $this->group = $groupstr !== false ? $groupstr : $this->controller;
        // 当前uri
        $this->routeUri = $this->controller . '/' . $this->action;
    }

    /**
     * 获取当前wxapp_id
     */
    protected function getWxappId()
    {
        if (!$wxapp_id = $this->request->param('wxapp_id','10001')) {
            throw new BaseException(['msg' => '缺少必要的参数：wxapp_id']);
        }
        return $wxapp_id;
    }


    /**
     * 验证当前小程序状态
     * @throws BaseException
     * @throws \think\exception\DbException
     */
    private function checkWxapp()
    {
        $wxapp = WxappModel::detail($this->wxapp_id);
        if (empty($wxapp)) {
            throw new BaseException(['msg' => '当前小程序信息不存在']);
        }
        if ($wxapp['is_recycle'] || $wxapp['is_delete']) {
            throw new BaseException(['msg' => '当前小程序已删除']);
        }
    }
    /**
     * 验证登录状态
     * @return bool
     */
    protected function checkLogin()
    {
        // 验证当前请求是否在白名单
        if (in_array($this->routeUri, $this->allowAllAction)) {
            return true;
        }

        if(in_array($this->routeUri, $this->checkLoginAction))
        {
            // 验证登录状态
            if (empty($this->pc)
                || (int)$this->pc['is_login'] !== 1
            ) {
                throw new NotAuthException(['msg' => '未登录']);
            }
            return true;
        }
        return true;
    }

    /**
     * 获取当前用户信息
     * @param bool $is_force
     * @return UserModel|bool|null
     * @throws BaseException
     * @throws \think\exception\DbException
     */
    protected function getUser($is_force = true)
    {
        if ($is_force) {
            // 验证登录状态
            if (empty($this->pc)
                || (int)$this->pc['is_login'] !== 1
            ) {
                throw new NotAuthException(['msg' => '未登录']);
            }
        }
        if (!$user = UserModel::getUser($this->pc['user']['user_id'])) {
            if($is_force){
                throw new NotAuthException(['msg' => '没有找到用户信息']);
            }
            return false;
        }
        return $user;
    }
    /**
     * 输出错误信息
     * @param int $code
     * @param $msg
     * @throws BaseException
     */
    protected function throwError($msg, $code = 0)
    {
        throw new BaseException(['code' => $code, 'msg' => $msg]);
    }

    /**
     * 返回封装后的 API 数据到客户端
     * @param int $code
     * @param string $msg
     * @param string $url
     * @param array $data
     * @return array
     */
    protected function renderJson($code = 1, $msg = '', $url = '', $data = [])
    {
        return compact('code', 'msg', 'url', 'data');
    }

    /**
     * 返回操作成功json
     * @param string $msg
     * @param string $url
     * @param array $data
     * @return array
     */
    protected function renderSuccess($data = [], $msg = 'success', $url = '')
    {
        return $this->renderJson(1, $msg, $url, $data);
    }

    /**
     * 返回操作失败json
     * @param string $msg
     * @param string $url
     * @param array $data
     * @return array|bool
     */
    protected function renderError($data = [], $msg = 'error', $url = '')
    {
        return $this->renderJson(0, $msg, $url, $data);
    }

    /**
     * 获取post数据 (数组)
     * @param $key
     * @return mixed
     */
    protected function postData($key = null)
    {
        return $this->request->post(is_null($key) ? '' : $key . '/a');
    }

    /**
     * 获取post数据 (数组)
     * @param $key
     * @return mixed
     */
    protected function getData($key = null)
    {
        return $this->request->get(is_null($key) ? '' : $key);
    }

    public function  lang()
    {
        $lang = input('?get.lang') ?  input('get.lang') : 'cn';
        switch ($lang) {
            case 'en':
                cookie('think_var', 'en-us');
                break;
            case 'cn':
            default:
                cookie('think_var', 'zh-cn');
                break;
        }
    }

}
