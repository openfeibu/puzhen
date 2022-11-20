<?php

namespace app\store\model;

use app\common\model\Nav as NavModel;

/**
 * 商家用户权限模型
 * Class Nav
 * @package app\admin\model\store
 */
class Nav extends NavModel
{
    /**
     * 获取权限列表
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getList()
    {
        $all = static::getAll();
        return $this->formatTreeData($all);
    }

    /**
     * 新增记录
     * @param $data
     * @return false|int
     */
    public function add($data)
    {
        $data['wxapp_id'] = self::$wxapp_id;
        return $this->allowField(true)->save($data);
    }

    /**
     * 更新记录
     * @param $data
     * @return bool
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function edit($data)
    {
        // 判断上级角色是否为当前子级
        if ($data['parent_id'] > 0) {
            // 获取所有上级id集
            $parentIds = $this->getTopNavIds($data['parent_id']);
            if (in_array($this['nav_id'], $parentIds)) {
                $this->error = '上级权限不允许设置为当前子权限';
                return false;
            }
        }
        return $this->allowField(true)->save($data) !== false;
    }

    /**
     * 删除权限
     * @return bool|int
     * @throws \think\exception\DbException
     */
    public function remove()
    {
        // 判断是否存在下级权限
        if (self::detail(['parent_id' => $this['nav_id']])) {
            $this->error = '当前权限下存在子权限，请先删除';
            return false;
        }
        return $this->delete();
    }


    /**
     * 修改状态
     * @param $state
     * @return false|int
     */
    public function setStatus($state)
    {
        if($state == 0){
            $child_ids = $this->where('parent_id',$this->nav_id)->column('nav_id');
            array_push($child_ids,$this->nav_id);
            return $this->allowField(true)->whereIn('nav_id',$child_ids)->update(['status' => $state ? 1 : 0]) !== false;
        }else{
            return $this->allowField(true)->save(['status' => $state ? 1 : 0]) !== false;
        }

    }
}