<?php

namespace app\common\model;

use app\common\model\user\PointsLog as PointsLogModel;

/**
 * 用户模型类
 * Class User
 * @package app\common\model
 */
class UserWechatAccount extends BaseModel
{
    protected $name = 'user_wechat_account';

    // 性别
    private $gender = ['未知', '男', '女'];
	

    /**
     * 显示性别
     * @param $value
     * @return mixed
     */
    public function getGenderAttr($value)
    {
        return $this->gender[$value];
    }

    /**
     * 获取用户信息
     * @param $where
     * @return null|static
     * @throws \think\exception\DbException
     */
    public static function detail($where)
    {
        $filter = ['is_delete' => 0];
        if (is_array($where)) {
            $filter = array_merge($filter, $where);
        } else {
            $filter['user_id'] = (int)$where;
        }
        return static::get($filter);
    }
}
