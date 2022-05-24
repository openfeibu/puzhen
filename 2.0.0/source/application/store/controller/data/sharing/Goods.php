<?php

namespace app\store\controller\data\sharing;

use app\store\controller\Controller;
use app\store\model\sharing\Goods as GoodsModel;
use app\store\model\sharing\Category as CategoryModel;

/**
 * 产品数据控制器
 * Class Goods
 * @package app\store\controller\data
 */
class Goods extends Controller
{
    /* @var GoodsModel $model */
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
        $this->model = new GoodsModel;
        $this->view->engine->layout(false);
    }

    /**
     * 产品列表
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function lists()
    {
        // 产品分类
        $catgory = CategoryModel::getCacheTree();
        // 产品列表
        $list = $this->model->getList($this->request->param());
        return $this->fetch('list', compact('list', 'catgory'));
    }

}
