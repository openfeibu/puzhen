<?php

namespace app\api\controller\user;

use app\api\controller\Controller;
use app\api\model\Order as OrderModel;
use app\api\model\OrderGoods as OrderGoodsModel;
use app\api\model\Comment as CommentModel;
use app\api\model\TeaQrcodeComment as TeaQrcodeCommentModel;

/**
 * 订单评价管理
 * Class Comment
 * @package app\api\controller\user
 */
class Comment extends Controller
{
    /**
 * 待评价订单产品列表
 * @param $order_id
 * @return array
 * @throws \Exception
 * @throws \app\common\exception\BaseException
 * @throws \think\exception\DbException
 */
    public function order($order_id)
    {
        // 用户信息
        $user = $this->getUser();
        // 订单信息
        $order = OrderModel::getUserOrderDetail($order_id, $user['user_id']);
        // 验证订单是否已完成
        $model = new CommentModel;
        if (!$model->checkOrderAllowComment($order)) {
            return $this->renderError($model->getError());
        }
        // 待评价产品列表
        /* @var \think\Collection $goodsList */
        $goodsList = OrderGoodsModel::getNotCommentGoodsList($order_id);
        if ($goodsList->isEmpty()) {
            return $this->renderError('该订单没有可评价的产品');
        }
        // 提交产品评价
        if ($this->request->isPost()) {
            $post = $this->request->post('formData');
            if ($model->addForOrder($order, $goodsList, $post)) {
                return $this->renderSuccess([], '评价发表成功');
            }
            return $this->renderError($model->getError() ?: '评价发表失败');
        }
        return $this->renderSuccess(compact('goodsList'));
    }



}