<?php

namespace app\common\model;


/**
 * 冲泡二维码模型类
 * Class TeaQrCode
 * @package app\common\model
 */
class GoodsTeaQrCode extends BaseModel
{
    protected $name = 'goods_tea_qrcode';

    public function teaQrcode()
    {
        $module = self::getCalledModule() ?: 'common';
        return $this->belongsTo("app\\{$module}\\model\\TeaQrcode");
    }
}