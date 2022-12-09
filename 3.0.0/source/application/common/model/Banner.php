<?php

namespace app\common\model;

use think\Db;

/**
 * 轮播图模型
 * Class Comment
 * @package app\common\model
 */
class Banner extends BaseModel
{
    protected $name = 'banner';

    public static function detail($banner_id)
    {
        return static::get($banner_id);
    }

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
     * 关联图片
     * @return \think\model\relation\HasOne
     */
    public function enImage()
    {
        $module = self::getCalledModule() ?: 'common';
        return $this->hasOne("app\\{$module}\\model\\UploadFile", 'file_id', 'en_image_id');
    }
    public function getList($type)
    {
        $data = $this->with(['image'])
            ->where('type',$type)
            ->order(['sort' => 'asc', 'create_time' => 'asc'])
            ->select();

        return $data;
    }
}