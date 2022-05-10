<?php

namespace app\common\model;

use app\common\model\BaseModel;
use app\common\model\Region as RegionModel;

/**
 * 经销商模型
 * Class Distributor
 * @package app\common\model
 */
class Distributor extends BaseModel
{
    protected $name = 'distributor';

    /**
     * 追加字段
     * @var array
     */
    protected $append = ['region'];

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
     * 关联商品表
     * @return \think\model\relation\HasMany
     */
    public function goods()
    {
        $module = self::getCalledModule() ?: 'common';
        return $this->hasMany("app\\{$module}\\model\\distributor\\Goods")->order(['goods_id' => 'desc']);
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

    /**
     * @return \app\common\model\Distributor
     */
    public static function detail($distributor_id)
    {
        return static::get($distributor_id, ['image']);
    }
}