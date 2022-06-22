<?php

namespace app\store\model;

use app\common\model\UserEquipment as UserEquipmentModel;
use app\store\service\user_equipment\Export as ExportService;
use app\store\model\Setting as SettingModel;
/**
 * 用户设备模型
 * Class UserEquipment
 * @package app\store\model
 */
class UserEquipment extends UserEquipmentModel
{

    /**
     * 列表
     * @param string $status
     * @param array $query
     * @return \think\Paginator
     * @throws \think\exception\DbException
     */
    public function getList($status, $query = [])
    {
        // 检索查询条件
        !empty($query) && $this->setWhere($query);
        // 获取数据列表
        $list =  $this->with(['equipment', 'user'])
            ->alias('user_equipment')
            ->field('user_equipment.*')
            ->join('user', 'user.user_id = user_equipment.user_id')
            ->join('equipment', 'equipment.equipment_id = user_equipment.equipment_id')
            ->where('status',$status)
            ->order(['user_equipment.create_time' => 'desc'])
            ->paginate(15, false, [
                'query' => \request()->request()
            ]);
        foreach ($list as $item)
        {
            $item->setWarranty();
        }
        return $list;

    }

    /**
     * 导出
     * @param $status
     * @param $query
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function exportList($status, $query = [])
    {
        // 获取订单列表
        $list = $this->getListAll($status, $query);
        // 导出csv文件
        return (new ExportService)->userEquipmentList($list);
    }

    /**
     * 列表
     * @param string $status
     * @param array $query
     * @return \think\Paginator
     * @throws \think\exception\DbException
     */
    public function getListAll($status, $query = [])
    {
        // 检索查询条件
        !empty($query) && $this->setWhere($query);
        // 获取数据列表
        $list =  $this->with(['equipment', 'user'])
            ->alias('user_equipment')
            ->field('user_equipment.*')
            ->join('user', 'user.user_id = user_equipment.user_id')
            ->join('equipment', 'equipment.equipment_id = user_equipment.equipment_id')
            ->where('status',$status)
            ->order(['user_equipment.create_time' => 'desc'])
            ->select();
        foreach ($list as $item)
        {
            $item->setWarranty();
        }
        return $list;

    }
    public function add($data)
    {
        $data['wxapp_id'] = self::$wxapp_id;
        $data['status'] = 20;
        $data['audit_time'] = time();
        // 开启事务
        $this->startTrans();
        try {
            $warranty_setting = SettingModel::getItem('warranty');
            if(empty($warranty_setting['warranty_days'])||empty($warranty_setting['basic_change_days'])||empty($warranty_setting['change_days']))
            {
                $this->error = '请先配置保修包换信息';
                return false;
            }
            $data['setting_warranty_days'] = $warranty_setting['warranty_days'];
            $data['setting_basic_change_days'] = $warranty_setting['basic_change_days'];
            $data['setting_change_days'] = $warranty_setting['change_days'];
            
            // 添加产品
            $this->allowField(true)->save($data);
            // 用户设备茶电器凭证
            if(isset($data['images']) && !empty($data['images']))
            {
                $this->addUserEquipmentImages($data['images']);
            }
            $this->commit();
            return true;
        } catch (\Exception $e) {
            $this->error = $e->getMessage();
            $this->rollback();
            return false;
        }
    }
    /**
     * 添加用户设备茶电器凭证
     * @param $images
     * @return int
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    private function addUserEquipmentImages($images)
    {
        $this->image()->delete();
        $data = array_map(function ($image_id) {
            return [
                'image_id' => $image_id,
                'wxapp_id' => self::$wxapp_id
            ];
        }, $images);
        return $this->image()->saveAll($data);
    }
    public function audit($data)
    {
        if ($data['status'] == 30 && empty($data['reject_reason'])) {
            $this->error = '请输入拒绝原因';
            return false;
        }
        if ($data['status'] == 20) {
            $warranty_setting = SettingModel::getItem('warranty');
            if(empty($warranty_setting['warranty_days'])||empty($warranty_setting['basic_change_days'])||empty($warranty_setting['change_days']))
            {
                $this->error = '请先配置保修包换信息';
                return false;
            }
            $data['setting_warranty_days'] = $warranty_setting['warranty_days'];
            $data['setting_basic_change_days'] = $warranty_setting['basic_change_days'];
            $data['setting_change_days'] = $warranty_setting['change_days'];
        }

        $this->transaction(function () use ($data) {
            $data['audit_time'] = time();
            $this->allowField(true)->save($data);

        });
        return true;
    }

    /**
     * 设置检索查询条件
     * @param $query
     */
    private function setWhere($query)
    {
        if (isset($query['search']) && !empty($query['search'])) {
            $this->where('linkname|phone', 'like', '%' . trim($query['search']) . '%');
        }
        // 用户id
        if (isset($query['user_id']) && $query['user_id'] > 0) {
            $this->where('user_equipment.user_id', '=', (int)$query['user_id']);
        }
    }
    
    public function batchRemove($ids)
    {
        $success_count = 0;
        $error_count = 0;
        $message = '';
        foreach ($ids as $id)
        {
            $this->startTrans();
            try{
                $detail = self::detail(['user_equipment_id' => $id]);
                $detail->delete();
                $this->commit();
                $success_count++;
            }catch (\Exception $e) {
                $error_count++;
                $this->rollback();
            }
        }
        if($success_count > 0)
        {
            $message.= "删除成功：".$success_count." 行；";
        }
        if($error_count > 0)
        {
            $message.= "删除失败：".$error_count." 行；请刷新后重试或联系技术人员";
        }
        return [
            'status' => $error_count ? false : true,
            'message' => $message
        ];
    }
}
