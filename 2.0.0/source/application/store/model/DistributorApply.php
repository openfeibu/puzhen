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

}