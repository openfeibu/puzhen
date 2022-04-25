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
     * 订单商品
     * @return \think\model\relation\BelongsTo
     */
    public function TeaQrcode()
    {
        return $this->belongsTo('TeaQrCode');
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
     * 评价详情
     * @param $comment_id
     * @return Comment|null
     * @throws \think\exception\DbException
     */
    public static function detail($comment_id)
    {
        return self::get($comment_id, ['user', 'tea_qrcode']);
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