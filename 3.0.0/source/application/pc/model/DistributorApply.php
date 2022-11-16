<?php

namespace app\pc\model;

use app\api\model\DistributorApply as ApiDistributorApplyModel;
use app\common\exception\BaseException;
use Lvht\GeoHash;
use app\common\model\Region;
use PHPMailer\PHPMailer\PHPMailer; //这个是发邮件的类，引入进来
use PHPMailer\PHPMailer\Exception; //这个是发邮件失败了，报出异常
/**
 * 服务网点模型
 * Class DistributorApply
 * @package app\api\model
 */
class DistributorApply extends ApiDistributorApplyModel
{

}