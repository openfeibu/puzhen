<?php

namespace app\store\model\distributor;

use app\common\model\distributor\Goods as GoodsModel;
use app\store\service\Goods as GoodsService;
use app\store\model\Category;

/**
 * 服务网点-产品模型
 * Class Goods
 * @package app\store\model\sharp
 */
class Goods extends GoodsModel
{

    /**
     * 新增记录
     * @param \app\store\model\Distributor $distributor
     * @param $data
     * @return bool|int
     */
    public function add($distributor,$data)
    {
        if (!$this->onValidate($data, 'add')) {
            return false;
        }
        $goods_ids = $distributor->goods()->column('goods_id');
        $data['goods_id'] = array_diff($data['goods_id'],$goods_ids);
        if(!$data['goods_id'])
        {
            return true;
        }
        $data = array_map(function ($goods_id) {

            return [
                'goods_id' => $goods_id,
                'wxapp_id' => self::$wxapp_id
            ];
        }, $data['goods_id']);

        return $distributor->goods()->saveAll($data);
    }

    /**
     * 表单验证
     * @param $data
     * @param string $scene
     * @return bool
     */
    private function onValidate($data, $scene = 'add')
    {
        if ($scene === 'add') {
            if (!isset($data['goods_id']) || empty($data['goods_id'])) {
                $this->error = '请选择产品';
                return false;
            }
        }
        return true;
    }
    public static function detail($id)
    {
        return static::get($id);
    }
}