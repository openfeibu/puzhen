<?php

namespace app\factory\controller\goods;

use app\factory\controller\Controller;
use app\factory\model\Spec as SpecModel;
use app\factory\model\SpecValue as SpecValueModel;

/**
 * 产品规格控制器
 * Class Spec
 * @package app\factory\controller
 */
class Spec extends Controller
{
    /* @var SpecModel $SpecModel */
    private $SpecModel;

    /* @var SpecValueModel $SpecModel */
    private $SpecValueModel;

    /**
     * 构造方法
     * @throws \app\common\exception\BaseException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function _initialize()
    {
        parent::_initialize();
        $this->SpecModel = new SpecModel;
        $this->SpecValueModel = new SpecValueModel;
    }

    /**
     * 添加规则组
     * @param $spec_name
     * @param $spec_value
     * @return array
     */
    public function addSpec($spec_name, $spec_value)
    {
        // 判断规格组是否存在
        if (!$specId = $this->SpecModel->getSpecIdByName($spec_name)) {
            // 新增规格组and规则值
            if ($this->SpecModel->add($spec_name)
                && $this->SpecValueModel->add($this->SpecModel['spec_id'], $spec_value))
                return $this->renderSuccess('', '', [
                    'spec_id' => (int)$this->SpecModel['spec_id'],
                    'spec_value_id' => (int)$this->SpecValueModel['spec_value_id'],
                ]);
            return $this->renderError();
        }
        // 判断规格值是否存在
        if ($specValueId = $this->SpecValueModel->getSpecValueIdByName($specId, $spec_value)) {
            return $this->renderSuccess('', '', [
                'spec_id' => (int)$specId,
                'spec_value_id' => (int)$specValueId,
            ]);
        }
        // 添加规则值
        if ($this->SpecValueModel->add($specId, $spec_value))
            return $this->renderSuccess('', '', [
                'spec_id' => (int)$specId,
                'spec_value_id' => (int)$this->SpecValueModel['spec_value_id'],
            ]);
        return $this->renderError();
    }

    /**
     * 添加规格值
     * @param $spec_id
     * @param $spec_value
     * @return array
     */
    public function addSpecValue($spec_id, $spec_value)
    {
        // 判断规格值是否存在
        if ($specValueId = $this->SpecValueModel->getSpecValueIdByName($spec_id, $spec_value)) {
            return $this->renderSuccess('', '', [
                'spec_value_id' => (int)$specValueId,
            ]);
        }
        // 添加规则值
        if ($this->SpecValueModel->add($spec_id, $spec_value))
            return $this->renderSuccess('', '', [
                'spec_value_id' => (int)$this->SpecValueModel['spec_value_id'],
            ]);
        return $this->renderError();
    }

}
