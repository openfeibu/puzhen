<?php

namespace app\pc\model;

use app\common\exception\ErrorException;
use app\common\model\UserWechatAccount as UserWechatAccountModel;
use app\common\exception\BaseException;
use app\common\service\Message as MessageService;
use think\Cache;
use think\Session;
use app\common\model\User as UserModel;
use app\common\service\VerifyCode as VerifyCodeService;
use think\Validate;

/**
 * 超管后台用户模型
 * Class User
 * @package app\pc\model\user
 */
class User extends UserModel
{
    /**
     * 隐藏字段
     * @var array
     */
    protected $hidden = [
        'open_id',
        'is_delete',
        'create_time',
        'update_time'
    ];

    /**
     * 超管后台用户登录
     * @param $data
     * @return bool
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function login($data)
    {
        if(filter_var($data['account'],FILTER_VALIDATE_EMAIL))
        {
            $accountType = 'email';
        }else{
            $accountType = 'phone_number';
        }
        // 验证用户名密码是否正确
        if (!$user = $this->getLoginUser($data['account'], $data['password'], $accountType)) {
            $this->error = '登录失败, 用户名或密码错误';
            return false;
        }

        // 保存登录状态
        $this->loginState($user);
        return true;
    }
    public function register($data): bool
    {
        $accountType = $data['account_type'] ?? '';
        if(empty($data[$accountType]))
        {
            if(isset($data['phone_number'])){
                $accountType = 'phone_number';
            }elseif (isset($data['email']))
            {
                $accountType = 'number';
            }else{
                $this->error = lang($accountType.'_empty');
                return false;
            }
        }

        $validate = validate('Register','validate\\user');
        $validate->message([
            'email.email' => lang('email_error'),
            'phone_number.regex' => lang('phone_number_error'),
            'password.require'=> lang('password_empty'),
            'password.confirm' => lang('password_confirm_error'),
            'code.require' =>lang('verify_code_empty'),
        ]);
        if(!$validate->check($data)){
            $this->error = $validate->getError();
            return false;
        }

        if (self::useGlobalScope(false)->where([
            $accountType => $data[$accountType]
        ])->find()) {
            $this->error = lang('register.failed.user_existing');
            return false;
        }
        $this->startTrans();
        try {
            $verifyCodeService = new VerifyCodeService();
            if(!$verifyCodeService->checkCode($data[$accountType],$data['code'],'user_register'))
            {
                $this->error = $verifyCodeService->getError();
                return false;
            }
            $this->allowField(true)->save([
                $accountType => $data[$accountType],
                'password' => fbshop_hash($data['password']),
                'wxapp_id' =>  self::$wxapp_id ?: 10001
            ]);

            $this->commit();
            $user = self::useGlobalScope(false)->with(['wxapp'])->where([
                'user_id' => $this['user_id']
            ])->find();
            // 保存登录状态
            $this->loginState($user);
            return true;
        } catch (\Exception $e) {
            $this->error = $e->getMessage();
            $this->rollback();
            return false;
        }

    }

    /**
     * @throws BaseException
     * @throws \think\exception\PDOException
     * @throws \think\exception\DbException
     */
    public function wxRegisterBind($user, $userInfo)
    {
        $user_id = $user['user_id'];
        $this->startTrans();
        $webAccount = UserWechatAccountModel::detail(['open_id' => $userInfo['open_id'],'type' => 'web','user_id' => ['>','0']]);
        if($webAccount && self::detail(['user_id' => $webAccount['user_id']]))
        {
            $this->error = "绑定失败，该微信账号已经被绑定";
            return false;
        }
        try {
            // 查询微信用户（包含小程序，网页，公众号h5，移动应用）是否已存在
            $weappAccount = UserWechatAccountModel::detail(['union_id' => $userInfo['union_id'],'type' => 'weapp']);

            if($weappAccount){
                if($weappAccount['user_id'] && $originalUser = self::detail(['user_id' => $weappAccount['user_id']]) )
                {
                    if($weappAccount['user_id'] != $user_id)
                    {
                        //已经存在用户，删除新建的用户，合并到旧用户
                        $newUser = self::detail(['user_id' => $user['user_id']]);
                        $originalUser->save([
                            'phone_number' => $originalUser['phone_number'] ?: $newUser['phone_number'],
                            'email' => $originalUser['email'] ?: $newUser['email'],
                            'password' => $newUser['password'] ?: $originalUser['password'], //相当于密码用新密码
                        ]);
                        $user_id = $originalUser['user_id'];
                        $newUser->delete();
                        //更新登录用户
                        $this->loginState($originalUser);
                    }
                }else{
                    $weappAccount->allowField(true)->save([
                        'wxapp_id' => self::$wxapp_id,
                        'type' => 'weapp',
                        'user_id' => $user['user_id'],
                    ]);
                }
            }
            $webAccountModel = $webAccount ?: new UserWechatAccountModel();
            $webAccountModel->allowField(true)->save(array_merge($userInfo, [
                'wxapp_id' => self::$wxapp_id,
                'type' => 'web',
                'user_id' => $user_id,
            ]));
            $this->commit();
            return true;
        } catch (\Exception $e) {
            $this->rollback();
            $this->error = $e->getMessage();
            return false;
        }


    }

