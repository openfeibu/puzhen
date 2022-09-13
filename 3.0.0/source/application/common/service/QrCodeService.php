<?php
namespace app\common\service;

use Auth;
use Log;
use File;
use Storage;
use QrCode;

class QrCodeService
{
    private $date;
    private $img;
    private $main;
    private $width;
    private $height;
    private $target;
    private $white;

    public function constr($source, $save_path)
    {
        $this->date = '' . date('Ymd') . '/';

        $this->img  = $save_path ;

        $this->main = imagecreatefromjpeg($source);

        $this->width = imagesx($this->main);

        $this->height = imagesy($this->main);

        $this->target = imagecreatetruecolor($this->width, $this->height);

        $this->white = imagecolorallocate($this->target, 255, 255, 255);

        imagefill($this->target, 0, 0, $this->white);

        imagecopyresampled($this->target, $this->main, 0, 0, 0, 0, $this->width, $this->height, $this->width, $this->height);
    }


    /**

     * 把二维码图片生成到背景图片上及文字

     * @param string $source   背景图片

     * @param string $text1   文字描述

     * @param string $child1   二维码图

     * @param integer  $text_width 文字横向位置

     * @param integer $text_height 文字高度

     * @param integer $font_size 字体大小

     * @param integer $cate1,$cate2,$cate3 颜色表

     * @param string $font    文字字体

     * @return [type]       [description]

     */

    public function generateFont($source, $save_path, $text1,  $text_width,  $text_height, $font_size = 50, $cate1 = 255, $cate2 = 250, $cate3 = 250, $font = '/assets/common/fonts/SourceHanSerif-Medium.ttc')
    {
        $this->constr($source, $save_path);

        $fontColor = imagecolorallocate($this->target, $cate1, $cate2, $cate3); //字的RGB颜色

        // 计算出文字在图片中的宽度

        $fontBox = imagettfbbox($font_size, 0, $font, $text1); //文字水平居中实质

        $txt_width=$fontBox[2]-$fontBox[0];

        // 获取文字在图片中居中的x轴

        $x = ($this->width - $txt_width) / 2;

        imagettftext($this->target, $font_size, 0, $x,  $text_height, $fontColor, $font, $text1);

        $this->createImg();

        return $this->img;
    }

    /**

     * [generateImg description]

     * @param string $source    背景图片
     * @param string $save_path 保存路径
     * @param string $code_url   二维码图片
     * @param integer $source_width 二维码横向所在位置
     * @param integer $source_height 二维码高度位置
     * @param integer $code_width  二维码宽度
     * @param integer $code_height 二维码高度
     * @return [type]        [description]

     */

    public function generateImg($source, $save_path, $code_url, $source_width, $source_height, $code_width = 600, $code_height = 600)
    {
        $this->constr($source, $save_path);

        $child1 = imagecreatefrompng($code_url);

        $code_width = $code_width > 0 ? $code_width :imagesx($child1);

        $code_height = $code_height > 0 ? $code_height : imagesy($child1);

        imagecopyresampled($this->target, $child1, $source_width, $source_height, 0, 0, $code_width, $code_height, imagesx($child1), imagesy($child1));

        imagedestroy($child1);

        $this->createImg();

        return $this->img;
    }

    public function createImg()
    {

        imagejpeg($this->target, WEB_PATH.'uploads/' . $this->img, 95);

        imagedestroy($this->main);

        imagedestroy($this->target);
    }
}
