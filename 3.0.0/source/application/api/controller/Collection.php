<?php

namespace app\api\controller;

use app\api\model\Collection as CollectionModel;

/**
 * 收藏控制器
 * Class Collection
 * @package app\api\controller
 */
class Collection extends Controller
{
    /**
     * 收藏列表
     * @param int $type
     * @return array
     * @throws \think\exception\DbException
     */
    public function lists($type)
    {
        $model = new CollectionModel;
        $user = $this->getUser();
        $list = $model->getList($type, $user);
        return $this->renderSuccess(compact('list'));
    }
    public function add($type)
    {
        $user = $this->getUser();
        $model = new CollectionModel;

        $res = $model->collect($type, $user, $this->request->post());
        if($res === -1 )
        {
            return $this->renderSuccess(['is_collection' => -1], '取消成功');
        }else if ($res === 1){
            return $this->renderSuccess(['is_collection' => 1], '收藏成功');
        }
        return $this->renderError($model->getError() ?: '操作失败');
    }

}