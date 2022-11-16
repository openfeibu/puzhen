<?php

namespace app\pc\controller;

use app\pc\model\Collection as CollectionModel;
use app\pc\model\TeaQrcode as TeaQrcodeModel;
/**
 * 收藏控制器
 * Class Collection
 * @package app\api\controller
 */
class Collection extends Controller
{
    protected $checkLoginAction = [
        'collection/index',
    ];
    /**
     * 收藏列表
     * @param $type
     * @return array
     * @throws \think\exception\DbException
     */
    public function index($type='Goods')
    {
        $model = new CollectionModel;
        $user = $this->getUser();
        $list = $model->getList($type, $user,12);
        $teaQrcodeModel = new TeaQrcodeModel;
        $teaQrCodeCount = $teaQrcodeModel->where('user_id',$user['user_id'])->count();

        $collectionCount = $list->count();
        return $this->fetch('index',compact('user','list','teaQrCodeCount','collectionCount'));
    }
    public function add($type)
    {
        $user = $this->getUser();
        $model = new CollectionModel;

        $res = $model->collect($type, $user, $this->request->post());
        if($res === -1 )
        {
            return $this->renderSuccess(['is_collection' => -1], lang('cancel.success'));
        }else if ($res === 1){
            return $this->renderSuccess(['is_collection' => 1], lang('collect.success'));
        }
        return $this->renderError($model->getError() ?:  lang('action.failed'));
    }

}