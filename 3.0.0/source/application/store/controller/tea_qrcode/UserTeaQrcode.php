<?php

namespace app\store\controller\tea_qrcode;

use app\common\model\Tea;
use app\store\model\Factory;
use app\store\model\TeaQrcode as TeaQrcodeModel;
use app\store\model\Goods as GoodsModel;
use app\store\controller\Controller;

/**
 * 用户冲泡二维码管理
 * Class UserTeaQrcode
 * @package app\store\controller
 */
class UserTeaQrcode extends Controller
{
    /**
     * 冲泡二维码列表
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function index()
    {
        $model = new TeaQrcodeModel;
        $list = $model->getList('user');
        return $this->fetch('index', compact('list'));
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
        if (!$model->delete()) {
            return $this->renderError($model->getError() ?: '删除失败');
        }
        return $this->renderSuccess('删除成功');
    }

}