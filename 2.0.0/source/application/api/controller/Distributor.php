<?php

namespace app\api\controller;

use app\api\model\Distributor as DistributorModel;

/**
 * 经销商控制器
 * Class Distributor
 * @package app\api\controller
 */
class Distributor extends Controller
{
    /**
     * 经销商列表
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
     * 经销商详情
     * @param $article_id
     * @return array
     * @throws \app\common\exception\BaseException
     * @throws \think\Exception
     * @throws \think\exception\DbException
     */
    public function detail($article_id)
    {
        $detail = DistributorModel::detail($article_id);
        return $this->renderSuccess(compact('detail'));
    }

}
