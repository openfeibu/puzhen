<?php

namespace app\store\controller\tea_qrcode;

use app\common\model\Tea;
use app\store\model\Factory;
use app\store\model\TeaConfig as TeaConfigModel;
use app\store\model\Goods as GoodsModel;
use app\store\controller\Controller;

/**
 * 冲泡配置管理
 * Class TeaConfig
 * @package app\store\controller
 */
class TeaConfig extends Controller
{
    /**
     * 冲泡配置列表
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function index()
    {
        $model = new TeaConfigModel;
        if (!$this->request->isAjax()) {
            $configs = $model->order('tea_config_id','asc')->select()->toArray();
            return $this->fetch('index',compact('configs'));
        }
        // 新增记录
        if ($model->edit($this->postData())) {
            return $this->renderSuccess('更新成功', url('index'));
        }
        return $this->renderError($model->getError() ?: '更新失败');
    }



}