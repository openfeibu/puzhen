<?php

namespace app\common\model;

use app\common\exception\BaseException;
use app\common\model\user\PointsLog as PointsLogModel;
use think\Db;

/**
 * 用户模型类
 * Class User
 * @package app\common\model
 */
class User extends BaseModel
{
    protected $name = 'user';

    // 性别
    private $gender = ['未知', '男', '女'];

    /**
     * 关联微信小程序表
     * @return \think\model\relation\BelongsTo
     */
    public function wxapp()
    {
        $module = self::getCalledModule() ?: 'common';
        return $this->belongsTo("app\\{$module}\\model\\Wxapp");
    }
    /**
     * 文章详情：HTML实体转换回普通字符
     * @param $value
     * @return string
     */
    public function getAvatarUrlAttr($value)
    {
        return $value ?: default_avatar();
    }
    /**
     * 关联会员等级表
     * @return \think\model\relation\BelongsTo
     */
    public function grade()
    {
        $module = self::getCalledModule() ?: 'common';
        return $this->belongsTo("app\\{$module}\\model\\user\\Grade");
    }

    /**
     * 关联收货地址表
     * @return \think\model\relation\HasMany
     */
    public function address()
    {
        return $this->hasMany('UserAddress');
    }

    /**
     * 关联收货地址表 (默认地址)
     * @return \think\model\relation\BelongsTo
     */
    public function addressDefault()
    {
        return $this->belongsTo('UserAddress', 'address_id');
    }

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
     * @param $with
     * @return null|static
     * @throws \think\exception\DbException
     */
    public static function detail($where, $with = ['address', 'addressDefault'])
    {
        $filter = ['is_delete' => 0];
        if (is_array($where)) {
            $filter = array_merge($filter, $where);
        } else {
            $filter['user_id'] = (int)$where;
        }
        return static::get($filter, $with);
    }

    /**
     * 累积用户的实际消费金额
     * @param $userId
     * @param $expendMoney
     * @return int|true
     * @throws \think\Exception
     */
    public function setIncUserExpend($userId, $expendMoney)
    {
        return $this->where(['user_id' => $userId])->setInc('expend_money', $expendMoney);
    }

    /**
     * 指定会员等级下是否存在用户
     * @param $gradeId
     * @return bool
     */
    public static function checkExistByGradeId($gradeId)
    {
        $model = new static;
        return !!$model->where('grade_id', '=', (int)$gradeId)
            ->where('is_delete', '=', 0)
            ->value('user_id');
    }

    /**
     * 累积用户总消费金额
     * @param $money
     * @return int|true
     * @throws \think\Exception
     */
    public function setIncPayMoney($money)
    {
        return $this->setInc('pay_money', $money);
    }

    /**
     * 累积用户实际消费的金额 (批量)
     * @param $data
     * @return array|false
     * @throws \Exception
     */
    public function onBatchIncExpendMoney($data)
    {
        foreach ($data as $userId => $expendMoney) {
            $this->where(['user_id' => $userId])->setInc('expend_money', $expendMoney);
        }
        return true;
    }

    /**
     * 累积用户的可用积分数量 (批量)
     * @param $data
     * @return array|false
     * @throws \Exception
     */
    public function onBatchIncPoints($data)
    {
        foreach ($data as $userId => $expendMoney) {
            $this->where(['user_id' => $userId])->setInc('points', $expendMoney);
        }
        return true;
    }

    /**
     * 累积用户的可用积分
     * @param $points
     * @param $describe
     * @return int|true
     * @throws \think\Exception
     */
    public function setIncPoints($points, $describe)
    {
        // 新增积分变动明细
        PointsLogModel::add([
            'user_id' => $this['user_id'],
            'value' => $points,
            'describe' => $describe,
        ]);
        // 更新用户可用积分
        return $this->setInc('points', $points);
    }

    /**
     * @throws BaseException
     */
    public static function mergerUser($fromUser, $toUser)
    {
        try {
            $toUser->save([
                'nickName' => $toUser['avatarUrl'] && $toUser['nickName'] ? $toUser['nickName'] : $fromUser['nickName'],
                'avatarUrl' => $toUser['avatarUrl'] ?: $fromUser['avatarUrl'],
                'phone_number' => $toUser['phone_number'] ?: $fromUser['phone_number'],
                'email' => $toUser['email'] ?: $fromUser['email'],
                'password' => $toUser['password'] ?: $fromUser['password'],
            ]);

            TeaQrcode::where('user_id',$fromUser['user_id'])->update([
                'user_id' => $toUser['user_id'],
            ]);
            Collection::where('user_id',$fromUser['user_id'])->update([
                'user_id' => $toUser['user_id'],
            ]);
            Comment::where('user_id',$fromUser['user_id'])->update([
                'user_id' => $toUser['user_id'],
            ]);
            TeaQrcodeComment::where('user_id',$fromUser['user_id'])->update([
                'user_id' => $toUser['user_id'],
            ]);
            UserEquipment::where('user_id',$fromUser['user_id'])->update([
                'user_id' => $toUser['user_id'],
            ]);
            UserWechatAccount::where('user_id',$fromUser['user_id'])->update([
                'user_id' => $toUser['user_id'],
            ]);
            $fromUser->delete();
            return true;
        }catch (\Exception $e)
        {
            throw new BaseException(['msg' => lang('server_error')]);
        }

    }
}
