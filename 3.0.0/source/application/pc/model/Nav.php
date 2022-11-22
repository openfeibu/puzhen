<?php

namespace app\pc\model;

use think\Cache;
use app\common\model\Nav as NavModel;
use app\common\enum\Setting as SettingEnum;

/**
 * 系统设置模型
 * Class Wxapp
 * @package app\store\model
 */
class Nav extends NavModel
{
    /**
     * 隐藏字段
     * @var array
     */
    protected $hidden = [
        'status',
        'wxapp_id',
        'create_time',
        'update_time'
    ];
    /**
     * 获取权限列表
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getList()
    {
        $all = static::getAll(['status' => 1]);
        $pathinfo = request()->pathinfo();
        foreach ($all as $key => &$item)
        {
            if($pathinfo == 'pc/'.$item['url'])
            {
                $item['active'] = 1;
                break;
            }
            if(strpos($item['url'],'&') !== false){
                $arr = explode('&',$item['url']);
                $url = $arr[0];
                if($pathinfo == 'pc/'.$url)
                {
                    $item['active'] = 1;
                    break;
                }
            }

        }
        return $this->formatTreeData($all);
    }
}
