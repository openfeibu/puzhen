<?php

namespace app\common\model;

use app\common\model\BaseModel;
use app\common\traits\model\Nav as NavTrait;

/**
 * 商家用户权限模型
 * Class Access
 * @package app\common\model\admin
 */
class Nav extends BaseModel
{
    use NavTrait;
    protected $name = 'nav';

    /**
     * 关联图片
     * @return \think\model\relation\HasOne
     */
    public function image()
    {
        $module = self::getCalledModule() ?: 'common';
        return $this->hasOne("app\\{$module}\\model\\UploadFile", 'file_id', 'image_id');
    }

    /**
     * 获取所有上级id集
     * @param $nav_id
     * @param null $all
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    protected function getTopNavIds($nav_id, &$all = null)
    {
        static $ids = [];
        is_null($all) && $all = $this->getAll();
        foreach ($all as $item) {
            if ($item['nav_id'] == $nav_id && $item['parent_id'] > 0) {
                $ids[] = $item['parent_id'];
                $this->getTopNavIds($item['parent_id'], $all);
            }
        }
        return $ids;
    }

    /**
     * 获取权限列表
     * @param $all
     * @param int $parent_id
     * @param int $deep
     * @return array
     */
    protected function formatTreeData(&$all, $parent_id = 0, $deep = 1)
    {
        static $tempTreeArr = [];
        foreach ($all as $key => $val) {
            if ($val['parent_id'] == $parent_id) {
                // 记录深度
                $val['deep'] = $deep;
                // 根据角色深度处理名称前缀
                $val['name_h1'] = $this->htmlPrefix($deep) . $val['name'];
                $tempTreeArr[] = $val;
                $this->formatTreeData($all, $val['nav_id'], $deep + 1);
            }
        }
        return $tempTreeArr;
    }

    protected function htmlPrefix($deep)
    {
        // 根据角色深度处理名称前缀
        $prefix = '';
        if ($deep > 1) {
            for ($i = 1; $i <= $deep - 1; $i++) {
                $prefix .= '&nbsp;&nbsp;&nbsp;├ ';
            }
            $prefix .= '&nbsp;';
        }
        return $prefix;
    }
}