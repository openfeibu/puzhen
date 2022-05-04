<?php

namespace app\store\controller\distributor;

use app\store\controller\Controller;
use app\store\model\Goods as GoodsModel;
use app\store\service\Goods as GoodsService;
use app\store\model\distributor\Goods as DistributorGoodsModel;
use app\store\model\Factory as FactoryModel;
use app\store\model\Category as CategoryModel;
use app\store\model\Distributor as DistributorModel;

/**
 * 服务网点商品管理
 * Class Goods
 * @package app\store\controller\distributor
 */
class Goods extends Controller
{
    /**
     * 商品列表
     * @param string $search
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function index()
    {
        $model = new DistributorGoodsModel;
        $list = $model->getList(array_merge(['status' => -1], $this->request->param()));
        // 商品分类
        $catgory = CategoryModel::getCacheTree();
        $factoryList = FactoryModel::getAllList();
        $distributorList = DistributorModel::getAllList();
        return $this->fetch('index', compact('list', 'catgory','factoryList','distributorList'));
    }
    public function add($distributor_id)
    {
        $distributor = DistributorModel::detail($distributor_id);
        if (!$this->request->isAjax()) {
            $goods_ids = $distributor->goods()->column('goods_id');
            return $this->fetch('add',compact('distributor','goods_ids'));
        }
        $model = new DistributorGoodsModel;
        // 新增记录
        if ($model->add($distributor,$this->postData('distributor_goods'))) {
            return $this->renderSuccess('添加成功', url('distributor/index'));
        }
        return $this->renderError($model->getError() ?: '添加失败');
    }


    /**
     * 删除商品
     * @param $id
     * @return array
     * @throws \think\exception\DbException
     */
    public function delete($id)
    {
        // 商品详情
        $model = DistributorGoodsModel::detail($id);

        if (!$model->delete()) {
            return $this->renderError($model->getError() ?: '删除失败');
        }
        return $this->renderSuccess('删除成功');
    }

}