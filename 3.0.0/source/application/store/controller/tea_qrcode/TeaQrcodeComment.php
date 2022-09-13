<?php

namespace app\store\controller\tea_qrcode;

use app\store\controller\Controller;
use app\store\model\TeaQrcodeComment as TeaQrcodeCommentModel;

/**
 * 冲泡码评价评价管理
 * Class TeaQrcodeComment
 * @package app\store\controller\goods
 */
class TeaQrcodeComment extends Controller
{
    /**
     * 评价列表
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function index()
    {
        $model = new TeaQrcodeCommentModel;
        $list = $model->getList();
        return $this->fetch('index', compact('list'));
    }

    /**
     * 评价详情
     * @param $comment_id
     * @return array|mixed
     * @throws \think\exception\DbException
     */
    public function detail($comment_id)
    {
        // 评价详情
        $model = TeaQrcodeCommentModel::detail(['comment_id' => $comment_id]);
        if (!$this->request->isAjax()) {
            return $this->fetch('detail', compact('model'));
        }
        // 更新记录
        if ($model->edit($this->postData('comment'))) {
            return $this->renderSuccess('更新成功', url('tea_qrcode.tea_qrcode_comment/index'));
        }
        return $this->renderError($model->getError() ?: '更新失败');
    }

    /**
     * 删除评价
     * @param $comment_id
     * @return array
     * @throws \think\exception\DbException
     */
    public function delete($comment_id)
    {
        $model = TeaQrcodeCommentModel::get(['comment_id' => $comment_id]);
        if (!$model->delete()) {
            return $this->renderError('删除失败');
        }
        return $this->renderSuccess('删除成功');
    }

}