<?php
namespace app\common\service;

use app\common\model\TeaConfig;
use app\common\service\QrCodeService;
use Endroid\QrCode\QrCode;
use app\common\model\Tea;

class TeaQrCode
{

    public $user;
    public $factory;
    private $post;
    private $size = 400;
    private $font = WEB_PATH.'/assets/common/fonts/SourceHanSerif-Medium.ttc';
    protected $bg = WEB_PATH.'assets/common/i/bg_code_style_1_1200.jpg';
    protected $code_left_width = 300; // 二维码离左边距离
    protected $code_width = 600;
    protected $code_height = 600;
    public $split_len = 15;
    public $data;
    public $file;
    public $en_file;
    public $directory;
    public $image_name = '';
    public $image = '';
    public $text = '';
    public $en_text = '';
    public $detail_image = '';
    public $detail_image_name = '';
    public $qrcode_url = '';
    public $prefix = '';
    private $teaConfig;
    /**
     * @var false
     */

    /**
     * 构造方法
     *
     */
    public function __construct($post,$prefix='')
    {
        $this->post = $post;
        $teaConfigModel = new TeaConfig;
        $this->teaConfig = $teaConfigModel->getList();
        $this->prefix = $prefix;
        $this->getText();
    }
    public function generate()
    {
        $this->getQrcodeUrl();
        $this->getData();
        $this->getDirectory();
        $this->getImageName();
        $this->getFile();
        $this->getImage();
        $this->getDetailImageName();
        $this->getDetailImage();
        $this->generateQrCode();
        $this->generateDetailQrCode();
    }
    public function generateDetail()
    {
        $this->getDirectory();
        $this->getDetailImageName();
        $this->getDetailImage();
        $this->generateDetailQrCode();
    }

    public function generateQrCode()
    {
        if(!isset($this->post['name']) || !$this->post['name'])
        {
            return ;
        }
        //if(!file_exists($this->file)) {
            if (!is_dir(WEB_PATH . 'uploads' . DIRECTORY_SEPARATOR . $this->directory)) {
                mkdir(WEB_PATH . 'uploads' . DIRECTORY_SEPARATOR . $this->directory, 0755, true);
            }
            $qrCode = new QrCode($this->qrcode_url);
            $qrCode->setWriterByName('png');
            $qrCode->setSize($this->size);
            $qrCode->setMargin(1);
            $qrCode->setLogoPath(WEB_PATH . 'assets/common/i/'.$this->prefix.'codelogo_20220617.jpg');
            $qrCode->setLogoSize(60, 60);
            $qrCode->setEncoding('UTF-8');
            $qrCode->setRoundBlockSize(true);
            $qrCode->setValidateResult(false);
            //$qrCode->setLabel('Scan the code', 16, WEB_PATH.'/assets/common/fonts/SourceHanSerif-Medium.ttc', LabelAlignment::CENTER);
            $qrCode->writeFile($this->file);
       // }
    }

    public function generateDetailQrCode()
    {
        if(!isset($this->post['name']) || !$this->post['name'])
        {
            return ;
        }
        //文字切割换行
        $nameArr = utf8_str_split($this->post['name'],$this->split_len);
        $bg_height = 200 - (count($nameArr)-1) * 40;
        //背景图片

        $codeImg = new QrCodeService();

        $codeImg->generateImg($this->bg,$this->detail_image, $this->file, $this->code_left_width, $bg_height, $this->code_width, $this->code_height);
        //新文件
        $text_file = WEB_PATH.'uploads'.$this->directory.DIRECTORY_SEPARATOR.$this->detail_image_name;

        $text_height = $this->code_height + $bg_height + 100;
        foreach ($nameArr as $k => $name)
        {
            $codeImg->generateFont($text_file,$this->detail_image, $name, $text_width=200, $text_height,$font_size = 54, $cate1 = 0, $cate2 = 0, $cate3 = 0, $this->font);
            $text_height += 80;
        }
        $codeImg->generateFont($text_file,$this->detail_image,$this->text, $text_width=200, $text_height,$font_size = 40, $cate1 = 0, $cate2 = 0, $cate3 = 0, $this->font);

    }

