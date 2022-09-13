<?php

namespace app\common\model;

/**
 * 图片模型
 * Class DistributorApplyImage
 * @package app\common\model
 */
class DistributorApplyImage extends BaseModel
{
    protected $name = 'distributor_apply_image';
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
