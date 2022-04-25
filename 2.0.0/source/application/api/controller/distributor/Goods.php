<?php

namespace app\api\controller\distributor;

use app\api\controller\Controller;
use app\api\model\distributor\Goods as DistributorGoodsModel;

/**
 * 经销商-商品管理
 * Class Goods
 * @package app\api\controller\sharp
 */
class Goods extends Controller
{
    /**
     * 商品列表
     * @return array
     */
    public function lists()
    {
        // 整理请求的参数
        $param = array_merge($this->request->param(), [
            'status' => 10
        ]);
        // 获取列表数据
        $model = new DistributorGoodsModel;
        $list = $model->getList($param, $this->getUser(false));
        return $this->renderSuccess(compact('list'));
    }


}