<?php

namespace app\common\model;

use app\common\model\user\PointsLog as PointsLogModel;
use app\common\service\QrCodeService;

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
    public function generateDetailQrCode($name,$text,$detail_image,$file,$directory,$detail_image_name)
    {
        //背景图片
        $source = WEB_PATH.'assets/common/i/bg_code.jpg';
        $codeImg = new QrCodeService();
        $codeImg->generateImg($source,$detail_image, $file, $source_width = 150, $source_height= 50, $code_width = 300, $code_height = 300);
        //新文件
        $text_file = WEB_PATH.'uploads/'.$directory.DIRECTORY_SEPARATOR.$detail_image_name;
        $font = WEB_PATH.'/assets/common/fonts/simsun.ttc';
        $codeImg->generateFont($text_file,$detail_image, $name, $text_width=200, $text_height=450,$font_size = 40, $cate1 = 0, $cate2 = 0, $cate3 = 0,$font);
        $codeImg->generateFont($text_file,$detail_image,$text, $text_width=200, $text_height=500,$font_size = 20, $cate1 = 0, $cate2 = 0, $cate3 = 0,$font);

    }

    public static function detail($tea_qrcode_id)
    {
        return self::get(compact('tea_qrcode_id'));
    }
}