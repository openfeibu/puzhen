<?php

namespace app\factory\model;

use app\common\model\Tea;
use app\store\model\TeaQrcode as TeaQrcodeModel;
use app\common\service\TeaQrCode as TeaQrCodeService;
/**
 * 冲泡码模型类
 * Class User
 * @package app\api\model
 */
class TeaQrcode extends TeaQrcodeModel
{
    public function getList($type='factory')
    {
        $params = request()->param();
        $filter = [];
        $list = $this;

        !empty($params['search']) && $filter['name'] = ['like', '%' . trim($params['search']) . '%'];

        $list = $list
            ->where($filter)
            ->order(['tea_qrcode_id' => 'desc'])
            ->paginate(15, false, [
                'query' => \request()->request()
            ]);

        // 整理列表数据并返回
        return $list;
    }



}
