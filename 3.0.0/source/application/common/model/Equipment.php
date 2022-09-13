<?php

namespace app\common\model;

use app\common\model\BaseModel;

/**
 * 设备模型
 * Class Equipment
 * @package app\common\model
 */
class Equipment extends BaseModel
{
    protected $name = 'equipment';

    /**
     * 关联封面图
     * @return \think\model\relation\HasOne
     */
    public function image()
    {
        $module = self::getCalledModule() ?: 'common';
        return $this->hasOne("app\\{$module}\\model\\UploadFile", 'file_id', 'image_id');
    }


    public static function detail($equipment_id)
    {
        return static::get($equipment_id, ['image']);
    }

    /**
     * 获取列表数据
     * @param array $param
     * @return \think\Paginator
     * @throws \think\exception\DbException
     */
    public function getList($param = [])
    {
        // 查询列表数据
        return $this->setListQueryWhere($param)
            ->paginate(15, false, [
                'query' => \request()->request()
            ]);
    }

    /**
     * 获取所有经销商列表
     * @param array $param
     * @return false|\PDOStatement|string|\think\Collection
     */
    public static function getAllList($param = [])
    {
        return (new static)->setListQueryWhere($param)->with(['image'])->select();
    }

    /**
     * 设置列表查询条件
     * @param array $param
     * @return $this
     */
    private function setListQueryWhere($param = [])
    {
        // 查询参数
        $param = array_merge(['search' => '', 'status' => null,], $param);
        !empty($param['search']) && $this->where('equipment_name|model', 'like', "%{$param['search']}%");
        return $this->where('is_delete', '=', '0')->order(['sort' => 'asc', 'create_time' => 'desc']);
    }
}