<?php

namespace app\pc\controller;

use app\pc\model\User as UserModel;
use app\pc\model\TeaQrcode as TeaQrcodeModel;
use app\pc\model\Collection as CollectionModel;
/**
 * 用户管理
 * Class User
 * @package app\api
 */
class User extends Controller
{
    protected $user;

    protected $checkLoginAction = [
        'user/renew'
    ];

    public function _initialize()
    {
        parent::_initialize();
        $this->user = $this->getUser();
        $this->assign('user',$this->user);
    }

    public function index()
    {
        $model = new TeaQrcodeModel();
        $list = $model->getList($this->user['user_id'],12);
        $teaQrCodeCount = $list->total();

        $collectionModel = new CollectionModel;
        $collectionCount = $collectionModel->where('user_id',$this->user['user_id'])->where('collectionable_type','Goods')->count();

        return $this->fetch('index',compact('list','teaQrCodeCount','collectionCount'));
    }

    /**
     * 当前用户详情
     * @return array
     * @throws \app\common\exception\BaseException
     * @throws \think\exception\DbException
     */
    public function detail()
    {
        $collectionModel = new CollectionModel;
        $collectionCount = $collectionModel->where('user_id',$this->user['user_id'])->where('collectionable_type','Goods')->count();
        $teaQrcodeModel = new TeaQrcodeModel;
        $teaQrCodeCount = $teaQrcodeModel->where('user_id',$this->user['user_id'])->count();
        return $this->fetch('detail',compact('teaQrCodeCount','collectionCount'));
    }

    /**
     * 更新当前管理员信息
     * @return array|mixed
     * @throws \think\exception\DbException
     */
    public function renew()
    {
        $model = UserModel::detail($this->pc['user']['user_id']);
        // 管理员详情
        if ($this->request->isAjax()) {
            if ($model->renew($this->postData())) {
                return $this->renderSuccess([],lang('update_success'));
            }
            return $this->renderError([],$model->getError() ?: lang('update_failed'));
        }
        return $this->fetch('renew', compact('model'));
    }

    public function send_code()
    {
        $data = $this->postData();
        $model = new UserModel;
        if(!$model->sendCode($data))
        {
            return $this->renderError([],$model->getError());
        }

        return $this->renderSuccess([],lang('send_success'));
    }
}
