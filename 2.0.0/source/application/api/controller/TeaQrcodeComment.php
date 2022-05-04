<?php

namespace app\api\controller;

use app\api\model\TeaQrcodeComment as TeaQrcodeCommentModel;

/**
 * 冲泡码评价控制器
 * Class Comment
 * @package app\api\controller
 */
class TeaQrcodeComment extends Controller
{
    /**
     * 冲泡码评价列表
     * @param $tea_qrcode_id
     * @return array
     * @throws \think\exception\DbException
     */
    public function lists($tea_qrcode_id)
    {
        $model = new TeaQrcodeCommentModel;
        $list = $model->getCommentList($tea_qrcode_id);
        return $this->renderSuccess(compact('list'));
    }
    /**
     * @param $tea_qrcode_id
     * @return array
     * @throws \Exception
     * @throws \app\common\exception\BaseException
     * @throws \think\exception\DbException
     */
    public function add($tea_qrcode_id)
    {
        $model = new TeaQrcodeCommentModel;
        if ($model->add($this->getUser(), $tea_qrcode_id, $this->request->post())) {
            return $this->renderSuccess([], '评价发表成功');
        }
        return $this->renderError($model->getError() ?: '评价发表失败');
    }

    /**
     * 删除
     * @param $comment_id
     * @return array
     * @throws \app\common\exception\BaseException
     * @throws \think\exception\DbException
     */
    public function delete($comment_id)
    {
        $user = $this->getUser();
        $model = TeaQrcodeCommentModel::detail($user['user_id'], $comment_id);
        if ($model->remove()) {
            return $this->renderSuccess([], '删除成功');
        }
        return $this->renderError($model->getError() ?: '删除失败');
    }

}