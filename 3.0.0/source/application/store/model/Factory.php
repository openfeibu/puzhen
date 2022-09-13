<?php

namespace app\store\model;

use app\common\library\helper;
use app\common\model\Factory as FactoryModel;
use app\store\model\factory\User as FactoryUser;

/**
 * 工厂模型
 * Class Factory
 * @package app\store\model
 */
class Factory extends FactoryModel
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
            ->paginate(15, false, [
                'query' => \request()->request()
            ]);
    }

    /**
     * 获取所有工厂列表
     * @param array $param
     * @return false|\PDOStatement|string|\think\Collection
     */
    public static function getAllList($param = [])
    {
        return (new static)->setListQueryWhere($param)->select();
    }

    /**
     * 设置列表查询条件
     * @param array $param
     * @return $this
     */
    private function setListQueryWhere($param = [])
    {
        // 查询参数
        $param = array_merge(['search' => '', 'status' => null,], $param);
        !empty($param['search']) && $this->where('factory_name|linkman|phone', 'like', "%{$param['search']}%");
        is_numeric($param['status']) && $this->where('status', '=', (int)$param['status']);
        return $this->where('is_delete', '=', '0')->order(['is_self' => 'desc','sort' => 'asc', 'create_time' => 'asc']);
    }

    /**
     * 新增记录
     * @param $data
     * @return bool
     * @throws \Exception
     */
    public function add($data)
    {
        if ($data['password'] !== $data['password_confirm']) {
            $this->error = '确认密码不正确';
            return false;
        }
        if (FactoryUser::checkExist($data['user_name'])) {
            $this->error = '商家用户名已存在';
            return false;
        }
        return $this->transaction(function () use ($data) {
            // 添加小程序记录
            $this->allowField(true)->save($this->createData($data));
            // 新增工厂用户信息
            (new FactoryUser)->add($this['factory_id'], $data);

            return true;
        });

    }

    /**
     * 编辑记录
     * @param $data
     * @return false|int
     */
    public function edit($data)
    {
        if (!$this->validateForm($data)) {
            return false;
        }
        return $this->allowField(true)->save($this->createData($data)) !== false;
    }

    /**
     * 软删除
     * @return false|int
     */
    public function setDelete()
    {
        return $this->save(['is_delete' => 1]);
    }

    /**
     * 创建数据
     * @param array $data
     * @return array
     */
    private function createData($data)
    {
        $data['wxapp_id'] = self::$wxapp_id;

        return $data;
    }

    /**
     * 表单验证
     * @param $data
     * @return bool
     */
    private function validateForm($data)
    {
        return true;
    }

}