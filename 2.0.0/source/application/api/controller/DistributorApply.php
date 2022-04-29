<?php

namespace app\api\controller;

use app\api\model\DistributorApply as DistributorApplyModel;

/**
 * 经销商控制器
 * Class DistributorApply
 * @package app\api\controller
 */
class DistributorApply extends Controller
{

    /**
     * 构造方法
     * @throws \app\common\exception\BaseException
     * @throws \think\exception\DbException
     */
    public function _initialize()
    {
        parent::_initialize();
        $this->user = $this->getUser();   // 用户信息
    }
    public function add()
    {
        $model = new DistributorApplyModel;
        if ($model->add($this->user, $this->request->post())) {
            return $this->renderSuccess([], '提交成功');
        }
        return $this->renderError($model->getError() ?: '提交失败');
    }
    /**
     * 详情
     * @param $apply_id
     * @return array
     * @throws \app\common\exception\BaseException
     * @throws \think\Exception
     * @throws \think\exception\DbException
     */
    public function detail($apply_id)
    {
        $detail = DistributorApplyModel::detail(['apply_id' => $apply_id,'user_id' => $this->user['user_id']]);
        return $this->renderSuccess(compact('detail'));
    }

}
