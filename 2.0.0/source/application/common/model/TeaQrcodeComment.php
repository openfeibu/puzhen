<?php

namespace app\common\model;

use think\Db;

/**
 * 商品评价模型
 * Class Comment
 * @package app\common\model
 */
class TeaQrcodeComment extends BaseModel
{
    protected $name = 'tea_qrcode_comment';


    /**
     * 评论的冲泡码
     * @return \think\model\relation\BelongsTo
     */
    public function teaQrcode()
    {
        return $this->belongsTo('TeaQrcode');
    }

    /**
     * 我的冲泡码
     * @return \think\model\relation\BelongsTo
     */
    public function commentTeaQrcode()
    {
        return $this->belongsTo('TeaQrcodeCommentTeaQrcode','comment_tea_qrcode_id','comment_tea_qrcode_id');
    }

    /**
     * 关联用户表
     * @return \think\model\relation\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('User');
    }



    /**
     * 获取评价列表
     * @return \think\Paginator
     * @throws \think\exception\DbException
     */
    public function getList()
    {
        return $this->with(['user', 'tea_qrcode'])
            ->where('is_delete', '=', 0)
            ->order(['sort' => 'asc', 'create_time' => 'desc'])
            ->paginate(15, false, [
                'query' => request()->request()
            ]);
    }

}