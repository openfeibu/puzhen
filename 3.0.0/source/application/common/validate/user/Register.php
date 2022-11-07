<?php
namespace app\common\validate\user;

use think\Validate;

class Register extends Validate
{
    protected $rule = [
        'email' =>  'email',
        'phone_number' =>  ['regex'=>'/^1(3[0-9]|4[01456879]|5[0-35-9]|6[2567]|7[0-8]|8[0-9]|9[0-35-9])\d{8}$/'],
        'password'=>'require|confirm',
        'code'=>'require',
    ];
    /*
    protected $message  =   [
        'email.email' => '邮箱格式错误',
        'phone_number.regex' => '手机号码格式错误',
        'password.require'     => '请输入密码',
        'password.confirm'     => '确认密码不一致',
        'code.require'     => '请输入验证码',
    ];
    */

}