<?php

namespace app\api\controller;

use app\api\model\Distributor as DistributorModel;

/**
 * 服务网点控制器
 * Class Distributor
 * @package app\api\controller
 */
class Distributor extends Controller
{
    /**
     * 服务网点列表
     * @return array
     * @throws \think\exception\DbException
     */
    public function lists()
    {
        $model = new DistributorModel;
        $param = $this->request->param();
        $list = $model->getList($param);
        return $this->renderSuccess(compact('list'));
    }

    /**
     * 服务网点详情
     * @param $distributor_id
     * @return array
     * @throws \app\common\exception\BaseException
     * @throws \think\Exception
     * @throws \think\exception\DbException
     */
    public function detail($distributor_id)
    {
        $detail = DistributorModel::detail($distributor_id,$this->getUser(false));
        return $this->renderSuccess(compact('detail'));
    }

}
