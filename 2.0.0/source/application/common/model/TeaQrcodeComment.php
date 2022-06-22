<?php

namespace app\common\model;

use think\Db;

/**
 * 产品评价模型
 * Class Comment
 * @package app\common\model
 */
class TeaQrcodeComment extends BaseModel
{
    protected $name = 'tea_qrcode_comment';
    protected static $is_factory = 0;
    
    /**
     * 评论的冲泡码
     * @return \think\model\relation\BelongsTo
     */
    public function teaQrcode()
    {
        return $this->belongsTo('TeaQrcode');
    }
    /**
     * 评论的冲泡码
     * @return \think\model\relation\BelongsTo
     */
    public function goods()
    {
        return $this->belongsTo('Goods');
    }
    /**
     * 我的冲泡码
     * @return \think\model\relation\BelongsTo
     */
    /*
    public function commentTeaQrcode()
    {
        return $this->belongsTo('TeaQrcodeCommentTeaQrcode','comment_tea_qrcode_id','comment_tea_qrcode_id');
    }
    */

    /**
     * 我的冲泡码
     * @return \think\model\relation\BelongsTo
     */
    public function commentTeaQrcode()
    {
        return $this->belongsTo('TeaQrcode','comment_tea_qrcode_id','tea_qrcode_id');
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
        return $this->with(['user', 'tea_qrcode','goods.image.file'])
            ->alias('comment')
            ->field('comment.*')
            ->join('tea_qrcode', 'comment.tea_qrcode_id = tea_qrcode.tea_qrcode_id')
            ->order(['comment.sort' => 'asc', 'comment.create_time' => 'desc'])
            ->paginate(15, false, [
                'query' => request()->request()
            ]);
    }
    /**
     * 评价详情
     * @param $where
     * @return TeaQrcodeComment|null
     * @throws \think\exception\DbException
     */
    public static function detail($where)
    {
        return self::get($where, ['user','tea_qrcode','comment_tea_qrcode','goods.image.file']);
    }
    /**
     * 更新记录
     * @param $data
     * @return bool
     */
    public function edit($data)
    {
        return $this->transaction(function () use ($data) {
            // 更新评论记录
            return $this->allowField(true)->save($data);
        });
    }

}