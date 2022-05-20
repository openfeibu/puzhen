<?php

namespace app\factory\model\factory;

use app\common\model\factory\Role as RoleModel;
use app\common\traits\model\admin\Role as RoleTrait;

/**
 * 商家用户角色模型
 * Class Role
 * @package app\factory\model\factory
 */
class Role extends RoleModel
{
    use RoleTrait;

    /**
     * 新增记录
     * @param $data
     * @return bool
     * @throws \Exception
     */
    public function add($data)
    {
        $data['wxapp_id'] = self::$wxapp_id;
        $data['factory_id'] = self::$factory_id;
        if (empty($data['access'])) {
            $this->error = '请选择权限';
            return false;
        }
        $this->startTrans();
        try {
            // 新增角色记录
            $this->allowField(true)->save($data);
            // 新增角色权限关系记录
            (new RoleAccess)->add($this['role_id'], $data['access']);
            $this->commit();
            return true;
        } catch (\Exception $e) {
            $this->error = $e->getMessage();
            $this->rollback();
            return false;
        }
    }

    /**
     * 更新记录
     * @param $data
     * @return bool
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public function edit($data)
    {
        if (empty($data['access'])) {
            $this->error = '请选择权限';
            return false;
        }
        // 判断上级角色是否为当前子级
        if ($data['parent_id'] > 0) {
            // 获取所有上级id集
            $parentIds = $this->getTopRoleIds($data['parent_id']);
            if (in_array($this['role_id'], $parentIds)) {
                $this->error = '上级角色不允许设置为当前子角色';
                return false;
            }
        }
        $this->startTrans();
        try {
            // 更新角色记录
            $this->allowField(true)->save($data);
            // 更新角色权限关系记录
            (new RoleAccess)->edit($this['role_id'], $data['access']);
            $this->commit();
            return true;
        } catch (\Exception $e) {
            $this->error = $e->getMessage();
            $this->rollback();
            return false;
        }
    }
    /**
     * 删除记录
     * @return bool|int
     * @throws \think\exception\DbException
     */
    public function remove()
    {
        // 判断是否存在下级角色
        if (self::detail(['parent_id' => $this['role_id']])) {
            $this->error = '当前角色下存在子角色，不允许删除';
            return false;
        }
        // 删除对应的权限关系
        RoleAccess::deleteAll(['role_id' => $this['role_id']]);
        return $this->delete();
    }
}