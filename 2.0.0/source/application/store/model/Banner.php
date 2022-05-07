<?php

namespace app\store\model;

use app\common\model\Banner as BannerModel;

/**
 * 展厅模型
 * Class Banner
 * @package app\store\model
 */
class Banner extends BannerModel
{

    public function add($data)
    {
        if (!$this->validateForm($data)) {
            return false;
        }
        $data['wxapp_id'] = self::$wxapp_id;
        // 开启事务
        $this->startTrans();
        try {
            // 添加商品
            $this->allowField(true)->save($data);
            $this->commit();
            return true;
        } catch (\Exception $e) {
            $this->error = $e->getMessage();
            $this->rollback();
            return false;
        }
    }
    public function edit($data)
    {
        if (!$this->validateForm($data)) {
            return false;
        }
        $data['wxapp_id'] = self::$wxapp_id;
        return $this->transaction(function () use ($data) {
            // 保存
            $this->allowField(true)->save($data);
            return true;
        });
    }

    public function getList($param)
    {
        // 查询列表数据
        return $this->setListQueryWhere($param)
            ->paginate(20, false, [
                'query' => \request()->request()
            ]);
    }
    /**
     * 获取所有展馆列表
     * @param array $param
     * @return false|\PDOStatement|string|\think\Collection
     */
    public static function getAllList($param = [])
    {
        return (new static)->setListQueryWhere($param)->select();
    }


    /**
     * 设置列表查询条件
     * @param array $param
     * @return $this
     */
    private function setListQueryWhere($param = [])
    {
        return $this->order(['sort' => 'asc', 'create_time' => 'asc']);
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
        return true;
    }

}
