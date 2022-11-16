<?php

namespace app\common\enum;

/**
 * 商城设置枚举类
 * Class Setting
 * @package app\common\enum
 */
class Setting extends EnumBasics
{
    // 商城设置
    const STORE = 'store';

    // 网站设置
    const PC = 'pc';
  
    // 保修包换设置
    const WARRANTY = 'warranty';
  
    // 交易设置
    const TRADE = 'trade';

    // 短信通知
    const SMS = 'sms';

    // 邮件通知
    const EMAIL = 'email';

    // // 模板消息
    // const TPL_MSG = 'tplMsg';

    // 上传设置
    const STORAGE = 'storage';

    // 小票打印
    const PRINTER = 'printer';

    // 满额包邮设置
    const FULL_FREE = 'full_free';

    // 充值设置
    const RECHARGE = 'recharge';

    // 积分设置
    const POINTS = 'points';

    // 订阅消息设置
    const SUBMSG = 'submsg';

    /**
     * 获取订单类型值
     * @return array
     */
    public static function data()
    {
        return [
            self::STORE => [
                'value' => self::STORE,
                'describe' => '商城设置',
            ],
            self::PC => [
                'value' => self::PC,
                'describe' => '网站设置',
            ],
            self::WARRANTY => [
              'value' => self::WARRANTY,
              'describe' => '保修包换设置',
            ],
            self::TRADE => [
                'value' => self::TRADE,
                'describe' => '交易设置',
            ],
            self::SMS => [
                'value' => self::SMS,
                'describe' => '短信通知',
            ],
            self::EMAIL => [
                'value' => self::EMAIL,
                'describe' => '短信通知',
            ],
            // self::TPL_MSG => [
            //     'value' => self::TPL_MSG,
            //     'describe' => '模板消息',
            // ],
            self::STORAGE => [
                'value' => self::STORAGE,
                'describe' => '上传设置',
            ],
            self::PRINTER => [
                'value' => self::PRINTER,
                'describe' => '小票打印',
            ],
            self::FULL_FREE => [
                'value' => self::FULL_FREE,
                'describe' => '满额包邮设置',
            ],
            self::RECHARGE => [
                'value' => self::RECHARGE,
                'describe' => '充值设置',
            ],
            self::POINTS => [
                'value' => self::POINTS,
                'describe' => '积分设置',
            ],
            self::SUBMSG => [
                'value' => self::SUBMSG,
                'describe' => '小程序订阅消息',
            ],
        ];
    }

}