<?php

namespace app\pc\controller;

use app\pc\model\Category as CategoryModel;
use app\pc\model\Goods as GoodsModel;
use app\pc\model\Cart as CartModel;
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
    public function index()
    {
        //var_dump(getCategoryIdBySlug('tea_machine'));exit;
        $param = array_merge($this->request->param(), [
            'status' => 10,
            'listRows' => 12,
        ]);
        $param['category_id'] = isset($param['category_id']) &&  $param['category_id'] ? $param['category_id'] : 0;
        $isAutoId = true;
        if(isset($param['search']) && $param['search'])
        {
            $param['category_id'] = 0;
            $isAutoId = false;
        }
        $categoryList = CategoryModel::getCacheTreeActive($param['category_id'],$isAutoId);

        if ($this->request->isAjax()) {
            // 获取列表数据
            $model = new GoodsModel;
            $list = $model->getList($param, $this->getUser(false));
            $this->view->engine->layout(false);
            return $this->fetch('list_content',compact('list'));
        }

        return $this->fetch('index',compact('categoryList','param'));
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
        $goods = $model->getDetails($goods_id, $user);
        $recommend_list = $model->getRecommend([], $user);

        return $this->fetch('detail',[
            // 产品详情
            'detail' => $goods,
            'recommend_list' => $recommend_list,
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
