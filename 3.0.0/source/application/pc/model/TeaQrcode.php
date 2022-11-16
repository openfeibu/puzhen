<?php

namespace app\pc\model;

use app\api\model\TeaQrcode as ApiTeaQrcodeModel;
use app\common\model\Tea;
use think\Cache;
use app\common\library\wechat\WxUser;
use app\common\exception\BaseException;
use app\common\service\TeaQrCode as TeaQrCodeService;

/**
 * 用户模型类
 * Class User
 * @package app\api\model
 */
class TeaQrcode extends ApiTeaQrcodeModel
{

}
