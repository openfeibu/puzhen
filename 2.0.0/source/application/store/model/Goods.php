<?php

namespace app\store\model;

use app\common\model\Goods as GoodsModel;
use app\store\service\Goods as GoodsService;

/**
 * 产品模型
 * Class Goods
 * @package app\store\model
 */
class Goods extends GoodsModel
{
    /**
     * 添加产品
     * @param $is_import
     * @param array $data
     * @return bool
     * @throws \think\exception\PDOException
     */
    public function add(array $data, $is_import = 0)
    {
        self::$factory_id = self::$factory_id ?? $data['factory_id'];

        if ((!isset($data['images']) || empty($data['images'])) && !$is_import ) {
            $this->error = '请上传产品图片';
            return false;
        }
   
        $data['content'] = isset($data['content']) ? $data['content'] : '';
        $data['spec_type'] = isset($data['spec_type']) ? $data['spec_type'] : '10';
        $data['wxapp_id'] = $data['sku']['wxapp_id'] = self::$wxapp_id;
        $data['factory_id'] = $data['sku']['factory_id'] = self::$factory_id;
        // 开启事务
        $this->startTrans();
        try {
            // 添加产品
            $this->allowField(true)->save($data);
            // 产品规格
            $this->addGoodsSpec($data);
            if (isset($data['images']) && !empty($data['images'])) {
                // 产品图片
                $this->addGoodsImages($data['images']);
            }
            $this->commit();
            return true;
        } catch (\Exception $e) {
            $this->error = $e->getMessage();
            $this->rollback();
            return false;
        }
    }

    /**
     * 添加产品图片
     * @param $images
     * @return int
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    private function addGoodsImages($images)
    {
        $this->image()->delete();
        $data = array_map(function ($image_id) {
            return [
                'image_id' => $image_id,
                'wxapp_id' => self::$wxapp_id,
                'factory_id' => self::$factory_id
            ];
        }, $images);
        return $this->image()->saveAll($data);
    }

    /**
     * 编辑产品
     * @param $data
     * @return bool|mixed
     */
    public function edit($data)
    {
        if (!isset($data['images']) || empty($data['images'])) {
            $this->error = '请上传产品图片';
            return false;
        }
        self::$factory_id = isset($data['factory_id']) ? $data['factory_id'] : $this['factory_id'];
        $data['spec_type'] = isset($data['spec_type']) ? $data['spec_type'] : $this['spec_type'];
        $data['content'] = isset($data['content']) ? $data['content'] : '';
        $data['wxapp_id'] = $data['sku']['wxapp_id'] = self::$wxapp_id;
        $data['factory_id'] = $data['sku']['factory_id'] = self::$factory_id;
        return $this->transaction(function () use ($data) {
            // 保存产品
            $this->allowField(true)->save($data);
            // 产品规格
            $this->addGoodsSpec($data, true);
            // 产品图片
            $this->addGoodsImages($data['images']);
            return true;
        });
    }

    /**
     * 添加产品规格
     * @param $data
     * @param $isUpdate
     * @throws \Exception
     */
    private function addGoodsSpec($data, $isUpdate = false)
    {
        // 更新模式: 先删除所有规格
        $model = new GoodsSku;
        $model::$factory_id = $data['factory_id'];
        $isUpdate && $model->removeAll($this['goods_id']);
        // 添加规格数据
        if ($data['spec_type'] == '10') {
            // 单规格
            $this->sku()->save($data['sku']);
        } else if ($data['spec_type'] == '20') {
            // 添加产品与规格关系记录
            $model->addGoodsSpecRel($this['goods_id'], $data['spec_many']['spec_attr']);
            // 添加产品sku
            $model->addSkuList($this['goods_id'], $data['spec_many']['spec_list']);
        }
    }

    /**
     * 修改产品状态
     * @param $state
     * @return false|int
     */
    public function setStatus($state)
    {
        return $this->allowField(true)->save(['goods_status' => $state ? 10 : 20]) !== false;
    }

    /**
     * 软删除
     * @return false|int
     */
    public function setDelete()
    {
        if (!GoodsService::checkIsAllowDelete($this['goods_id'])) {
            $this->error = '当前产品正在参与其他活动，不允许删除';
            return false;
        }
        return $this->allowField(true)->save(['is_delete' => 1]);
    }

    /**
     * 获取当前产品总数
     * @param array $where
     * @return int|string
     * @throws \think\Exception
     */
    public function getGoodsTotal($where = [])
    {
        return $this->where('is_delete', '=', 0)->where($where)->count();
    }

}
