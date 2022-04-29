<?php

namespace app\common\model;

use app\common\model\BaseModel;
use app\common\model\Region as RegionModel;

/**
 * 经销商模型
 * Class DistributorApply
 * @package app\common\model
 */
class DistributorApply extends BaseModel
{
    protected $name = 'distributor_apply';

    /**
     * 关联封面图
     * @return \think\model\relation\HasOne
     */
    public function image()
    {
        $module = self::getCalledModule() ?: 'common';
        return $this->hasOne("app\\{$module}\\model\\UploadFile", 'file_id', 'image_id');
    }
    /**
     * 关联用户表
     * @return \think\model\relation\BelongsTo
     */
    public function user()
    {
        $module = self::getCalledModule() ?: 'common';
        return $this->belongsTo("app\\{$module}\\model\\User");
    }


    public static function detail($where)
    {
        return static::get($where, ['image']);
    }

    /**
     * 地区名称
     * @param $value
     * @param $data
     * @return array
     */
    public function getRegionAttr($value, $data)
    {
        return [
            'province' => RegionModel::getNameById($data['province_id']),
            'city' => RegionModel::getNameById($data['city_id']),
            'region' => $data['region_id'] == 0 ? '' : RegionModel::getNameById($data['region_id']),
        ];
    }

}