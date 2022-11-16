<?php

namespace app\pc\controller;

use app\api\model\Category as CategoryModel;
use app\api\model\WxappCategory as WxappCategoryModel;

/**
 * 产品分类控制器
 * Class Goods
 * @package app\api\controller
 */
class Category extends Controller
{
    /**
     * 分类页面
     * @return array
     * @throws \think\exception\DbException
     */
    public function index()
    {
        if ($this->request->isAjax()) {
            // 产品分类列表
            $list = array_values(CategoryModel::getCacheTree());
            return $this->renderSuccess(compact('list'));
        }
        return $this->fetch('index');
    }

}
