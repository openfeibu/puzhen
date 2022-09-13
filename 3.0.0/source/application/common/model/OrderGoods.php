<?php

namespace app\common\model;

/**
 * 订单产品模型
 * Class OrderGoods
 * @package app\common\model
 */
class OrderGoods extends BaseModel
{
    protected $name = 'order_goods';
    protected $updateTime = false;

    /**
     * 订单产品列表
     * @return \think\model\relation\BelongsTo
     */
    public function image()
    {
        $model = "app\\common\\model\\UploadFile";
        return $this->belongsTo($model, 'image_id', 'file_id');
    }

    /**
     * 关联产品表
     * @return \think\model\relation\BelongsTo
     */
    public function goods()
    {
        return $this->belongsTo('Goods');
    }

    /**
     * 关联产品sku表
     * @return \think\model\relation\BelongsTo
     */
//    public function sku()
//    {
//        return $this->belongsTo('GoodsSku', 'spec_sku_id', 'spec_sku_id');
//    }

    /**
     * 关联订单主表
     * @return \think\model\relation\BelongsTo
     */
    public function orderM()
    {
        return $this->belongsTo('Order');
    }

    /**
     * 售后单记录表
     * @return \think\model\relation\HasOne
     */
    public function refund()
    {
        return $this->hasOne('OrderRefund');
    }

    /**
     * 订单产品详情
     * @param $where
     * @return OrderGoods|null
     * @throws \think\exception\DbException
     */
    public static function detail($where)
    {
        return static::get($where, ['image', 'refund']);
    }

}
