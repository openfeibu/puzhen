<?php

namespace app\store\controller\wxapp;

use app\store\controller\Controller;
use app\store\model\Banner as BannerModel;
/**
 * 商品管理控制器
 * Class Goods
 * @package app\store\controller
 */
class Banner extends Controller
{
    public function index()
    {
        // 获取全部商品列表
        $model = new BannerModel;
        $list = $model->getList($this->request->param());
        // 商品分类
        return $this->fetch('index', compact('list'));
    }
    public function add()
    {
        if (!$this->request->isAjax()) {
            return $this->fetch('add');
        }
        $model = new BannerModel;
        if ($model->add($this->postData('banner'))) {
            return $this->renderSuccess('添加成功', url('wxapp.banner/index'));
        }
        return $this->renderError($model->getError() ?: '添加失败');
    }

    public function edit($banner_id)
    {
        // 门店详情
        $model = BannerModel::detail($banner_id);
        if (!$this->request->isAjax()) {
            return $this->fetch('edit', compact('model'));
        }
        // 新增记录
        if ($model->edit($this->postData('banner'))) {
            return $this->renderSuccess('更新成功', url('wxapp.banner/index'));
        }
        return $this->renderError($model->getError() ?: '更新失败');
    }
    public function delete($banner_id)
    {
        // 门店详情
        $model = BannerModel::detail($banner_id);
        if (!$model->delete()) {
            return $this->renderError($model->getError() ?: '删除失败');
        }
        return $this->renderSuccess('删除成功');
    }
}