<?php

namespace app\api\model;

use app\common\exception\BaseException;
use app\common\model\DistributorApply as DistributorApplyModel;
use Lvht\GeoHash;
use app\common\model\Region;
use PHPMailer\PHPMailer\PHPMailer; //这个是发邮件的类，引入进来
use PHPMailer\PHPMailer\Exception; //这个是发邮件失败了，报出异常
/**
 * 服务网点模型
 * Class DistributorApply
 * @package app\api\model
 */
class DistributorApply extends DistributorApplyModel
{
    /**
     * 隐藏字段
     * @var array
     */
    protected $hidden = [
        'is_delete',
        'wxapp_id',
        'create_time',
        'update_time'
    ];

    public function getList($user_id)
    {
        $list =  $this->with(['image'])
            ->where('user_id',$user_id)
            ->order(['create_time' => 'desc'])
            ->paginate(15, false, [
                'query' => \request()->request()
            ]);
        return $list;
    }
    /**
     * 新增记录
     * @param $data
     * @return bool
     * @throws \Exception
     */
    public function add($user,$data)
    {

        return $this->transaction(function () use ($user, $data) {
            if (!$this->validateForm($data)) {
                return false;
            }
            // 整理地区信息
            /*
            $region = explode(',', $data['region']);
            $data['province_id'] = $provinceId = Region::getIdByName($region[0], 1);
            $data['city_id'] = $cityId = Region::getIdByName($region[1], 2, $provinceId);
            $data['region_id'] = $regionId = Region::getIdByName($region[2], 3, $cityId);
            if (!$this->validateForm($data)) {
                return false;
            }
            // 格式化坐标信息
            $coordinate = explode(',', $data['coordinate']);
            $data['latitude'] = $coordinate[0];
            $data['longitude'] = $coordinate[1];
            // 生成geohash
            $Geohash = new Geohash;
            $data['geohash'] = $Geohash->encode($data['longitude'], $data['latitude']);
            */
            $data['user_id'] = $user['user_id'];
            $data['wxapp_id'] = self::$wxapp_id;

            $this->allowField(true)->save($data);
            // 记录凭证图片关系
            if (isset($data['images']) && !empty($data['images'])) {
                $this->saveImages($this['apply_id'], $data['images']);
            }
            /*
            $mail = new PHPMailer(true); //实例化加载这个类，如果说邮件发送失败了，可以抛出异常
            //开发环境下，是需要打开异常抛出的，实际情况下可以false关闭
            try {
                $mail->SMTPDebug = 0;        //这里是调试模式，2的话表示详细错误信息，1的话是简要错误信息，0的话是不显示错误信息。 启用详细的调试输出
                $mail->isSMTP();                     // 设置邮件使用SMTP
                $mail->Host = 'smtp.163.com';        // 指定主和备份SMTP服务器
                $mail->SMTPAuth = true;                               // 使SMTP认证
                $mail->Username = 'B18029210246@163.com';             // SMTP用户名
                $mail->Password = 'HFLUCCHERIOBJJOB';                 // SMTP 密码,
                $mail->SMTPSecure = 'ssl';                            // 启用TLS加密，也接受“ssl”
                $mail->Port = 465;                                    // 要连接的TCP端口
                $mail->CharSet = 'utf-8';                             //要发送的内容格式

                //Recipients
                $mail->setFrom('B18029210246@163.com', '朴真服务'); //发邮件人
                $mail->addAddress('1270864834@qq.com', '朴真服务');    //收件人，可以设置好几个

                $mail->isHTML(true);                                  // 设置电子邮件格式为HTML
                $mail->Subject = "服务网点申请";
                $mail->Body    = "您有新的服务网点申请，请到系统上查看。";
                //  $mail->AltBody='发送错误';          //表示isHTML发送失败，就发送这个内容。

                $mail->send();       //这里是发送方法
            }catch (Exception $e) {
                //exception($mail->ErrorInfo(), 1001);
            }
            */
            return true;
        });
    }
    private function saveImages($apply_id, $images)
    {
        // 生成评价图片数据
        $data = [];
        foreach (explode(',', $images) as $image_id) {
            $data[] = [
                'apply_id' => $apply_id,
                'image_id' => $image_id,
                'wxapp_id' => self::$wxapp_id
            ];
        }
        return !empty($data) && (new DistributorApplyImage)->saveAll($data);
    }

    /**
     * 表单验证
     * @param $data
     * @return bool
     */
    private function validateForm($data)
    {
        if (!isset($data['distributor_name']) || empty($data['distributor_name'])) {
            $this->error = '服务网点名称不能为空';
            return false;
        }
        /*
        if (!isset($data['image_id']) || empty($data['image_id'])) {
            $this->error = '请选择图片';
            return false;
        }
        if ($data['city_id'] <= 0) {
            \log_write([
                'system_msg' => '选择的城市不存在',
                'param' => \request()->param()
            ], 'error');
            $this->error = '很抱歉，您选择的城市不存在';
            return false;
        }
        */
        return true;

    }

}