    /**
     * 获取登录用户信息
     * @param $user_name
     * @param $password
     * @return array|false|\PDOStatement|string|\think\Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    private function getLoginUser( $user_name, $password,$accountType)
    {
        return self::useGlobalScope(false)->with(['wxapp'])->where([
            $accountType => $user_name,
            'password' => fbshop_hash($password),
            'is_delete' => 0
        ])->find();
    }

    /**
     * 获取用户信息
     * @param $token
     * @return null|static
     * @throws \think\exception\DbException
     */
    public static function getUser($user_id)
    {
        return self::detail(['user_id' => $user_id], ['address', 'addressDefault', 'grade']);
    }
    /**
     * 更新信息
     * @param $data
     * @return bool
     */
    public function renew($data)
    {
        $updateData = [];
        switch ($data['type'])
        {
            case 'info':
                $allows = ['nickName','avatarUrl'];
                foreach ($allows as $allow)
                {
                    if(isset($data[$allow]) && $data[$allow])
                    {
                        $updateData[$allow] = $data[$allow];
                    }
                }
                break;
            case 'bind_phone_number':
                break;
            case 'bind_email':
                break;
            case 'set_password':
                if ($data['password'] !== $data['password_confirm']) {
                    $this->error = '确认密码不正确';
                    return false;
                }
                $updateData['password'] = fbshop_hash($data['password']);
                break;

        }
        // 更新管理员信息
        if ($this->save($updateData) === false) {
            return false;
        }

        Session::set('fbshop_pc.user', [
            'user_id' => $this['user_id'],
            'phone_number' => $updateData['phone_number'] ?? $this['phone_number'],
            'email' => $updateData['email'] ?? $this['email'],
            'avatarUrl' => $updateData['avatarUrl'] ?? $this['avatarUrl'],
            'nickName' => $updateData['nickName'] ?? $this['nickName'],
        ]);

        return true;
    }

    public function sendRegisterSms($data): bool
    {
        $validate = new Validate($data,
            [
                'phone_number' =>  ['require','regex'=>'/^1(3[0-9]|4[01456879]|5[0-35-9]|6[2567]|7[0-8]|8[0-9]|9[0-35-9])\d{8}$/'],
            ],
            [
                'phone_number.require' => lang('phone_number_empty'),
                'phone_number.regex' => lang('phone_number_error'),
            ]);
        if(!$validate->check($data)){
            $this->error = $validate->getError();
            return false;
        }
        if (self::useGlobalScope(false)->where([
            'phone_number' => $data['phone_number']
        ])->find()) {
            $this->error = lang('register.failed.user_existing');
            return false;
        }

        MessageService::send('user.user', [
            'msg_type' => 'user_register',
            'phone_numbers' => $data['phone_number'],
            'wxapp_id' => self::$wxapp_id,
        ]);
        return true;
    }
    public function sendRegisterEmail($data):bool
    {
        $validate = new Validate($data,
            [
                'email' =>  'require|email',
            ],
            [
                'email.require' => lang('email_empty'),
                'email.email' => lang('email_error'),
            ]);
        if(!$validate->check($data)){
            $this->error = $validate->getError();
            return false;
        }

        MessageService::send('user.user', [
            'msg_type' => 'user_register',
            'email' => $data['email'],
            'wxapp_id' => self::$wxapp_id,
        ]);
        return true;
    }

    /**
     * @throws BaseException
     */
    public function sendCode($data)
    {
        $isExist = 0;
        switch ($data['code_type'])
        {
            case 'bind_phone_number':
                $field = 'phone_number';
                $isExist = 1;
                break;
            case 'bind_email':
                $field = 'email';
                $isExist = 1;
                break;
            default:
                throw new BaseException(['msg' => '非法操作']);
                break;
        }
        $msgType = 'user_'.$data['code_type'];
        $to = $data[$field];
        $rules = []; $messages= [];
        switch ($field)
        {
            case 'email':
                $rules = [
                    'email' =>  'require|email'
                ];
                $messages = [
                    'email.require' => lang('email_empty'),
                    'email.email' => lang('email_error'),
                ];
                break;
            case 'phone_number':
                $rules = [
                    'phone_number' =>  ['require','regex'=>'/^1(3[0-9]|4[01456879]|5[0-35-9]|6[2567]|7[0-8]|8[0-9]|9[0-35-9])\d{8}$/'],
                ];
                $messages =  [
                    'phone_number.require' => lang('phone_number_empty'),
                    'phone_number.regex' => lang('phone_number_error'),
                ];
                break;
        }
        $validate = new Validate($data, $rules, $messages);
        if(!$validate->check($data)){
            $this->error = $validate->getError();
            return false;
        }
        if ($isExist && self::useGlobalScope(false)->where([
            $field => $to
        ])->find()) {
            $this->error = lang($field.'.existing');
            return false;
        }

        MessageService::send('user.user', [
            'msg_type' => $msgType,
            $field => $to,
            'wxapp_id' => self::$wxapp_id,
        ]);
        return true;
    }
    /**
     * 保存登录状态
     * @param $user
     */
    public function loginState($user)
    {
        $wxapp = $user['wxapp'];
        Session::set('fbshop_pc', [
            'user' => [
                'user_id' => $user['user_id'],
                'phone_number' => $user['phone_number'],
                'email' => $user['email'],
                'avatarUrl' => $user['avatarUrl'],
                'nickName' => $user['nickName'],
            ],
            'wxapp' => $wxapp->toArray(),
            'is_login' => true,
        ]);
    }


}