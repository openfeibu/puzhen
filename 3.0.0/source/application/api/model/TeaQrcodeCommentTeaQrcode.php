<?php

namespace app\api\model;

use app\common\model\TeaQrcodeCommentTeaQrcode as TeaQrcodeCommentTeaQrcodeModel;

/**
 * Class TeaQrcodeCommentTeaQrcode
 * @package app\api\model
 */
class TeaQrcodeCommentTeaQrcode extends TeaQrcodeCommentTeaQrcodeModel
{

    public function add($user)
    {

    }

    public function edit($data)
    {

    }

    public function getImageAttr($value, $data)
    {
        return self::$base_url . 'uploads' . $data['image'];
    }
    public function getDetailImageAttr($value, $data)
    {
        return self::$base_url . 'uploads' . $data['detail_image'];
    }
}
