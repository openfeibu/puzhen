<?php

namespace app\api\model;

use app\common\exception\BaseException;
use app\common\model\DistributorApply as DistributorApplyModel;
use Lvht\GeoHash;
use app\common\model\Region;

/**
 * 服务网点模型
 * Class DistributorApply
 * @package app\api\model
 */
class DistributorApply extends DistributorApplyModel
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

    public function getList($user_id)
    {
        $list =  $this->with(['image'])
            ->where('user_id',$user_id)
            ->order(['create_time' => 'desc'])
            ->paginate(15, false, [
                'query' => \request()->request()
            ]);
        return $list;
    }
    /**
     * 新增记录
     * @param $data
     * @return bool
     * @throws \Exception
     */
    public function add($user,$data)
    {

        return $this->transaction(function () use ($user, $data) {
            // 整理地区信息
            $region = explode(',', $data['region']);
            $data['province_id'] = $provinceId = Region::getIdByName($region[0], 1);
            $data['city_id'] = $cityId = Region::getIdByName($region[1], 2, $provinceId);
            $data['region_id'] = $regionId = Region::getIdByName($region[2], 3, $cityId);
            if (!$this->validateForm($data)) {
                return false;
            }
            // 格式化坐标信息
            $coordinate = explode(',', $data['coordinate']);
            $data['latitude'] = $coordinate[0];
            $data['longitude'] = $coordinate[1];
            // 生成geohash
            $Geohash = new Geohash;
            $data['geohash'] = $Geohash->encode($data['longitude'], $data['latitude']);
            $data['user_id'] = $user['user_id'];
            $data['wxapp_id'] = self::$wxapp_id;

            $this->allowField(true)->save($data);

            return true;
        });
    }


    /**
     * 表单验证
     * @param $data
     * @return bool
     */
    private function validateForm($data)
    {
        if (!isset($data['image_id']) || empty($data['image_id'])) {
            $this->error = '请选择图片';
            return false;
        }
        if ($data['city_id'] <= 0) {
            \log_write([
                'system_msg' => '选择的城市不存在',
                'param' => \request()->param()
            ], 'error');
            $this->error = '很抱歉，您选择的城市不存在';
            return false;
        }
        return true;
    }

}