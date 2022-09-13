<?php

namespace app\api\controller;

use app\api\model\Goods as GoodsModel;
use app\api\model\Cart as CartModel;
use app\common\service\qrcode\Goods as GoodsPoster;

/**
 * 产品控制器
 * Class Goods
 * @package app\api\controller
 */
class Goods extends Controller
{
    /**
     * 产品列表
     * @return array
     * @throws \app\common\exception\BaseException
     * @throws \think\exception\DbException
     */
    public function lists()
    {
        // 整理请求的参数
        $param = array_merge($this->request->param(), [
            'status' => 10
        ]);
        // 获取列表数据
        $model = new GoodsModel;
        $list = $model->getList($param, $this->getUser(false));
        return $this->renderSuccess(compact('list'));
    }

    /**
     * 获取产品详情
     * @param $goods_id
     * @return array
     * @throws \app\common\exception\BaseException
     * @throws \think\exception\DbException
     */
    public function detail($goods_id)
    {
        // 用户信息
        $user = $this->getUser(false);
        // 产品详情
        $model = new GoodsModel;
        $goods = $model->getDetails($goods_id, $this->getUser(false));
        if ($goods === false) {
            return $this->renderError($model->getError() ?: '产品信息不存在');
        }
        return $this->renderSuccess([
            // 产品详情
            'detail' => $goods,
            // 购物车产品总数量
            'cart_total_num' => $user ? (new CartModel($user))->getTotalNum() : 0,
        ]);
    }

    /**
     * 生成产品海报
     * @param $goods_id
     * @return array
     * @throws \app\common\exception\BaseException
     * @throws \think\exception\DbException
     * @throws \Exception
     */
    public function poster($goods_id)
    {
        // 产品详情
        $detail = GoodsModel::detail($goods_id);
        $Qrcode = new GoodsPoster($detail, $this->getUser(false));
        return $this->renderSuccess([
            'qrcode' => $Qrcode->getImage(),
        ]);
    }

}
