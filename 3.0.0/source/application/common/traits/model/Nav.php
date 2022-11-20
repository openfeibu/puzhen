<?php

namespace app\common\traits\model;

/**
 * 用户权限模型
 * Trait Nav
 */
trait Nav
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
        $data = static::useGlobalScope(false)->with(['image'])->where($where)->order(['sort' => 'asc', 'create_time' => 'asc'])->select();
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
        is_array($where) ? $model->where($where) : $model->where('nav_id', '=', $where);
        return $model->find();
    }

    /**
     * 获取权限url集
     * @param $navIds
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public static function getnavUrls($navIds)
    {
        $urls = [];
        foreach (static::getAll() as $item) {
            in_array($item['nav_id'], $navIds) && $urls[] = $item['url'];
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
    /**
     * 获取权限列表 jstree格式
     * @param int $role_id 当前角色id
     * @return string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getJsTree($role_id = null)
    {
        $navIds = is_null($role_id) ? [] : self::getnavIds($role_id);
        $jsTree = [];
        foreach ($this->getAll(['status' => 1]) as $item) {
            $jsTree[] = [
                'id' => $item['nav_id'],
                'parent' => $item['parent_id'] > 0 ? $item['parent_id'] : '#',
                'text' => $item['name'],
                'state' => [
                    'selected' => (in_array($item['nav_id'], $navIds) && !$this->hasChildren($item['nav_id']))
                ]
            ];
        }
        return json_encode($jsTree);
    }

    /**
     * 是否存在子集
     * @param $nav_id
     * @return bool
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    private function hasChildren($nav_id)
    {
        foreach (self::getAll() as $item) {
            if ($item['parent_id'] == $nav_id)
                return true;
        }
        return false;
    }
}