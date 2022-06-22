<?php

namespace app\store\model;

use app\common\library\helper;
use app\common\model\DistributorApply as DistributorApplyModel;
use Lvht\GeoHash;

/**
 * 服务网点申请模型
 * Class DistributorApply
 * @package app\store\model
 */
class DistributorApply extends DistributorApplyModel
{
    /**
     * 获取列表数据
     * @param array $param
     * @return \think\Paginator
     * @throws \think\exception\DbException
     */
    public function getList($param = [])
    {
        // 查询列表数据
        return $this->setListQueryWhere($param)
            ->with(['image'])
            ->paginate(15, false, [
                'query' => \request()->request()
            ]);
    }

    /**
     * 设置列表查询条件
     * @param array $param
     * @return $this
     */
    private function setListQueryWhere($param = [])
    {
        // 查询参数
        $param = array_merge(['search' => ''], $param);
        !empty($param['search']) && $this->where('distributor_name|linkman|phone', 'like', "%{$param['search']}%");
        return $this->order(['create_time' => 'desc']);
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
                $detail = self::detail(['apply_id' => $id]);
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