<?php

namespace app\pc\model;

use app\api\model\Collection as ApiCollectionModel;
use app\common\exception\BaseException;
use app\common\library\helper;
use app\pc\model\Distributor as DistributorModel;
use app\pc\model\Goods as GoodsModel;
use app\common\model\Goods;

/**
 * 收藏模型
 * Class Collection
 * @package app\api\model
 */
class Collection extends ApiCollectionModel
{
    public static function collectionCount($user_id)
    {
        return self::alias('collection')
            ->join('goods','goods.goods_id = collection.collectionable_id')
            ->join('category','category.category_id = goods.category_id')
            ->where('category.show_web',1)
            ->where('goods.show_web',1)
            ->where('collection.user_id',$user_id)
            ->where('collectionable_type','Goods')
            ->count();
    }
}
