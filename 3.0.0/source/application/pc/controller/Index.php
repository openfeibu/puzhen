<?php

namespace app\pc\controller;
use app\common\model\UserWechatAccount;
use app\pc\model\Banner as BannerModel;
use think\Db;

class Index extends Controller
{
    public function _initialize()
    {
        parent::_initialize();
    }

    public function index()
    {
        $bannerModel = new BannerModel;
        $pcBannerList = $bannerModel->getList('pc');
        $mobileBannerList = $bannerModel->getList('mobile');
        return $this->fetch('index',compact('pcBannerList','mobileBannerList'));
    }

    public function test()
    {
        $data =  $this->getData();
        if(isset($data['key']) && $key = '123123qweqwe')
        {
            $userAll = Db::table('puzhen_user')->alias('user')->where('open_id','not null')->where('open_id','<>','')->where(function($query) {
                $query->table('puzhen_user_wechat_account')->where('puzhen_user_wechat_account.user_id','not null')->where('puzhen_user_wechat_account.user_id','<>','')->whereRaw('`puzhen_user_wechat_account`.`open_id` = `user`.`open_id`');
            },'not exists')
                ->select();
            foreach ($userAll as  $key => $user)
            {

                $userWechatAccountModel = new UserWechatAccount;
                $userWechatAccountModel->allowField(true)->save($user);
            }

        }
    }
}
