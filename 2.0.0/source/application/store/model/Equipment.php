<?php

namespace app\store\model;

use app\common\library\helper;
use app\common\model\Equipment as EquipmentModel;
use Lvht\GeoHash;

/**
 * 设备模型
 * Class Equipment
 * @package app\store\model
 */
class Equipment extends EquipmentModel
{

    /**
     * 新增记录
     * @param $data
     * @return bool
     * @throws \Exception
     */
    public function add($data)
    {
        if (!$this->validateForm($data)) {
            return false;
        }
        return $this->allowField(true)->save($this->createData($data));
    }

    /**
     * 编辑记录
     * @param $data
     * @return false|int
     */
    public function edit($data)
    {
        if (!$this->validateForm($data)) {
            return false;
        }
        return $this->allowField(true)->save($this->createData($data)) !== false;
    }


    /**
     * 创建数据
     * @param array $data
     * @return array
     */
    private function createData($data)
    {
        $data['wxapp_id'] = self::$wxapp_id;
        return $data;
    }

    /**
     * 表单验证
     * @param $data
     * @return bool
     */
    private function validateForm($data)
    {
        if (!isset($data['image_id']) || empty($data['image_id'])) {
            $this->error = '请选择设备图片';
            return false;
        }
        return true;
    }

    /**
     * 软删除
     * @return false|int
     */
    public function setDelete()
    {
        return $this->save(['is_delete' => 1]);
    }

}