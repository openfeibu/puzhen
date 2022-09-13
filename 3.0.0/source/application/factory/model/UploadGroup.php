<?php

namespace app\factory\model;

use think\Session;
use app\store\model\UploadGroup as UploadGroupModel;

/**
 * 文件库分组模型
 * Class UploadGroup
 * @package app\store\model
 */
class UploadGroup extends UploadGroupModel
{
    public static function init()
    {
        parent::init();
        $factory = Session::get('fbshop_factory');
        if($factory && $factory['factory']['is_self'] == 1)
        {
            parent::$is_factory = 0;
        }
    }

    /**
     * 添加新记录
     * @param $data
     * @return false|int
     */
    public function add($data)
    {
        return $this->save(array_merge([
            'wxapp_id' => self::$wxapp_id,
            'factory_id' => self::$factory_id,
            'sort' => 100
        ], $data));
    }


}
