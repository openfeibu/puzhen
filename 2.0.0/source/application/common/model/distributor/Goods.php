<?php

namespace app\common\model\distributor;

use app\common\library\helper;
use app\common\model\BaseModel;
use app\common\service\Goods as GoodsService;

/**
 * 经销商-商品模型
 * Class Goods
 * @package app\common\model\distributor
 */
class Goods extends BaseModel
{
    protected $name = 'distributor_goods';
    protected $alias = 'distributor_goods';

    public function getList($param)
    {
        // 商品列表获取条件
        $params = array_merge([
            'goods_id' => 0,
            'status' => 10,         // 商品状态
            'category_id' => 0,     // 分类id
            'distributor_id' => 0,     // 经销商id
            'factory_id' => 0,     // 工厂id
            'search' => '',         // 搜索关键词
            'sortType' => 'all',    // 排序类型
            'sortPrice' => false,   // 价格排序 高低
            'listRows' => 15,       // 每页数量
        ], $param);
        // 筛选条件
        $filter = [];
        $params['category_id'] > 0 && $filter['goods.category_id'] = ['IN', Category::getSubCategoryId($params['category_id'])];
        $params['status'] > 0 && $filter['goods.goods_status'] = $params['status'];
        $params['goods_id'] > 0 && $filter[$this->alias.'.goods_id'] = $params['goods_id'];
        $params['factory_id'] > 0 && $filter['goods.factory_id'] = $params['factory_id'];
        $params['distributor_id'] > 0 && $filter[$this->alias.'.distributor_id'] = $params['distributor_id'];
        !empty($params['search']) && $filter['goods.goods_name'] = ['like', '%' . trim($params['search']) . '%'];

        $this->setBaseQuery($this->alias, [
            ['goods', 'goods_id'],
        ]);
        $GoodsSku = new \app\common\model\GoodsSku;
        $minPriceSql = $GoodsSku->field(['MIN(goods_price)'])
            ->where('goods_id', 'EXP', "= `goods`.`goods_id`")->buildSql();
        $maxPriceSql = $GoodsSku->field(['MAX(goods_price)'])
            ->where('goods_id', 'EXP', "= `goods`.`goods_id`")->buildSql();
        // 获取活动列表
        $list = $this->where("goods.is_delete", '=', 0)
            ->where($filter)
            ->order(['goods.goods_sort' => 'asc', 'goods.goods_id' => 'desc'])
            ->field([ 'goods.*','(goods.sales_initial + goods.sales_actual) as goods_sales',
                "$minPriceSql AS goods_min_price",
                "$maxPriceSql AS goods_max_price"
            ])
            ->with(['goods.category', 'goods.sku', 'goods.image.file'])
            ->paginate(15, false, [
                'query' => \request()->request()
            ]);
        // 设置商品数据
        return $this->setGoodsListData($list, true);
    }

    /**
     * 关联商品表
     * @return \think\model\relation\BelongsTo
     */
    public function goods()
    {
        $module = self::getCalledModule() ?: 'common';
        return $this->belongsTo("app\\{$module}\\model\\Goods");
    }

    public function distributor()
    {
        $module = self::getCalledModule() ?: 'common';
        return $this->belongsTo("app\\{$module}\\model\\Distributor");
    }
    /**
     * 设置商品展示的数据
     * @param $data
     * @param bool $isMultiple
     * @param callable|null $callback
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    protected function setGoodsListData($data, $isMultiple = true, callable $callback = null)
    {
        // 设置原商品数据
        //$data = GoodsService::setGoodsData($data, $isMultiple);
        if (!$isMultiple) $dataSource = [&$data]; else $dataSource = &$data;
        // 整理商品数据
        foreach ($dataSource as $key => &$item) {
            //var_dump($item['goods']['sku'][0]);exit;
            // 商品图片
            $item['goods_image'] = $item['goods']['image'][0]['file_path'];
            // 秒杀商品sku信息
            $item['goods_sku'] =  $item['goods']['sku'][0];
            // 回调函数
            is_callable($callback) && call_user_func($callback, $item);
        }
        return $data;
    }
}