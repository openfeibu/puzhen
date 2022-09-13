<?php

namespace app\api\controller\user;

use app\api\controller\Controller;
use app\api\model\UserEquipment;

/**
 * 用户设备管理
 * Class Equipment
 * @package app\api\controller\user
 */
class Equipment extends Controller
{

    /* @var \app\api\model\User $user */
    private $user;

    /**
     * 构造方法
     * @throws \app\common\exception\BaseException
     * @throws \think\exception\DbException
     */
    public function _initialize()
    {
        parent::_initialize();
        $this->user = $this->getUser();   // 用户信息
    }

    /**
     * 用户设备列表
     * @return array
     * @throws \app\common\exception\BaseException
     * @throws \think\exception\DbException
     */
    public function lists()
    {
        $model = new UserEquipment;
        $list = $model->getList($this->user['user_id']);
        return $this->renderSuccess([
            'list' => $list,
        ]);
    }

    /**
     * 添加用户设备
     * @return array
     * @throws \app\common\exception\BaseException
     * @throws \think\exception\DbException
     */
    public function add()
    {
        $model = new UserEquipment;
        if ($model->add($this->user, $this->request->post())) {
            return $this->renderSuccess([], '添加成功');
        }
        return $this->renderError($model->getError() ?: '添加失败');
    }

    /**
     * 用户设备详情
     * @param $user_equipment_id
     * @return array
     * @throws \app\common\exception\BaseException
     * @throws \think\exception\DbException
     */
    public function detail($user_equipment_id)
    {
        $detail = UserEquipment::detail([
            'user_id' => $this->user['user_id'],
            'user_equipment_id' => $user_equipment_id
        ]);
        return $this->renderSuccess(compact('detail'));
    }

   

    /**
     * 删除用户设备
     * @param $user_equipment_id
     * @return array
     * @throws \app\common\exception\BaseException
     * @throws \think\exception\DbException
     */
    public function delete($user_equipment_id)
    {
        $model = UserEquipment::detail([
            'user_id' => $this->user['user_id'],
            'user_equipment_id' => $user_equipment_id
        ]);
        if ($model->remove()) {
            return $this->renderSuccess([], '删除成功');
        }
        return $this->renderError($model->getError() ?: '删除失败');
    }
}