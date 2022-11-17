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
     * @throws BaseException
     */
    public function renew($data)
    {
        $updateData = [];
        $verifyCodeService = new VerifyCodeService();
        $this->startTrans();
        try {
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
                    if($this['phone_number']){
                        $this->error = lang('illegal_action');
                        return false;
                    }
                    validate_phone($data);
                    $this->validateExist('phone_number',$data['phone_number']);

                    if(!$verifyCodeService->checkCode($data['phone_number'],$data['code'],'user_bind_phone_number'))
                    {
                        $this->error = $verifyCodeService->getError();
                        return false;
                    }

                    $updateData['phone_number'] = $data['phone_number'];
                    break;
                case 'bind_email':
                    if($this['email']){
                        $this->error = lang('illegal_action');
                        return false;
                    }
                    validate_email($data);
                    $this->validateExist('email',$data['email']);
                    if(!$verifyCodeService->checkCode($data['email'],$data['code'],'user_bind_email'))
                    {
                        $this->error = $verifyCodeService->getError();
                        return false;
                    }
                    $updateData['email'] = $data['email'];
                    break;
                case 'set_password':
                    if($data['password'] < 6)
                    {
                        $this->error = lang('password_length');
                        return false;
                    }
                    if ($data['password'] !== $data['password_confirm']) {
                        $this->error = lang('password_confirm_error');
                        return false;
                    }
                    $updateData['password'] = fbshop_hash($data['password']);
                    break;
                case 'change_password':
                    if($data['password'] < 6)
                    {
                        $this->error = lang('password_length');
                        return false;
                    }
                    if(fbshop_hash($data['old_password']) != $this['password'])
                    {
                        $this->error = lang('old_password_error');
                        return false;
                    }
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

            $this->commit();
            return true;
        }catch (\Exception $e){
            $this->rollback();
            $this->error = $e->getMessage();
            return false;
        }

    }

    /**
     * @throws BaseException
     */
    public function resetPass($data)
    {
        if(isset($data['phone_number']))
        {
            validate_phone($data);
            $accountType = 'phone_number';
        }elseif ($data['email'])
        {
            validate_email($data);
            $accountType = 'email';
        }else{
            $this->error = lang('illegal_action');
            return false;
        }
        validate_password($data);
        $user = $this->validateExist($accountType,$data[$accountType],true);
        $verifyCodeService = new VerifyCodeService();
        if(!$verifyCodeService->checkCode($data[$accountType],$data['code'],'user_forget_pass'))
        {
            $this->error = $verifyCodeService->getError();
            return false;
        }
        $user->save([
           'password' => fbshop_hash($data['password'])
        ]);
        return true;
    }
    /**
     * @throws BaseException
     */
    public function sendCode($data)
    {
        switch ($data['code_type'])
        {
            case 'forget_pass_phone_number':
                $field = 'phone_number';
                validate_phone($data);
                $this->validateExist('phone_number',$data['phone_number'],true);
                $msgType = 'user_forget_pass';
                break;
            case 'forget_pass_email':
                $field = 'email';
                validate_email($data);
                $this->validateExist('email',$data['email'],true);
                $msgType = 'user_forget_pass';
                break;
            case 'register_phone_number':
                $field = 'phone_number';
                validate_phone($data);
                $this->validateExist('phone_number',$data['phone_number']);
                $msgType = 'user_register';
                break;
            case 'register_email':
                $field = 'email';
                validate_email($data);
                $this->validateExist('email',$data['email']);
                $msgType = 'user_register';
                break;
            case 'bind_phone_number':
                $field = 'phone_number';
                validate_phone($data);
                $this->validateExist('phone_number',$data['phone_number']);
                break;
            case 'bind_email':
                $field = 'email';
                validate_email($data);
                $this->validateExist('email',$data['email']);
                break;
            default:
                throw new BaseException(['msg' => lang('illegal_action')]);
                break;
        }
        $msgType = $msgType ?? 'user_'.$data['code_type'];
        $to = $data[$field];

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

    /**
     * @param $field
     * @param $value
     * @param $exist true,存在就报错，false，不存在就报错
     * @return array|bool|\PDOStatement|string|\think\Model|null
     * @throws BaseException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function validateExist($field,$value,$exist=false)
    {
        if ($user = self::useGlobalScope(false)->where([
            $field => $value
        ])->find()) {
            if(!$exist)
            {
                throw new BaseException(['msg' => lang($field.'_existing')]);
            }
            return $user;
        }else{
            if($exist)
            {
                throw new BaseException(['msg' => lang('account_not_existing')]);
            }
        }
    }

}