<?php

namespace app\common\model;

use app\common\library\helper;
use think\Cache;

/**
 * 拼团产品分类模型
 * Class Category
 * @package app\common\model
 */
class Category extends BaseModel
{
    protected $name = 'category';
    protected static $is_factory = 0;

    /**
     * 分类图片
     * @return \think\model\relation\HasOne
     */
    public function image()
    {
        return $this->hasOne('uploadFile', 'file_id', 'image_id');
    }

    /**
     * 所有分类
     * @return mixed
     */
    public static function getALL()
    {
        $model = new static;
        if (!Cache::get('category_' . $model::$wxapp_id)) {
            $data = $model->with(['image'])->order(['sort' => 'asc', 'create_time' => 'asc'])->select();
            $all = !empty($data) ? $data->toArray() : [];
            $tree = [];
            foreach ($all as $first) {
                if ($first['parent_id'] != 0) continue;
                $twoTree = [];
                foreach ($all as $two) {
                    if ($two['parent_id'] != $first['category_id']) continue;
                    $threeTree = [];
                    foreach ($all as $three)
                        $three['parent_id'] == $two['category_id']
                        && $threeTree[$three['category_id']] = $three;
                    !empty($threeTree) && $two['child'] = $threeTree;
                    $twoTree[$two['category_id']] = $two;
                }
                if (!empty($twoTree)) {
                    array_multisort(array_column($twoTree, 'sort'), SORT_ASC, $twoTree);
                    $first['child'] = $twoTree;
                }
                $tree[$first['category_id']] = $first;
            }
            Cache::tag('cache')->set('category_' . $model::$wxapp_id, compact('all', 'tree'));
        }
        return Cache::get('category_' . $model::$wxapp_id);
    }

    /**
     * 获取所有分类
     * @return mixed
     */
    public static function getCacheAll()
    {
        return self::getALL()['all'];
    }

    public static function getCacheTreeActive(&$categoryId=0, $isAutoId=true)
    {
        $tree = array_values(static::getCacheTree());
        if(!$categoryId && $isAutoId){
            $categoryId = $tree[0]['child'][0]['category_id'];
        }
        foreach ($tree as $first_key => &$first) {
            $first['active'] = 0;
            if(!empty($first['child']))
            {
                foreach ($first['child'] as $two_key => &$two)
                {
                    $two['active'] = 0;
                    if(!empty($two['child']))
                    {
                        foreach ($two['child'] as $three_key => &$three)
                        {
                            $three['active'] = 0;
                            if($three['category_id'] == $categoryId)
                            {
                                $first['active'] = 1;
                                $two['active'] = 1;
                                $three['active'] = 1;
                            }
                        }
                    }
                    if($two['category_id'] == $categoryId)
                    {
                        $first['active'] = 1;
                        $two['active'] = 1;
                    }
                }
            }
            if($first['category_id'] == $categoryId)
            {
                $first['active'] = 1;
            }

        }
        return $tree;
    }
    /**
     * 获取所有分类(树状结构)
     * @return mixed
     */
    public static function getCacheTree()
    {
        return self::getALL()['tree'];
    }

    /**
     * 获取所有分类(树状结构)
     * @return string
     */
    public static function getCacheTreeJson()
    {
        return helper::jsonEncode(static::getCacheTree());
    }

    /**
     * 获取指定分类下的所有子分类id
     * @param $parent_id
     * @param array $all
     * @return array
     */
    public static function getSubCategoryId($parent_id, $all = [])
    {
        $arrIds = [$parent_id];
        empty($all) && $all = self::getCacheAll();
        foreach ($all as $key => $item) {
            if ($item['parent_id'] == $parent_id) {
                unset($all[$key]);
                $subIds = self::getSubCategoryId($item['category_id'], $all);
                !empty($subIds) && $arrIds = array_merge($arrIds, $subIds);
            }
        }
        return $arrIds;
    }

    /**
     * 指定的分类下是否存在子分类
     * @param $parentId
     * @return bool
     */
    protected static function hasSubCategory($parentId)
    {
        $all = self::getCacheAll();
        foreach ($all as $item) {
            if ($item['parent_id'] == $parentId) {
                return true;
            }
        }
        return false;
    }

}
