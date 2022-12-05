<?php

namespace app\api\model;

use app\common\exception\BaseException;
use app\common\model\Collection as CollectionModel;
use app\common\library\helper;
use app\api\model\Distributor as DistributorModel;
use app\api\model\Goods as GoodsModel;
use app\common\model\Goods;

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
            $model->collectionable->collection_count > 0 && $model->collectionable->setDec('collection_count');
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
            $this->collectionable->setInc('collection_count');
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
    public function getList($type, $user, $listRows=15)
    {
        switch ($type)
        {
            case 'Goods':
                $goodsModel = new GoodsModel;
                $list = $goodsModel->alias('goods')
                    ->join('category','category.category_id = goods.category_id')
                    ->with(['category', 'image.file', 'sku'])
                    ->join('collection','goods.goods_id = collection.collectionable_id')
                    ->where('collection.collectionable_type',$type)
                    ->where('collection.user_id',$user['user_id'])
                    ->where('goods.is_delete',0)
                    ->where('goods.show_web',1)
                    ->where('category.show_web',1)
                    ->where('goods.goods_status',10)
                    ->order(['collection.create_time' => 'desc'])
                    ->paginate($listRows, false, [
                        'query' => request()->request()
                    ]);

                $list = $goodsModel->setGoodsListData($list);
                !$list->isEmpty() && $list->hidden(['category', 'content', 'image', 'sku']);
                // 整理列表数据并返回
                $list = $goodsModel->setGoodsListDataFromApi($list, true, ['userInfo' => $user]);
                /*
                $list = $this->where('collectionable_type',$type)
                    ->where('user_id',$user['user_id'])
                    ->with([
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
                    // 产品主图
                    $collection['collectionable']['goods_image'] = $collection['collectionable']['image'][0]['file_path'];
                    // 产品默认规格
                    $collection['collectionable']['goods_sku'] = $collection['collectionable']['sku'][0];
                    $collection['collectionable']->hidden(['category', 'content', 'image', 'sku']);
                }
                */
                break;
            case 'Distributor':
                $longitude = request()->param('longitude') ?  request()->param('longitude') : 0 ;
                $latitude = request()->param('latitude') ? request()->param('latitude') : 0;

                $distributorModel = new DistributorModel;
                $list = $distributorModel->alias('distributor')
                    ->with(['image'])
                    ->join('collection','distributor.distributor_id = collection.collectionable_id')
                    ->where('collection.collectionable_type',$type)
                    ->where('collection.user_id',$user['user_id'])
                    ->field("*,ROUND(  
                    6371.393 * 2 * ASIN(  
                        SQRT(  
                            POW(  
                                SIN(  
                                    (  
                                        {$latitude} * 3.1415926 / 180 - distributor.latitude * PI() / 180  
                                    ) / 2  
                                ),  
                                2  
                            ) + COS({$latitude} * 3.1415926 / 180) * COS(distributor.latitude * PI() / 180) * POW(  
                                SIN(  
                                    (  
                                        {$longitude} * 3.1415926 / 180 - distributor.longitude * PI() / 180  
                                    ) / 2  
                                ),  
                                2  
                            )  
                        )  
                    ) * 1000  
                ) AS distance")
                    ->where('distributor.is_delete',0)
                    ->order(['distance' => 'asc','collection.create_time' => 'desc'])
                    ->paginate(15, false, [
                        'query' => request()->request()
                    ]);
                foreach ($list as &$distributor)
                {
                    $distributor->distance = $latitude ? to_km($distributor['distance']) : '定位未开启';
                }
                break;
        }

        return $list;

    }
}
