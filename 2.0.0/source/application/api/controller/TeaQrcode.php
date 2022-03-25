<?php

namespace app\api\controller;

use app\api\model\User as UserModel;
use app\api\model\TeaQrCode as TeaQrCodeModel;
use app\common\model\Tea;

/**
 * 茶泡机二维码
 * Class TeaQrCode
 * @package app\api
 */
class TeaQrCode extends Controller
{
    /* @var \app\api\model\User $user */
    private $user;

    /* @var \app\api\model\TeaQrCode $model */
    private $model;

    /**
     * 构造方法
     * @throws \app\common\exception\BaseException
     * @throws \think\exception\DbException
     */
    public function _initialize()
    {
        parent::_initialize();
        $this->model = new TeaQrCodeModel;
        $user = $this->getUser();
    }
    /**
     * 列表
     * @return array
     * @throws \think\exception\DbException
     */
    public function lists()
    {
        $user = $this->getUser();
        $list = $this->model->getList($user['user_id']);
        return $this->renderSuccess(compact('list'));
    }
    public function add()
    {
        $user = $this->getUser();
        if ($tea_qrcode = $this->model->add($user['user_id']))
        {
            return $this->renderSuccess(['detail' => $tea_qrcode], '添加成功');
        }
        return $this->renderError($this->model->getError() ?: '添加失败');
    }

    public function edit($tea_qrcode_id)
    {
        $user = $this->getUser();
        $model = $this->model->detail($user['user_id'],$tea_qrcode_id);
        if ($model === false) {
            return $this->renderError($this->model->getError() ?: '数据不存在');
        }
        if ($model->edit($this->request->post())) {
            return $this->renderSuccess([], '更新成功');
        }
        return $this->renderError($model->getError() ?: '更新失败');
    }
    /**
     * 获取商品详情
     * @param $tea_qrcode_id
     * @return array
     * @throws \app\common\exception\BaseException
     * @throws \think\exception\DbException
     */
    public function detail($tea_qrcode_id)
    {
        $user = $this->getUser();
        // 商品详情
        $model = $this->model->detail($user['user_id'],$tea_qrcode_id);
        if ($model === false) {
            return $this->renderError($this->model->getError() ?: '数据不存在');
        }
        return $this->renderSuccess([
            // 商品详情
            'detail' => $model,

        ]);
    }

    public function delete($tea_qrcode_id)
    {
        $user = $this->getUser();
        $model = $this->model->detail($user['user_id'], $tea_qrcode_id);
        if ($model === false) {
            return $this->renderError($this->model->getError() ?: '数据不存在');
        }
        if ($model->delete()) {
            return $this->renderSuccess([], '删除成功');
        }
        return $this->renderError($model->getError() ?: '删除失败');
    }

}