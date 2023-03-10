<?php

namespace app\api\model;

use app\common\model\Tea;
use think\Cache;
use app\common\library\wechat\WxUser;
use app\common\exception\BaseException;
use app\common\model\TeaQrcode as TeaQrcodeModel;
use app\common\service\TeaQrCode as TeaQrCodeService;

/**
 * 用户模型类
 * Class User
 * @package app\api\model
 */
class TeaQrcode extends TeaQrcodeModel
{
    public function getList($user_id)
    {
        $params = request()->param();
        $filter = [];
        !empty($params['name']) && $filter['name'] = ['like', '%' . trim($params['name']) . '%'];

        $list =$this->where('user_id',$user_id)
            ->where($filter)
            ->order('tea_qrcode_id desc')
            ->paginate(15, false, [
                'query' => \request()->request()
            ]);
        // 整理列表数据并返回
        return $list;
    }
    public function add($user,$post)
    {
        $teaQrCodeService = new TeaQrCodeService($post);
        $teaQrCodeService->user = $user;

        $teaQrCodeService->generate();
        $data = $teaQrCodeService->getTeaQrcodeData();
        $data['wxapp_id'] = self::$wxapp_id;
        $this->data($data)->save();

        return $this;
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
        return self::$base_url . 'uploads' . $data['image'];
    }
    public function getDetailImageAttr($value, $data)
    {
        return self::$base_url . 'uploads' . $data['detail_image'];
    }
}
