<?php

namespace app\factory\controller\data;

use app\factory\controller\Controller;
use app\factory\model\TeaQrcode as TeaQrcodeModel;
use app\factory\model\Factory as FactoryModel;

class TeaQrcode extends Controller
{
    /* @var \app\store\model\TeaQrcode $model */
    private $model;

    /**
     * 构造方法
     * @throws \app\common\exception\BaseException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function _initialize()
    {
        parent::_initialize();
        $this->model = new TeaQrcodeModel;
        $this->view->engine->layout(false);
    }

    /**
     * 商品列表
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function lists()
    {
        $model = new TeaQrcodeModel;
        $list = $model->getList('factory');
        return $this->fetch('list', compact('list'));
    }

}
