<?php

namespace app\factory\controller\goods;

use app\factory\controller\Controller;
use app\factory\model\Category as CategoryModel;

/**
 * 产品分类
 * Class Category
 * @package app\factory\controller\goods
 */
class Category extends Controller
{
    /**
     * 产品分类列表
     * @return mixed
     */
    public function index()
    {
        $model = new CategoryModel;
        $list = $model->getCacheTree();
        return $this->fetch('index', compact('list'));
    }

}
