<?php

namespace app\common\model;

/**
 * 规格/属性(值)模型
 * Class SpecValue
 * @package app\common\model
 */
class SpecValue extends BaseModel
{
    protected $name = 'spec_value';
    protected $updateTime = false;
    protected static $is_factory = 0;
    /**
     * 关联规格组表
     * @return $this|\think\model\relation\BelongsTo
     */
    public function spec()
    {
        return $this->belongsTo('Spec');
    }

}
