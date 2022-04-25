<?php

namespace app\store\controller;

use app\store\model\TeaQrcode as TeaQrcodeModel;
use app\store\model\Goods as GoodsModel;

/**
 * 冲泡二维码管理
 * Class TeaQrcode
 * @package app\store\controller
 */
class TeaQrcode extends Controller
{
    /**
     * 冲泡二维码列表
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function index()
    {
        $model = new TeaQrcodeModel;
        $list = $model->getList($this->request->get());
        return $this->fetch('index', compact('list'));
    }

    /**
     * 添加冲泡二维码
     * @param $factory_id
     * @return array|bool|mixed
     * @throws \Exception
     */
    public function add($goods_id)
    {
        $model = new TeaQrcodeModel;
        $goods = GoodsModel::detail($goods_id);
        if (!$this->request->isAjax()) {
            return $this->fetch('add',compact('goods'));
        }
        // 新增记录
        if ($model->add($this->postData('factory'))) {
            return $this->renderSuccess('添加成功', url('tea_qrcode/index'));
        }
        return $this->renderError($model->getError() ?: '添加失败');
    }

    /**
     * 编辑冲泡二维码
     * @param $factory_id
     * @return array|bool|mixed
     * @throws \think\exception\DbException
     */
    public function edit($factory_id)
    {
        // 冲泡二维码详情
        $model = TeaQrcodeModel::detail($factory_id);
        if (!$this->request->isAjax()) {
            return $this->fetch('edit', compact('model'));
        }
        // 新增记录
        if ($model->edit($this->postData('factory'))) {
            return $this->renderSuccess('更新成功', url('tea_qrcode/index'));
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
        if (!$model->delete()) {
            return $this->renderError($model->getError() ?: '删除失败');
        }
        return $this->renderSuccess('删除成功');
    }

}