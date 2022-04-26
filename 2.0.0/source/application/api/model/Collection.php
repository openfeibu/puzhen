<?php

namespace app\api\model;

use app\common\exception\BaseException;
use app\common\model\Collection as CollectionModel;
use app\common\library\helper;

/**
 * 收藏模型
 * Class Collection
 * @package app\api\model
 */
class Collection extends CollectionModel
{
    /**
     * 隐藏字段
     * @var array
     */
    protected $hidden = [
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

    public function collect($type, $user, $data)
    {
        $model = $this->where('collectionable_type',$type)
            ->where('user_id',$user['user_id'])
            ->where('collectionable_id',$data['id'])
            ->find();
        if($model)
        {
            $model->delete();
            return -1;
        }else
        {
            $this->allowField(true)->save([
                'user_id' => $user['user_id'],
                'collectionable_id' => $data['id'],
                'collectionable_type' => $type,
                'wxapp_id' => self::$wxapp_id
            ]);
            return 1;
        }
    }

    /**
     * 获取列表
     * @param $type
     * @param $user
     * @return \think\Paginator
     * @throws \think\exception\DbException
     */
    public function getList($type, $user)
    {

        $list = $this->where('collectionable_type',$type)->where('user_id',$user['user_id']);

        switch ($type)
        {
            case 'Goods':
                $list = $list->with([
                        'collectionable' => [
                            'image.file',
                            'category', 'image.file', 'sku',
                        ]
                    ])
                    ->order(['create_time' => 'desc'])
                    ->paginate(15, false, [
                        'query' => request()->request()
                    ]);
                foreach ($list as &$collection)
                {
                    // 商品主图
                    $collection['collectionable']['goods_image'] = $collection['collectionable']['image'][0]['file_path'];
                    // 商品默认规格
                    $collection['collectionable']['goods_sku'] = $collection['collectionable']['sku'][0];
                    $collection['collectionable']->hidden(['category', 'content', 'image', 'sku']);
                }
                break;
            case 'Distributor':
                $list = $list->with([
                    'collectionable' => [
                        'image',
                    ]
                ])
                    ->order(['create_time' => 'desc'])
                    ->paginate(20, false, [
                        'query' => request()->request()
                    ]);
                break;
        }

        return $list;

    }
}
