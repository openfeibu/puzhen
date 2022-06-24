<?php

namespace app\factory\controller;

use app\factory\model\Factory as FactoryModel;
use app\factory\model\Goods as GoodsModel;
use app\factory\model\Category as CategoryModel;
use app\store\service\Goods as GoodsService;
use app\factory\model\TeaQrcode as TeaQrcodeModel;
use app\factory\service\goods\Import as GoodsImport;

/**
 * 产品管理控制器
 * Class Goods
 * @package app\factory\controller
 */
class Goods extends Controller
{
    /**
     * 产品列表(出售中)
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function index()
    {
        // 获取全部产品列表
        $model = new GoodsModel;
        $list = $model->getList(array_merge(['status' => -1], $this->request->param()));
        // 产品分类
        $catgory = CategoryModel::getCacheTree();
        return $this->fetch('index', compact('list', 'catgory'));
    }

    /**
     * 添加产品
     * @return array|mixed
     * @throws \think\exception\PDOException
     */
    public function add()
    {
        if (!$this->request->isAjax()) {
            return $this->fetch(
                'add',
                array_merge(GoodsService::getEditData(null, 'add'))
            );
        }
        $model = new GoodsModel;
        if ($model->add($this->postData('goods'))) {
            return $this->renderSuccess('添加成功', url('goods/index'));
        }
        return $this->renderError($model->getError() ?: '添加失败');
    }

    /**
     * 一键复制
     * @param $goods_id
     * @return array|mixed
     * @throws \think\exception\PDOException
     */
    public function copy($goods_id)
    {
        // 产品详情
        $model = GoodsModel::detail($goods_id);
        if (!$this->request->isAjax()) {
            return $this->fetch(
                'edit',
                array_merge(GoodsService::getEditData($model, 'copy'), compact('model'))
            );
        }
        $model = new GoodsModel;
        if ($model->add($this->postData('goods'))) {
            return $this->renderSuccess('添加成功', url('goods/index'));
        }
        return $this->renderError($model->getError() ?: '添加失败');
    }

    /**
     * 产品编辑
     * @param $goods_id
     * @return array|bool|mixed
     */
    public function edit($goods_id)
    {
        // 产品详情
        $model = GoodsModel::detail($goods_id);
        if (!$this->request->isAjax()) {
            return $this->fetch(
                'edit',
                array_merge(GoodsService::getEditData($model), compact('model'))
            );
        }
        // 更新记录
        if ($model->edit($this->postData('goods'))) {
            return $this->renderSuccess('更新成功', url('goods/index'));
        }
        return $this->renderError($model->getError() ?: '更新失败');
    }

    /**
     * 修改产品状态
     * @param $goods_id
     * @param boolean $state
     * @return array
     */
    public function state($goods_id, $state)
    {
        // 产品详情
        $model = GoodsModel::detail($goods_id);
        if (!$model->setStatus($state)) {
            return $this->renderError('操作失败');
        }
        return $this->renderSuccess('操作成功');
    }

    /**
     * 删除产品
     * @param $goods_id
     * @return array
     */
    public function delete($goods_id)
    {
        // 产品详情
        $model = GoodsModel::detail($goods_id);
        if (!$model->setDelete()) {
            return $this->renderError($model->getError() ?: '删除失败');
        }
        return $this->renderSuccess('删除成功');
    }
    /**
     * 添加冲泡二维码
     * @param $goods_id
     * @return array|bool|mixed
     * @throws \Exception
     */
    public function bind_tea_qrcode($goods_id)
    {
        $model = new TeaQrcodeModel;
        $goods = GoodsModel::detail($goods_id);
        if (!$this->request->isAjax()) {
            return $this->fetch('bind_tea_qrcode',compact('goods','teaList'));
        }
        // 新增记录
        if ($model->bindTeaQrcode($this->postData('tea_qrcode'),$goods['factory_id'])) {
            return $this->renderSuccess('添加成功', url('index'));
        }
        return $this->renderError($model->getError() ?: '添加失败');
    }

    /**
     * 导入产品
     */
    public function import()
    {
        $import = new GoodsImport;
        if ($this->request->isGet()) {
            return $this->fetch('import',
                array_merge(GoodsService::getEditData(null, 'add'))
            );
        }
        if ($import->goodsList($this->factory['factory']['factory_id'])) {
            return $this->renderSuccess('添加成功', url('index'));
        }
        return $this->renderError($import->getError() ?: '添加失败');
    }
}
