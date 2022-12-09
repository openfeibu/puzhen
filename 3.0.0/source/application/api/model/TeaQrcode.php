<?php

namespace app\api\model;

use app\common\model\Tea;
use think\Cache;
use app\common\library\wechat\WxUser;
use app\common\exception\BaseException;
use app\common\model\TeaQrcode as TeaQrcodeModel;
use app\common\service\TeaQrCode as TeaQrCodeService;
use think\Session;

/**
 * 用户模型类
 * Class User
 * @package app\api\model
 */
class TeaQrcode extends TeaQrcodeModel
{
    public function getList($user_id,$listRows=15)
    {
        $params = request()->param();
        $filter = [];
        !empty($params['name']) && $filter['name'] = ['like', '%' . trim($params['name']) . '%'];

        $list =$this->where('user_id',$user_id)
            ->where($filter)
            ->order('tea_qrcode_id desc')
            ->paginate($listRows, false, [
                'query' => \request()->request()
            ]);
        // 整理列表数据并返回
        return $list;
    }
    public function add($user,$post)
    {
        $post['url'] = $post['url'] ?? 'https://api.fspuzhen.cn?type=weapp';
        $teaQrCodeService = new TeaQrCodeService($post);
        $teaQrCodeService->user = $user;
        $this->startTrans();
        try {
            $teaQrCodeService->generate();
            $data = $teaQrCodeService->getTeaQrcodeData();
            if(isset($post['en_name']) && $post['en_name'])
            {
                $post['name'] = $post['en_name'];
                $teaQrCodeService = new TeaQrCodeService($post,'en_');
                $teaQrCodeService->user = $user;
                $teaQrCodeService->generate();
                $en_data = $teaQrCodeService->getTeaQrcodeData();
                $data = array_merge($data,$en_data);
            }
            $data['wxapp_id'] = self::$wxapp_id;
            $this->data($data)->save();
            $this->commit();
            return $this;
        } catch (\Exception $e) {
            $this->error = $e->getMessage();
            $this->rollback();
            return false;
        }

    }
    /*
    public function detail($user_id,$tea_qrcode_id)
    {
        $tea_qrcode = $this->get(compact('user_id', 'tea_qrcode_id'));
        if (empty($tea_qrcode)) {
            $this->error = '很抱歉，数据不存在';
            return false;
        }
        return $tea_qrcode;
    }
    */


    public function getImageAttr($value, $data)
    {
        return  $data['image'] ? self::$base_url . 'uploads' . $data['image'] : '';
    }
    public function getEnImageAttr($value, $data)
    {
        return  $data['en_image'] ? self::$base_url . 'uploads' . $data['en_image'] : '';
    }
    public function getDetailImageAttr($value, $data)
    {
        return $data['detail_image'] ? self::$base_url . 'uploads' . $data['detail_image'] : '';
    }
    public function getEnDetailImageAttr($value, $data)
    {
        return $data['en_detail_image'] ? self::$base_url . 'uploads' . $data['en_detail_image'] : '';
    }
}
