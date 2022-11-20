<?php

namespace app\pc\controller;
use app\pc\model\Banner as BannerModel;

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

}
