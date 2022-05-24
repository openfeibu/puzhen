<?php

namespace app\api\model;

use app\common\exception\BaseException;
use app\common\model\TeaQrcodeComment as TeaQrcodeCommentModel;
use app\api\model\TeaQrcodeCommentTeaQrcode as TeaQrcodeCommentTeaQrcodeModel;
use app\api\model\TeaQrcode as TeaQrcodeModel;
use app\common\library\helper;

/**
 * 产品评价模型
 * Class Comment
 * @package app\api\model
 */
class TeaQrcodeComment extends TeaQrcodeCommentModel
{
    /**
     * 隐藏字段
     * @var array
     */
    protected $hidden = [
        'status',
        'sort',
        'wxapp_id',
        'update_time'
    ];

    /**
     * 关联用户表
     * @return \think\model\relation\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('User')->field(['user_id', 'nickName', 'avatarUrl']);
    }

    /**
     * 获取指定产品评价列表
     * @param $tea_qrcode_id
     * @return \think\Paginator
     * @throws \think\exception\DbException
     */
    public function getCommentList($tea_qrcode_id)
    {
        // 筛选条件
        $filter = [
            'tea_qrcode_id' => $tea_qrcode_id,
            'status' => 1,
        ];
        // 评分
        return $this->with(['user', 'commentTeaQrcode'])
            ->where($filter)
            ->order(['sort' => 'asc', 'create_time' => 'desc'])
            ->paginate(15, false, [
                'query' => request()->request()
            ]);
    }


    /**
     * 添加评价
     * @param $user
     * @param $tea_qrcode_id
     * @param $post
     * @return boolean
     * @throws \Exception
     */
    public function add($user, $tea_qrcode_id, $post)
    {
        if (empty($post['content'])) {
            $this->error = '没有输入评价内容';
            return false;
        }

        return $this->transaction(function () use ($user,$tea_qrcode_id,$post) {
            if(isset($post['comment_tea_qrcode_id']) && $post['comment_tea_qrcode_id'])
            {
                $tea_qrcode = TeaQrcodeModel::detail($post['comment_tea_qrcode_id']);

                $comment_tea_qrcode = TeaQrcodeModel::create([
                    'wxapp_id' => $tea_qrcode->wxapp_id,
                    'name' => $tea_qrcode->name,
                    'data' => $tea_qrcode->getData('data'),
                    'image' => $tea_qrcode->getData('image'),
                    'detail_image' => $tea_qrcode->getData('detail_image'),
                ]);
            }
            $this->allowField(true)->save([
                'content' => $post['content'],
                'sort' => 100,
                'status' => 1,
                'user_id' => $user['user_id'],
                'tea_qrcode_id' => $tea_qrcode_id,
                'comment_tea_qrcode_id' => isset($comment_tea_qrcode) && $comment_tea_qrcode  ? $comment_tea_qrcode->tea_qrcode_id : 0,
                'wxapp_id' => self::$wxapp_id
            ]);
            return true;
        });
    }

    /**
     * 评价详情
     * @param $where
     * @return TeaQrcodeComment|null
     * @throws \think\exception\DbException
     */
    public static function detail($where)
    {
        return self::get($where, ['user','tea_qrcode', 'comment_tea_qrcode']);
    }

    /**
     * 删除
     * @return int
     */
    public function remove()
    {
        return $this->transaction(function () {
            if($this->comment_tea_qrcode_id)
            {
                $tea_qrcode = TeaQrcodeModel::get($this->comment_tea_qrcode_id);
                $tea_qrcode->delete();
            }
            return $this->delete();
        });
    }
}
