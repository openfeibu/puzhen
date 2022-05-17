<?php

namespace app\common\model;

use app\common\service\TeaQrCode as TeaQrCodeService;

/**
 * 冲泡二维码模型类
 * Class TeaQrcode
 * @package app\common\model
 */
class TeaQrcode extends BaseModel
{
    protected $name = 'tea_qrcode';

    public function goodsTeaQrcode()
    {
        return $this->hasOne('goods_tea_qrcode');
    }
    public function factory()
    {
        return $this->belongsTo('factory');
    }
    public function user()
    {
        return $this->belongsTo('user');
    }
    public function getDataAttr($value, $data)
    {
        $tea_qrcode_data = json_decode($data['data'], true);
        $tea_qrcode_data['tea_name'] = Tea::getTeaName($tea_qrcode_data['tea']);
        return $tea_qrcode_data;
    }

    public static function detail($tea_qrcode_id)
    {
        return self::get(compact('tea_qrcode_id'));
    }
    public function remove()
    {
        $this->goodsTeaQrcode()->delete();
        $this->delete();
        return true;
    }
    public function edit($post)
    {
        if($post['name']) {
            $file = WEB_PATH . 'uploads/' . $this->getData('image');
            $image_name = basename($this->getData('image'));
            $directory = dirname($this->getData('image'));
            $detail_image = $this->getData('detail_image');
            if (file_exists($file)) {
                $teaQrCodeService = new TeaQrCodeService($post);
                $teaQrCodeService->setDirectory($directory);
                $teaQrCodeService->file = $file;
                $teaQrCodeService->text = $this['data']['tea_name'] . '·' . $this['data']['weight'] . 'g·' . $this['data']['number'] . '泡';
                $teaQrCodeService->detail_image_name = 'detail-' . md5($post['name']) . '-' . $image_name;
                $teaQrCodeService->generateDetail();
                $detail_image = $teaQrCodeService->detail_image;
            }
            $post['detail_image'] = $detail_image;
            //$this->allowField(true)->save(['name' => $post['name'],'detail_image' => $detail_image]) !== false;
        }

        return $this->allowField(true)->save($post) !== false;
    }
    public function getImageUrlAttr($value, $data)
    {
        return self::$base_url . 'uploads' . $data['image'];
    }
    public function getDetailImageUrlAttr($value, $data)
    {
        return self::$base_url . 'uploads' . $data['detail_image'];
    }
}