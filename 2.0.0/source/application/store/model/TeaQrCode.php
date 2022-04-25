<?php

namespace app\store\model;

use app\common\model\Tea;
use app\common\service\QrCodeService;
use Endroid\QrCode\LabelAlignment;
use Endroid\QrCode\QrCode;
use app\common\model\TeaQrCode as TeaQrCodeModel;

/**
 * 冲泡码模型类
 * Class User
 * @package app\api\model
 */
class TeaQrCode extends TeaQrCodeModel
{
    public function getList()
    {
        $params = request()->param();
        $filter = [];
        !empty($params['name']) && $filter['name'] = ['like', '%' . trim($params['name']) . '%'];

        $list =$this
            ->where($filter)
            ->order('tea_qrcode_id desc')
            ->paginate(15, false, [
                'query' => \request()->request()
            ]);
        // 整理列表数据并返回
        return $list;
    }
    public function add()
    {
        $size = 600;
        $factory_id = request()->param('factory_id','');
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

        $directory = '/factory_qrcode/'.$factory_id;
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
            'factory_id' => $factory_id,
            'user_id' => 0,
            'name' => $name,
            'data' => json_encode($data),
            'image' => $image_url,
            'detail_image' => $detail_image,
            'wxapp_id' => self::$wxapp_id
        ])->save() ;
        return $this;
    }

    public function edit($data)
    {
        $name = $data['name'];
        if($name) {
            $file = WEB_PATH . 'uploads/' . $this->getData('image');
            $image_name = basename($this->getData('image'));
            $detail_image = $this->getData('detail_image');
            if (file_exists($file)) {
                $directory = '/factory_qrcode/' . $this['factory_id'];
                $detail_image_name = 'detail-' . md5($name) . '-' . $image_name;
                $text = $this['data']['tea_name'] . '·' . $this['data']['weight'] . 'g·' . $this['data']['number'] . '泡';
                $detail_image = $directory . '/' . $detail_image_name;
                $this->generateDetailQrCode($name, $text, $detail_image, $file, $directory, $detail_image_name);
            }
            return $this->allowField(true)->save(['name' => $name,'detail_image' => $detail_image]) !== false;
        }
        return true;
    }


}
