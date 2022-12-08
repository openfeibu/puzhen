<?php

namespace app\store\model;

use think\Db;
use app\common\model\Tea as TeaModel;
/**
 * 茶模型
 * Class Comment
 * @package app\common\model
 */
class Tea extends TeaModel
{
    public function getList()
    {
        // 查询列表数据
        return $this
            ->order('code','asc')
            ->order(['tea_id' => 'asc'])
            ->paginate(15, false, [
                'query' => \request()->request()
            ]);
    }
    public function add($data)
    {
        $data['wxapp_id'] = self::$wxapp_id;
        // 开启事务
        $this->startTrans();
        try {
            // 添加产品
            $this->allowField(true)->save($data);
            $this->commit();
            return true;
        } catch (\Exception $e) {
            $this->error = $e->getMessage();
            $this->rollback();
            return false;
        }
    }
    public function edit($data)
    {
        $data['wxapp_id'] = self::$wxapp_id;
        return $this->transaction(function () use ($data) {
            // 保存
            $this->allowField(true)->save($data);
            return true;
        });
    }

}