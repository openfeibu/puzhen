<?php

namespace app\common\model;

/**
 * 产品图片模型
 * Class GoodsEnImage
 * @package app\common\model
 */
class GoodsEnImage extends BaseModel
{
    protected $name = 'goods_en_image';
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
