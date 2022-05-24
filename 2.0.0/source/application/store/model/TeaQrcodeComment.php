<?php

namespace app\store\model;

use app\common\model\TeaQrcodeComment as TeaQrcodeCommentModel;

/**
 * 产品评价模型
 * Class Comment
 * @package app\store\model
 */
class TeaQrcodeComment extends TeaQrcodeCommentModel
{

    /**
     * 获取评价总数量
     * @return int|string
     */
    public function getCommentTotal()
    {
        return $this->count();
    }

}