<?php

namespace app\factory\model;

use think\Request;
use think\Session;
use app\store\model\UploadFile as UploadFileModel;
use app\store\model\Setting as SettingModel;
use app\common\library\storage\Driver as StorageDriver;

/**
 * 文件库模型
 * Class UploadFile
 * @package app\store\model
 */
class UploadFile extends UploadFileModel
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

}
