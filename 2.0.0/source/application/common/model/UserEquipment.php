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
        $data =  static::get($where, ['image.file','equipment' => ['image'],'user']);
        if($data)
        {
            $data->setWarranty();
        }
        return $data;
    }
    public function setWarranty()
    {
        $diff_days  = diffBetweenTwoDays(date('Y-m-d'),$this['buy_date']);
        $warranty_days = $this['setting_warranty_days'] - $diff_days;
        $this['warranty_days_text'] = $warranty_days > 0 ? $warranty_days : 0;
        $change_days = $this['setting_basic_change_days'] + $this['setting_change_days'] -  $diff_days;
        $this['change_days'] = $change_days > 0 ? $change_days : 0;
        $this['change_days_text'] = $change_days > 0 ? ($diff_days > $this['setting_basic_change_days'] ? '0+'.$change_days : ($this['setting_basic_change_days'] - $diff_days) .'+'.($this['change_days'] - $this['setting_basic_change_days'])) : 0 ;
        return $this;
    }
}
