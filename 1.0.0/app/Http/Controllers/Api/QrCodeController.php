<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\OutputServerMessageException;
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
    public function getQrCodes(Request $request)
    {
        $name = $request->get('name','');
        $qrcodes = QrCodeModel::when($name, function($query)use($name){
                return $query->where('name','like','%'.$name.'%');
            })->orderBy('id','desc')
            ->paginate(20);
        foreach ($qrcodes as $key => $qrcode)
        {
            $qrcodes[$key]['image'] = config('app.image_url').'/image/original'.$qrcode['image'];
            $qrcodes[$key]['data'] = json_decode($qrcode['data']);
        }
        return $this->response->success()->data($qrcodes->toArray()['data'])->json();
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
        $qrcode['data'] = json_decode($qrcode['data']);
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
                ->http_code(202)
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
    public function generateQrCode(Request $request)
    {
        $size = 800;
        $name = $request->get('name','');

        $url = $request->get('url','');
        $tea = $request->get('tea','');
        $weight = $request->get('weight','');
        $number = $request->get('number',0);
        $temperature_arr = $request->get('temperature',[]);
        $seconds = $request->get('seconds',[]);
        $qrcode_url = $url.'&PZ '.$tea.' '.$weight.' '.$number.' ';
        $temperature = implode(' ',$temperature_arr);
        $second = implode(' ',$seconds);
        $qrcode_url .=  $temperature.' '.$second.' O';
        $data = compact('name','url','tea','weight','number','temperature_arr','seconds');
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
        $qrcode = QrCodeModel::create([
            'user_id' => $user_id,
            'name' => $name,
            'data' => json_encode($data),
            'image' => $image_url,
        ]);
        return $this->response->success()->data([
            'id' => $qrcode->id,
            'qrcode' => config('app.image_url').'/image/original'.$image_url
        ])->json();

    }

}
