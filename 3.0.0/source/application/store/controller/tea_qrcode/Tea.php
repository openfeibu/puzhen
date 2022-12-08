<?php

namespace app\store\controller\tea_qrcode;

use app\store\model\Factory;
use app\store\model\Tea as TeaModel;
use app\store\model\Goods as GoodsModel;
use app\store\controller\Controller;

/**
 * 冲泡配置管理
 * Class Tea
 * @package app\store\controller
 */
class Tea extends Controller
{
    /**
     * 冲泡配置列表
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function index()
    {
        $model = new TeaModel;

        $list = $model->getList();

        return $this->fetch('index', compact('list'));

    }
    public function add()
    {
        if (!$this->request->isAjax()) {
            return $this->fetch('add');
        }
        $model = new TeaModel;
        if ($model->add($this->postData('tea'))) {
            return $this->renderSuccess('添加成功', url('tea_qrcode.tea/index'));
        }
        return $this->renderError($model->getError() ?: '添加失败');
    }

    public function edit($tea_id)
    {
        // 轮播图详情
        $model = TeaModel::detail($tea_id);
        if (!$this->request->isAjax()) {
            return $this->fetch('edit', compact('model'));
        }
        // 新增记录
        if ($model->edit($this->postData('tea'))) {
            return $this->renderSuccess('更新成功', url('tea_qrcode.tea/index'));
        }
        return $this->renderError($model->getError() ?: '更新失败');
    }
    public function delete($tea_id)
    {
        // 轮播图详情
        $model = TeaModel::detail($tea_id);
        if (!$model->delete()) {
            return $this->renderError($model->getError() ?: '删除失败');
        }
        return $this->renderSuccess('删除成功');
    }


}