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
        return $this->hasMany('goods_tea_qrcode');
    }
    public function factory()
    {
        return $this->belongsTo('factory');
    }
    public function user()
    {
        return $this->belongsTo('user');
    }
    public function comment()
    {
        return $this->hasMany('tea_qrcode_comment');
    }
    public function getDataAttr($value, $data)
    {
        $tea_qrcode_data = json_decode($data['data'], true);
        $tea = Tea::get(['code' => $tea_qrcode_data['tea']]);
        $tea_qrcode_data['tea_name'] = $tea['name'];
        $tea_qrcode_data['en_tea_name'] = $tea['en_name'];
        $tea_qrcode_data['name'] = $data['name'];
        return $tea_qrcode_data;
    }
    
    /**
     * @param $tea_qrcode_id
     * @return \app\common\model\TeaQrcode
     * */
    public static function detail($tea_qrcode_id)
    {
        return self::get(compact('tea_qrcode_id'));
    }
    public function remove()
    {
        $this->startTrans();
        try{
            $this->goodsTeaQrcode()->delete();
            $this->comment()->delete();
            $this->delete();
            $this->commit();
            return true;
        }catch (\Exception $e) {
            $this->error = $e->getMessage();
            $this->rollback();
            return false;
        }

    }
    public function batchRemove($ids)
    {
        $success_count = 0;
        $error_count = 0;
        $message = '';
        foreach ($ids as $id)
        {
            $this->startTrans();
            try{
                $detail = self::detail($id);
                $detail->goodsTeaQrcode()->delete();
                $detail->comment()->delete();
                $detail->delete();
                $this->commit();
                $success_count++;
            }catch (\Exception $e) {
                $error_count++;
                $this->rollback();
            }
        }
        if($success_count > 0)
        {
            $message.= "删除成功：".$success_count." 行；";
        }
        if($error_count > 0)
        {
            $message.= "删除失败：".$error_count." 行；请刷新后重试或联系技术人员";
        }
        return [
            'status' => $error_count ? false : true,
            'message' => $message
        ];
    }
    public function edit($post)
    {
        if($post['name']) {
            $post['en_name'] =  $post['en_name'] ?? '';
            $file = WEB_PATH . 'uploads/' . $this->getData('image');
            $image_name = basename($this->getData('image'));
            $directory = dirname($this->getData('image'));

            $detail_image = $this->getData('detail_image');
            $en_detail_image = $this->getData('en_detail_image');
            if (file_exists($file)) {
                $tea_data = json_decode($this->getData('data'),true);
                $data = array_merge($tea_data,$post);
                $teaQrCodeService = new TeaQrCodeService($data);
                $teaQrCodeService->setDirectory($directory);
                $teaQrCodeService->file = $file;
                //$teaQrCodeService->text = $this['data']['tea_name'] . '·' . $this['data']['weight'] . 'g·' . $this['data']['number'] . '泡';
                $teaQrCodeService->image_name = $image_name;
                $teaQrCodeService->generateDetail();
                $detail_image = $teaQrCodeService->detail_image;
                $en_detail_image = $teaQrCodeService->en_detail_image ?: $en_detail_image;
            }
            $post['detail_image'] = $detail_image;
            $post['en_detail_image'] = $post['en_name'] ? $en_detail_image : '';
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

    public function getEnDetailImageUrlAttr($value, $data)
    {
        return $data['en_detail_image'] ? self::$base_url . 'uploads' . $data['en_detail_image'] : '';
    }
}