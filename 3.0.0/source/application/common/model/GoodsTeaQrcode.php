<?php

namespace app\common\model;


/**
 * 冲泡二维码模型类
 * Class TeaQrcode
 * @package app\common\model
 */
class GoodsTeaQrcode extends BaseModel
{
    protected $name = 'goods_tea_qrcode';

    public function teaQrcode()
    {
        $module = self::getCalledModule() ?: 'common';
        return $this->belongsTo("app\\{$module}\\model\\TeaQrcode");
    }
    public function goods()
    {
        $module = self::getCalledModule() ?: 'common';
        return $this->belongsTo("app\\{$module}\\model\\Goods");
    }
}