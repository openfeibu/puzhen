<?php

namespace app\common\model;

use think\Db;

/**
 * 收藏模型
 * Class Collection
 * @package app\common\model
 */
class Collection extends BaseModel
{
    protected $name = 'collection';

    /**
     * 关联用户表
     * @return \think\model\relation\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('User');
    }

    /**
     * 获取评论对应的多态模型。
     */
    public function collectionable()
    {
        return $this->morphTo();
    }

}