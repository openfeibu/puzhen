<?php

namespace app\common\traits\model\admin\common;


/**
 * 用户权限模型
 * Trait Access
 */
trait Access
{

    /**
     * 获取所有权限
     * @param $where
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    protected static function getAll($where=[])
    {
        //->where('status',1)
        $data = static::useGlobalScope(false)->where($where)->order(['sort' => 'asc', 'create_time' => 'asc'])->select();
        return $data ? $data->toArray() : [];
    }

    /**
     * 权限信息
     * @param int|array $where
     * @return array|false|\PDOStatement|string|\think\Model|static
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public static function detail($where)
    {
        $model = static::useGlobalScope(false);
        is_array($where) ? $model->where($where) : $model->where('access_id', '=', $where);
        return $model->find();
    }

    /**
     * 获取权限url集
     * @param $accessIds
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public static function getAccessUrls($accessIds)
    {
        $urls = [];
        foreach (static::getAll() as $item) {
            in_array($item['access_id'], $accessIds) && $urls[] = $item['url'];
        }
        return $urls;
    }

    /**
     * @param $value
     * @return mixed
     */
    public function getStatusAttr($value)
    {
        $status = [1 => '显示', 0 => '隐藏'];
        return ['text' => $status[$value], 'value' => $value];
    }
}