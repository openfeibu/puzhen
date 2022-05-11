<?php

namespace app\common\model;
use app\common\model\Setting as SettingModel;

/**
 * 用户设备模型
 * Class UserEquipment
 * @package app\common\model
 */
class UserEquipment extends BaseModel
{
    protected $name = 'user_equipment';

    public function equipment()
    {
        $module = self::getCalledModule() ?: 'common';
        return $this->belongsTo("app\\{$module}\\model\\Equipment");
    }
    /**
     * 关联会员记录表
     * @return \think\model\relation\BelongsTo
     */
    public function user()
    {
        $module = self::getCalledModule() ?: 'common';
        return $this->belongsTo("app\\{$module}\\model\\User");
    }

    /**
     * 关联图片记录表
     * @return \think\model\relation\HasMany
     */
    public function image()
    {
        return $this->hasMany('UserEquipmentImage');
    }

    public function getStatusAttr($value)
    {
        $status = [ 10 => '审核中', 20 => '审核通过', 30 => '驳回'];
        return ['text' => $status[$value], 'value' => $value];
    }

    public function getStatusTextAttr($value, $data)
    {
        $status = [10 => '审核中', 20 => '审核通过', 30 => '驳回'];
        return $status[$data['status']];
    }
    /**
     * 详情
     * @param $where
     * @return static|null
     * @throws \think\exception\DbException
     */
    public static function detail($where)
    {
        $data =  static::get($where, ['image.file','equipment' => ['image']]);
        if($data)
        {
            $diff_days  = diffBetweenTwoDays(date('Y-m-d'),$data['buy_date']);

            $warranty_days = $data['setting_warranty_days'] - $diff_days;
            $data['warranty_days_text'] = $warranty_days > 0 ? $warranty_days : 0;
            $change_days = $data['setting_basic_change_days'] + $data['setting_change_days'] -  $diff_days;
            $data['change_days'] = $change_days > 0 ? $change_days : 0;
            $data['change_days_text'] = $change_days > 0 ? ($diff_days > $data['setting_basic_change_days'] ? '0+'.$change_days : ($data['setting_basic_change_days'] - $diff_days) .'+'.$data['change_days']) : 0 ;

        }
        return $data;
    }

}
