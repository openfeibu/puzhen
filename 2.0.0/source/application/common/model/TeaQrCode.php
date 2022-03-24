<?php

namespace app\common\model;

use app\common\model\user\PointsLog as PointsLogModel;

/**
 * 冲泡二维码模型类
 * Class TeaQrCode
 * @package app\common\model
 */
class TeaQrCode extends BaseModel
{
    protected $name = 'tea_qrcode';

    public function getDataAttr($value, $data)
    {
        $tea_qrcode_data = json_decode($data['data'], true);
        $tea_qrcode_data['tea_name'] = Tea::getTeaName($tea_qrcode_data['tea']);
        return $tea_qrcode_data;
    }
}