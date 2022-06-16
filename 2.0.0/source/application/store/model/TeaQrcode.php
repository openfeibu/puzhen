<?php

namespace app\store\model;

use app\common\model\Tea;
use app\common\model\TeaQrcode as TeaQrcodeModel;
use app\common\service\TeaQrCode as TeaQrCodeService;
/**
 * 冲泡码模型类
 * Class User
 * @package app\api\model
 */
class TeaQrcode extends TeaQrcodeModel
{
    public function getList($type)
    {
        $params = request()->param();
        $filter = [];
        $list = $this;
        switch ($type)
        {
            case 'factory':
                $list = $list->with(['goods_tea_qrcode.goods.image.file']);
                $filter['factory_id'] = ['<>',0];
                break;
            case 'user':
                $filter['user_id'] = ['<>',0];
                break;
        }
        !empty($params['search']) && $filter['name'] = ['like', '%' . trim($params['search']) . '%'];
        !empty($params['factory_id']) && $filter['factory_id'] = $params['factory_id'];
        !empty($params['user_id']) && $filter['user_id'] = $params['user_id'];
        $list = $list
            ->where($filter)
            ->order(['tea_qrcode_id' => 'desc'])
            ->paginate(15, false, [
                'query' => \request()->request()
            ]);

        // 整理列表数据并返回
        return $list;
    }
    public function add($post,$factory)
    {
        try {
            $post['url'] = 'https://api.fspuzhen.cn?type=weapp&factory_id='.$factory['factory_id'] ;
            $teaQrCodeService = new TeaQrCodeService($post);
            $teaQrCodeService->factory = $factory;
            $teaQrCodeService->generate();
            $data = $teaQrCodeService->getTeaQrcodeData();
            $data['wxapp_id'] = self::$wxapp_id;

            $this->data($data)->save() ;
            if(isset($post['goods_id'])){
                $this->goodsTeaQrcode()->save([
                    'goods_id' => $post['goods_id'],
                    'wxapp_id' => self::$wxapp_id
                ]);
            }
            $this->commit();
            return true;
        } catch (\Exception $e) {
            $this->error = $e->getMessage();
            $this->rollback();
            return false;
        }
    }
    public function bindTeaQrcode($post)
    {
        try {
            $tea_qrcode = self::detail($post['tea_qrcode_id']);
            $goods = Goods::detail($post['goods_id']);
            $goods->goodsTeaQrcode()->delete();
            $tea_qrcode->goodsTeaQrcode()->save([
                'goods_id' => $post['goods_id'],
                'wxapp_id' => self::$wxapp_id
            ]);
            $this->commit();
            return true;
        } catch (\Exception $e) {
            $this->error = $e->getMessage();
            $this->rollback();
            return false;
        }
    }


}
