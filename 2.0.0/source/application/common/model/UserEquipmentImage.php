<?php

namespace app\common\model;

/**
 * 用户设备凭证模型
 * Class UserEquipmentImage
 * @package app\common\model
 */
class UserEquipmentImage extends BaseModel
{
    protected $name = 'user_equipment_image';
    protected $updateTime = false;

    /**
     * 关联文件库
     * @return \think\model\relation\BelongsTo
     */
    public function file()
    {
        return $this->belongsTo('UploadFile', 'image_id', 'file_id')
            ->bind(['file_path', 'file_name', 'file_url']);
    }

}
