<?php

namespace app\api\model;

use app\common\model\Region;
use app\common\model\UserEquipment as UserEquipmentModel;

/**
 * 用户设备模型
 * Class UserEquipment
 * @package app\common\model
 */
class UserEquipment extends UserEquipmentModel
{
    /**
     * 隐藏字段
     * @var array
     */
    protected $hidden = [
        'wxapp_id',
        'create_time',
        'update_time'
    ];

    /**
     * @param $user_id
     * @return false|static[]
     * @throws \think\exception\DbException
     */
    public function getList($user_id)
    {
        $list = $this->where('user_id',$user_id)
	          ->alias('user_equipment')
	          ->field('user_equipment.*')
	          ->join('equipment', 'equipment.equipment_id = user_equipment.equipment_id')
            ->with(['equipment' => ['image']])
            ->order(['create_time' => 'desc'])
            ->paginate(15, false, [
            'query' => \request()->request()
        ]);
        foreach ($list as &$data)
        {
            $data->status_text = $data->status_text;
        }
        return $list;
    }

    /**
     * 新增
     * @param User $user
     * @param $data
     * @return mixed
     */
    public function add($user, $data)
    {
        return $this->transaction(function () use ($user, $data) {
		        if($data['buy_date'] > date('Y-m-d'))
		        {
			          $this->error = '购买日期不能大于今天';
			          return false;
		        }
		        if(!isset($data['images']) || empty($data['images']))
		        {
				        $this->error = '请上传凭证';
				        return false;
		        }
            $this->allowField(true)->save([
                'equipment_id' => $data['equipment_id'],
                'linkname' => $data['linkname'],
                'phone' => $data['phone'],
                'buy_date' => $data['buy_date'],
                'equipment_sn' => $data['equipment_sn'],
                'user_id' => $user['user_id'],
                'wxapp_id' => self::$wxapp_id
            ]);
            // 记录凭证图片关系
            if (isset($data['images']) && !empty($data['images'])) {
                $this->saveImages($this['user_equipment_id'], $data['images']);
            }
            return true;
        });
    }
    public function remove()
    {
        if($this->getData('status') != 30)
        {
            $this->error = '审核中或已通过审核，不可删除';
            return false;
        }
        $this->delete();
        return true;

    }
    /**
     * 记录用户设备凭证
     * @param $user_equipment_id
     * @param $images
     * @return bool
     * @throws \Exception
     */
    private function saveImages($user_equipment_id, $images)
    {
        // 生成评价图片数据
        $data = [];
        foreach (explode(',', $images) as $image_id) {
            $data[] = [
                'user_equipment_id' => $user_equipment_id,
                'image_id' => $image_id,
                'wxapp_id' => self::$wxapp_id
            ];
        }
        return !empty($data) && (new UserEquipmentImage)->saveAll($data);
    }



}