    public function getQrcodeUrl(){


        $this->post['seconds_arr'] = $this->post['seconds_arr'] ?? (is_array($this->post['seconds']) ? $this->post['seconds'] : explode(',',$this->post['seconds']));
        $this->post['temperature_arr'] = $this->post['temperature_arr'] ?? (is_array($this->post['temperature']) ? $this->post['temperature'] : explode(',',$this->post['temperature']));

        $temperature = implode(' ',$this->post['temperature_arr']);
        $second = implode(' ',$this->post['seconds_arr']);
        $this->qrcode_url = $this->post['url'].'&PZ '.$this->post['tea'].' '.$this->post['weight'].' '.$this->post['number'].' '.$temperature.' '.$second.' O';
    }

    public function getTeaQrcodeData()
    {
        return [
            'factory_id' => isset($this->factory) && $this->factory ? $this->factory['factory_id'] : 0,
            'user_id' => isset($this->user) && $this->user ? $this->user['user_id'] : 0,
            $this->prefix.'name' => $this->post['name'],
            'data' => json_encode($this->data),
            $this->prefix.'image' => $this->image,
            $this->prefix.'detail_image' => $this->detail_image,
        ] ;
    }

    public function getData()
    {
        $this->data = array(
            'url' => $this->post['url'],
            'tea' => $this->post['tea'],
            'weight' => $this->post['weight'],
            'number' => $this->post['number'],
            'temperature_arr' => $this->post['temperature_arr'],
            'seconds_arr' => $this->post['seconds_arr']
        );
    }

    public function getDirectory()
    {
        if(isset($this->directory) && $this->directory)
        {
            return $this->directory;
        }else if(isset($this->factory) && $this->factory)
        {
            $this->directory = '/factory_qrcode/'.$this->factory['factory_id'];
        }elseif(isset($this->user) && $this->user){
            $this->directory = '/qrcode/'.$this->user['user_id'];
        }else{
            $this->directory = '/qrcode/guest';
        }
        return $this->directory;
    }
    public function setDirectory($directory)
    {
        $this->directory = $directory;
    }

    public function getImageName()
    {
        if(!$this->image_name) {
            $this->image_name = $this->prefix.$this->size . '-' . md5($this->qrcode_url) . '.png';
        }
    }
    public function getFile()
    {
        $this->file = isset($this->file) && $this->file ?  $this->file : WEB_PATH.'uploads'.DIRECTORY_SEPARATOR. $this->directory .DIRECTORY_SEPARATOR.$this->image_name;
    }
    public function setFile($file)
    {
        $this->file = $file;
    }
    public function getImage()
    {
        $this->image = $this->directory.'/'.$this->image_name;
    }

    public function getText()
    {
        if(!$this->text)
        {
            $tea = Tea::get(['code' => $this->post['tea']]);
            $this->text = $tea[$this->prefix.'name'].'·'.$this->post['weight'].$this->teaConfig['weight'][$this->prefix.'unit'].'·'.$this->post['number'].$this->teaConfig['frequency'][$this->prefix.'unit'];
        }

    }

    public function getDetailImageName()
    {
        if(!$this->detail_image_name)
        {
            $this->detail_image_name = isset($this->post['name']) && $this->post['name'] ? $this->prefix.'detail-'.md5($this->post['name']).'-'.$this->image_name : '';
        }

    }
    public function getDetailImage()
    {
        if(!$this->detail_image)
        {
            $this->detail_image = isset($this->post['name']) && $this->post['name'] ?  $this->directory.'/'.$this->detail_image_name : '';
        }

    }

    public function __get($name){
        //$this->request->post()
        if(isset($this -> $name)) {

            return $this->$name;

        }

        return false;

    }

    public function __set($name, $value){

        if(isset($this -> $name)){
            $this -> $name = $value;
        }

    }
}
