<?php

namespace app\common\traits\model\admin\common;


/**
 * 用户角色模型
 * Trait Role
 */
trait Role
{
    /**
     * 角色信息
     * @param $where
     * @return null|static
     * @throws \think\exception\DbException
     */
    public static function detail($where)
    {
        return self::get($where);
    }
}