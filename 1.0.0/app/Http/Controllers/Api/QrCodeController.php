<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\OutputServerMessageException;
use App\Services\QrCodeService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController;
use Auth,Log,File,Storage,QrCode;
use App\Models\User;
use App\Models\QrCode as QrCodeModel;

class QrCodeController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth.api');
    }

    public function generateQrCode(Request $request)
    {
        $size = 600;
        $name = $request->get('name','');

        $url = $request->get('url','');
        $tea = $request->get('tea','');
        $weight = $request->get('weight','');
        $number = $request->get('number',0);
        $temperature = $request->get('temperature','');
        $seconds = $request->get('seconds','');
		$temperature_arr = explode(',',$temperature);
		$seconds_arr = explode(',',$seconds);
        $qrcode_url = $url.'&PZ '.$tea.' '.$weight.' '.$number.' ';
        $temperature = implode(' ',$temperature_arr);
        $second = implode(' ',$seconds_arr);
		
        $qrcode_url .=  $temperature.' '.$second.' O';
        $data = compact('name','url','tea','weight','number','temperature_arr','seconds_arr');
        $user = User::tokenAuth();
        $user_id = $user->id;
        $directory = '/qrcode/'.$user_id;
        $image_name = $size.'-'.md5($qrcode_url).'.png';
        $file = storage_path('uploads').$directory.DIRECTORY_SEPARATOR.$image_name;
        $image_url = $directory.'/'.$image_name;
        if(!file_exists($file))
        {
            if (!Storage::exists($directory)) {
                Storage::makeDirectory($directory, 0755, true);
            }
            QrCode::format('png')
                ->size($size)
                ->margin(1)
                ->merge(storage_path('uploads').'/codelogo.jpg',0.2,true)
                ->encoding('UTF-8')
                ->generate($qrcode_url, $file);
        }

        $detail_image_name = 'detail-'.md5($name).'-'.$image_name;
        $text = config('model.qrcode.qrcode.tea')[$tea].'·'.$weight.'g·'.$number.'泡';
        $detail_image =  $directory.'/'.$detail_image_name;
        $this->generateDetailQrCode($name,$text,$detail_image,$file,$directory,$detail_image_name);

        $qrcode = QrCodeModel::create([
            'user_id' => $user_id,
            'name' => $name,
            'data' => json_encode($data),
            'image' => $image_url,
            'detail_image' => $detail_image
        ]);
        return $this->response->success()->data([
            'id' => $qrcode->id,
            'qrcode' => config('app.image_url').'/image/original'.$image_url
        ])->json();

    }
    private function generateDetailQrCode($name,$text,$detail_image,$file,$directory,$detail_image_name)
    {
        //背景图片
        $source = storage_path('uploads')."/bg_code.jpg";
        $codeImg = new QrCodeService();
        $codeImg->generateImg($source,$detail_image, $file, $source_width = 150, $source_height= 50, $code_width = 300, $code_height = 300);
        //新文件
        $text_file = storage_path('uploads').$directory.DIRECTORY_SEPARATOR.$detail_image_name;
        $font = resource_path('/assets/font/simsun.ttc');
        $codeImg->generateFont($text_file,$detail_image, $name, $text_width=200, $text_height=450,$font_size = 40, $cate1 = 0, $cate2 = 0, $cate3 = 0,$font);
        $codeImg->generateFont($text_file,$detail_image,$text, $text_width=200, $text_height=500,$font_size = 20, $cate1 = 0, $cate2 = 0, $cate3 = 0,$font);

    }
    public function updateQrCode(Request $request, $id)
    {
        $name = $request->get('name','');
        $user = User::tokenAuth();
        $qrcode = QrCodeModel::where('user_id',$user->id)
            ->where('id',$id)
            ->first();
        if(!$qrcode)
        {
            throw new ModelNotFoundException('未找到相关数据');
        }
        if($name)
        {
            $qrcode->update([
                'name' => $name
            ]);
            $file = storage_path('uploads').$qrcode['image'];
            if(file_exists($file))
            {
                $image_name = basename($qrcode['image']);
                $directory = '/qrcode/'.$user->id;
                $detail_image_name = 'detail-'.md5($name).'-'.$image_name;

                $data = json_decode($qrcode['data'],true);
                $data['tea_name'] = config('model.qrcode.qrcode.tea')[$data['tea']];

                $text = config('model.qrcode.qrcode.tea')[$data['tea']].'·'.$data['weight'].'g·'.$data['number'].'泡';
                $detail_image =  $directory.'/'.$detail_image_name;
                $this->generateDetailQrCode($name,$text,$detail_image,$file,$directory,$detail_image_name);

            }


        }
        return $this->response->message(trans('messages.success.updated', ['Module' => '二维码']))
            ->http_code(200)
            ->status('success')
            ->json();
    }
    public function getQrCodes(Request $request)
    {
        $user = User::tokenAuth();
        $name = $request->get('name','');
        $qrcodes = QrCodeModel::where('user_id',$user->id)
            ->when($name, function($query)use($name){
                return $query->where('name','like','%'.$name.'%');
            })
            ->orderBy('id','desc')
            ->paginate(20);
        foreach ($qrcodes as $key => $qrcode)
        {
            $qrcodes[$key]['image'] = config('app.image_url').'/image/original'.$qrcode['image'];
            $qrcodes[$key]['detail_image'] = config('app.image_url').'/image/original'.$qrcode['detail_image'];
            $data = json_decode($qrcode['data'],true);
            $data['tea_name'] = config('model.qrcode.qrcode.tea')[$data['tea']];
            $qrcodes[$key]['data'] = $data;
        }
        return $this->response->success()->data($qrcodes->toArray()['data'])->count($qrcodes->total())->json();
    }
    public function getQrCode(Request $request,$id)
    {
        $user = User::tokenAuth();
        $qrcode = QrCodeModel::where('user_id',$user->id)
            ->where('id',$id)
            ->first();
        if(!$qrcode)
        {
            throw new ModelNotFoundException('未找到相关数据');
        }
        $qrcode['image'] = config('app.image_url').'/image/original'.$qrcode['image'];
        $qrcode['detail_image'] = config('app.image_url').'/image/original'.$qrcode['detail_image'];
        $data = json_decode($qrcode['data'],true);
        $data['tea_name'] = config('model.qrcode.qrcode.tea')[$data['tea']];
        $qrcode['data'] = $data;
        return $this->response->success()->data($qrcode)->json();
    }
    public function destroy(Request $request, $id)
    {
        try {
            $user = User::tokenAuth();
            $qrcode = QrCodeModel::where('user_id',$user->id)
                ->where('id',$id)
                ->first();
            if($qrcode)
            {
                $qrcode->forceDelete();
            }
            return $this->response->message(trans('messages.success.deleted', ['Module' => '二维码']))
                ->http_code(200)
                ->status('success')
                ->json();

        } catch (Exception $e) {

            return $this->response->message($e->getMessage())
                ->code(400)
                ->status('error')
                ->url('')
                ->redirect();
        }
    }



}
