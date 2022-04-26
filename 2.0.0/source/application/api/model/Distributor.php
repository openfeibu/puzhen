<?php

namespace app\api\model;

use app\common\exception\BaseException;
use app\common\model\Distributor as DistributorModel;
use app\api\model\Collection as CollectionModel;
/**
 * 经销商模型
 * Class Distributor
 * @package app\api\model
 */
class Distributor extends DistributorModel
{
    /**
     * 隐藏字段
     * @var array
     */
    protected $hidden = [
        'is_delete',
        'wxapp_id',
        'create_time',
        'update_time'
    ];

    public function getList($param)
    {
        $params = array_merge([
            'longitude' => 0,
            'latitude' => 0,
            'search' => '',         // 搜索关键词
        ], $param);
        $filter = [];
        !empty($params['search']) && $filter['distributor_name'] = ['like', '%' . trim($params['search']) . '%'];

        $longitude = $params['longitude'] ? $params['longitude'] : 0 ;
        $latitude = $params['latitude'] ? $params['latitude'] : 0;
        $list =  $this->with(['image'])
            ->field("*,ROUND(  
                    6371.393 * 2 * ASIN(  
                        SQRT(  
                            POW(  
                                SIN(  
                                    (  
                                        {$latitude} * 3.1415926 / 180 - latitude * PI() / 180  
                                    ) / 2  
                                ),  
                                2  
                            ) + COS({$latitude} * 3.1415926 / 180) * COS(latitude * PI() / 180) * POW(  
                                SIN(  
                                    (  
                                        {$longitude} * 3.1415926 / 180 - longitude * PI() / 180  
                                    ) / 2  
                                ),  
                                2  
                            )  
                        )  
                    ) * 1000  
                ) AS distance")
            ->where('is_delete', '=', 0)
            ->where($filter)
            ->order(['distance' => 'asc','sort' => 'asc', 'create_time' => 'desc'])
            ->paginate(15, false, [
                'query' => \request()->request()
            ]);
        foreach ($list as &$distributor)
        {
            $distributor->distance = $latitude ? to_km($distributor['distance']) : '未知';
        }
        return $list;
    }

    public static function detail($distributor_id, $user = false)
    {
        $distributor = parent::detail($distributor_id);
        $distributor->isCollection($user,$distributor);
        return $distributor;
    }
    public function isCollection($user, $distributor)
    {
        $collectionModel = new CollectionModel;
        return $distributor['is_collection'] = !empty($user) && $collectionModel->where('user_id',$user['user_id'])->where('collectionable_type','Distributor')->where('collectionable_id',$distributor['distributor_id'])->value('collection_id') ? 1 : -1;
    }
}