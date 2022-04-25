<?php

namespace app\api\model;

use app\common\model\Tea;
use app\common\service\QrCodeService;
use Endroid\QrCode\LabelAlignment;
use Endroid\QrCode\QrCode;
use think\Cache;
use app\common\library\wechat\WxUser;
use app\common\exception\BaseException;
use app\common\model\TeaQrcode as TeaQrcodeModel;

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
    public function add($user)
    {
        $size = 600;
        $name = request()->param('name','');
        $url = request()->param('url','');
        $tea = request()->param('tea','');
        $weight = request()->param('weight','');
        $number = request()->param('number',0);
        $temperature = request()->param('temperature','');
        $seconds = request()->param('seconds','');

        $temperature_arr = explode(',',$temperature);
        $seconds_arr = explode(',',$seconds);
        $qrcode_url = $url.'&PZ '.$tea.' '.$weight.' '.$number.' ';
        $temperature = implode(' ',$temperature_arr);
        $second = implode(' ',$seconds_arr);

        $qrcode_url .= $temperature.' '.$second.' O';

        $data = compact('name','url','tea','weight','number','temperature_arr','seconds_arr');

        $directory = '/qrcode/'.$user['user_id'];
        $image_name = $size.'-'.md5($qrcode_url).'.png';
        $file = WEB_PATH.'uploads'.DIRECTORY_SEPARATOR.$directory.DIRECTORY_SEPARATOR.$image_name;
        $image_url = $directory.'/'.$image_name;
        if(!file_exists($file))
        {
            if (!is_dir(WEB_PATH.'uploads'.DIRECTORY_SEPARATOR.$directory)) {
                mkdir(WEB_PATH.'uploads'.DIRECTORY_SEPARATOR.$directory, 0755, true);
            }
            $qrCode = new QrCode($qrcode_url);
            $qrCode->setWriterByName('png');
            $qrCode->setSize($size);
            $qrCode->setMargin(1);
            $qrCode->setLogoPath(WEB_PATH.'assets/common/i/codelogo.jpg');
            $qrCode->setLogoSize(100,100);
            $qrCode->setEncoding('UTF-8');
            $qrCode->setRoundBlockSize(true);
            $qrCode->setValidateResult(false);
            //$qrCode->setLabel('Scan the code', 16, WEB_PATH.'/assets/common/fonts/simsun.ttc', LabelAlignment::CENTER);
            $qrCode->writeFile($file);

        }

        $detail_image_name = 'detail-'.md5($name).'-'.$image_name;
        $tea_name = Tea::getTeaName($tea);
        $text = $tea_name.'·'.$weight.'g·'.$number.'泡';
        $detail_image =  $directory.'/'.$detail_image_name;
        $this->generateDetailQrCode($name,$text,$detail_image,$file,$directory,$detail_image_name);

        $this->data([
            'user_id' => $user['user_id'],
            'name' => $name,
            'data' => json_encode($data),
            'image' => $image_url,
            'detail_image' => $detail_image,
            'wxapp_id' => self::$wxapp_id
        ])->save() ;
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
    public function edit($data)
    {
        $name = $data['name'];
        if($name) {
            $file = WEB_PATH . 'uploads/' . $this->getData('image');
            $image_name = basename($this->getData('image'));
            $detail_image = $this->getData('detail_image');
            if (file_exists($file)) {
                $directory = '/qrcode/' . $this['user_id'];
                $detail_image_name = 'detail-' . md5($name) . '-' . $image_name;
                $text = $this['data']['tea_name'] . '·' . $this['data']['weight'] . 'g·' . $this['data']['number'] . '泡';
                $detail_image = $directory . '/' . $detail_image_name;
                $this->generateDetailQrCode($name, $text, $detail_image, $file, $directory, $detail_image_name);
            }
            return $this->allowField(true)->save(['name' => $name,'detail_image' => $detail_image]) !== false;
        }
        return true;
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
