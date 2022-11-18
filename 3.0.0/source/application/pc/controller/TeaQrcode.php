<?php

namespace app\pc\controller;

use app\pc\model\TeaConfig;
use app\pc\model\User as UserModel;
use app\pc\model\TeaQrcode as TeaQrcodeModel;
use app\pc\model\Tea;
use think\Session;

/**
 * 茶泡机二维码
 * Class TeaQrcode
 * @package app\api
 */
class TeaQrcode extends Controller
{
    /* @var \app\api\model\TeaQrcode $model */
    private $model;

    /**
     * 构造方法
     * @throws \app\common\exception\BaseException
     * @throws \think\exception\DbException
     */
    public function _initialize()
    {
        parent::_initialize();
        $this->model = new TeaQrcodeModel;
    }

    public function add()
    {
        if($this->request->isPost() || $this->request->isAjax()){
            $user = $this->getUser(false);
            if ($tea_qrcode = $this->model->add($user,$this->postData('tea_qrcode')))
            {
                if(!$user)
                {
                    Session::set('fbshop_pc.guest', [
                        'tea_qrcode_id' => $tea_qrcode['tea_qrcode_id'],
                    ]);
                }
                return $this->renderSuccess(['detail' => $tea_qrcode], lang('add_success'),url('tea_qrcode/detail','tea_qrcode_id='.$tea_qrcode['tea_qrcode_id']));
            }
            return $this->renderError([],$this->model->getError() ?: lang('add_failed'));
        }
        $teaList = Tea::getAll();
        $teaConfigModel = new TeaConfig;
        $teaConfig = $teaConfigModel->getList();
        return $this->fetch('add',compact('teaList','teaConfig'));
    }

    public function detail($tea_qrcode_id)
    {
        Session::set('fbshop_pc.guest', [
            'tea_qrcode_id' => $tea_qrcode_id,
        ]);
        $user = $this->getUser(false);
        $editPermission = 0;

        if($user)
        {
            $user_id = $user['user_id'];
            $detail = TeaQrcodeModel::get(compact('user_id','tea_qrcode_id'));
            $editPermission = 1;
        }else{

            $detail = TeaQrcodeModel::get(compact('tea_qrcode_id'));

            if(isset(Session::get('fbshop_pc.guest')['tea_qrcode_id']) && $tea_qrcode_id == Session::get('fbshop_pc.guest')['tea_qrcode_id'])
            {
                $editPermission = 1;
            }
        }
        $teaList = Tea::getAll();
        $teaConfigModel = new TeaConfig;
        $teaConfig = $teaConfigModel->getList();
        return $this->fetch('detail',compact('detail','editPermission','teaList','teaConfig'));
    }
    /**
     * 获取二维码详情
     * @param $tea_qrcode_id
     * @return array
     * @throws \app\common\exception\BaseException
     * @throws \think\exception\DbException
     */
    public function edit($tea_qrcode_id)
    {
        $user = $this->getUser(false);
        $editPermission = 0;

        if($user)
        {
            $user_id = $user['user_id'];
            $detail = TeaQrcodeModel::get(compact('user_id','tea_qrcode_id'));
            $editPermission = 1;
        }else{

            $detail = TeaQrcodeModel::get(compact('tea_qrcode_id'));

            if(isset(Session::get('fbshop_pc.guest')['tea_qrcode_id']) && $tea_qrcode_id == Session::get('fbshop_pc.guest')['tea_qrcode_id'])
            {
                $editPermission = 1;
            }
        }
        if(!$editPermission)
        {
            return $this->renderError([],lang('no_access'));
        }
        if($this->request->isPost() || $this->request->isAjax()) {
            if (!$detail) {
                return $this->renderError([], lang('nodata'));
            }
            if ($tea_qrcode = $this->model->add($user,$this->postData('tea_qrcode')))
            {
                if(!$user)
                {
                    $detail->delete();
                    $this->model->where('tea_qrcode_id',$tea_qrcode['tea_qrcode_id'])->update(['tea_qrcode_id' => $tea_qrcode_id]);

                    Session::set('fbshop_pc.guest', [
                        'tea_qrcode_id' => $tea_qrcode_id,
                    ]);
                }
                return $this->renderSuccess(['detail' => $tea_qrcode], lang('add_success'),url('tea_qrcode/detail','tea_qrcode_id='.$tea_qrcode_id));
            }

            return $this->renderError([],$detail->getError() ?:  lang('update_failed'));
        }
        Session::set('fbshop_pc.guest', [
            'tea_qrcode_id' => $tea_qrcode_id,
        ]);
        $teaList = Tea::getAll();
        $teaConfigModel = new TeaConfig;
        $teaConfig = $teaConfigModel->getList();
        $detail = $detail->toArray();
        return $this->fetch('edit',compact('detail','teaList','teaConfig'));
    }

    public function delete($tea_qrcode_id)
    {
        $user = $this->getUser(false);
        $editPermission = 0;
        if($user)
        {
            $user_id = $user['user_id'];
            $detail = TeaQrcodeModel::get(compact('user_id','tea_qrcode_id'));
            $editPermission = 1;
        }else{

            $detail = TeaQrcodeModel::get(compact('tea_qrcode_id'));

            if(isset(Session::get('fbshop_pc.guest')['tea_qrcode_id']) && $tea_qrcode_id == Session::get('fbshop_pc.guest')['tea_qrcode_id'])
            {
                $editPermission = 1;
            }
        }
        if(!$editPermission)
        {
            return $this->renderError([],lang('no_access'));
        }
        if (!$detail) {
            return $this->renderError($this->model->getError() ?: lang('nodata'));
        }
        if ($detail->delete()) {
            return $this->renderSuccess([], lang('delete_success'));
        }
        return $this->renderError($detail->getError() ?: lang('delete_failed'));
    }


}