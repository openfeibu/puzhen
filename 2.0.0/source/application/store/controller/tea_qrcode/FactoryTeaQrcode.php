<?php

namespace app\store\controller\tea_qrcode;

use app\common\model\Tea;
use app\store\model\Factory;
use app\store\model\TeaQrcode as TeaQrcodeModel;
use app\store\model\Goods as GoodsModel;
use app\store\controller\Controller;

/**
 * 工厂冲泡二维码管理
 * Class TeaQrcode
 * @package app\store\controller
 */
class FactoryTeaQrcode extends Controller
{
    /**
     * 冲泡二维码列表
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function index()
    {
        $model = new TeaQrcodeModel;
        $list = $model->getList('factory');
        $factoryList = Factory::getAllList();
        return $this->fetch('index', compact('list','factoryList'));
    }

    /**
     * 添加冲泡二维码
     * @param $goods_id
     * @return array|bool|mixed
     * @throws \Exception
     */
    public function add($goods_id=0)
    {
        $model = new TeaQrcodeModel;
        $goods = $goods_id ? GoodsModel::detail($goods_id) : null;
        $factory = $goods ? $goods['factory'] : Factory::detail($this->postData('tea_qrcode')['factory_id']);
        if (!$this->request->isAjax()) {
            $teaList = Tea::getAll();
            $factoryList = Factory::getAllList();
            return $this->fetch('add',compact('goods','teaList','factoryList'));
        }
        // 新增记录
        if ($model->add($this->postData('tea_qrcode'),$factory)) {
            return $this->renderSuccess('添加成功', url('index'));
        }
        return $this->renderError($model->getError() ?: '添加失败');
    }

    /**
     * 编辑冲泡二维码
     * @param $tea_qrcode_id
     * @return array|bool|mixed
     * @throws \think\exception\DbException
     */
    public function edit($tea_qrcode_id)
    {
        // 冲泡二维码详情
        $model = TeaQrcodeModel::detail($tea_qrcode_id);
        if (!$this->request->isAjax()) {
            return $this->fetch('edit', compact('model'));
        }
        // 新增记录
        if ($model->edit($this->postData('tea_qrcode'))) {
            return $this->renderSuccess('更新成功', url('index'));
        }
        return $this->renderError($model->getError() ?: '更新失败');
    }

    /**
     * 删除冲泡二维码
     * @param $tea_qrcode_id
     * @return array
     * @throws \think\exception\DbException
     */
    public function delete($tea_qrcode_id)
    {
        // 冲泡二维码详情
        $model = TeaQrcodeModel::detail($tea_qrcode_id);
        if (!$model->remove()) {
            return $this->renderError($model->getError() ?: '删除失败');
        }
        return $this->renderSuccess('删除成功');
    }
    /**
     * 批量删除冲泡二维码
     * @param $ids
     * @return array
     * @throws \think\exception\DbException
     */
    public function batchDelete($ids)
    {
        $model = new TeaQrcodeModel;
        if (!$model->batchRemove($ids)) {
            return $this->renderError($model->getError() ?: '删除失败');
        }
        return $this->renderSuccess('删除成功');
    }
}