<?php

namespace app\common\model;

use app\common\model\user\PointsLog as PointsLogModel;
use app\common\service\QrCodeService;

/**
 * 冲泡二维码模型类
 * Class TeaQrcode
 * @package app\common\model
 */
class TeaQrcodeCommentTeaQrcode extends BaseModel
{
    protected $name = 'tea_qrcode_comment_tea_qrcode';


    public function getDataAttr($value, $data)
    {
        $tea_qrcode_data = json_decode($data['data'], true);
        $tea_qrcode_data['tea_name'] = Tea::getTeaName($tea_qrcode_data['tea']);
        return $tea_qrcode_data;
    }

    public static function detail($comment_tea_qrcode_id)
    {
        return self::get(compact('comment_tea_qrcode_id'));
    }
}