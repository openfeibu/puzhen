<?php

namespace app\common\model;

use app\common\library\helper;
use app\common\service\Goods as GoodsService;

/**
 * 产品模型
 * Class Goods
 * @package app\common\model
 */
class Goods extends BaseModel
{
    protected $name = 'goods';
    protected $append = ['goods_sales'];

    /**
     * 计算显示销量 (初始销量 + 实际销量)
     * @param $value
     * @param $data
     * @return mixed
     */
    public function getGoodsSalesAttr($value, $data)
    {
        return $data['sales_initial'] + $data['sales_actual'];
    }

    /**
     * 获取器：单独设置折扣的配置
     * @param $json
     * @return mixed
     */
    public function getAloneGradeEquityAttr($json)
    {
        return json_decode($json, true);
    }

    /**
     * 修改器：单独设置折扣的配置
     * @param $data
     * @return mixed
     */
    public function setAloneGradeEquityAttr($data)
    {
        return json_encode($data);
    }

    /**
     * 关联产品分类表
     * @return \think\model\relation\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo('Category');
    }

    public function factory()
    {
        return $this->belongsTo('Factory');
    }

    public function goodsTeaQrcode()
    {
        return $this->hasOne('goods_tea_qrcode');
    }

    /**
     * 关联产品规格表
     * @return \think\model\relation\HasMany
     */
    public function sku()
    {
        return $this->hasMany('GoodsSku')->order(['goods_sku_id' => 'asc']);
    }

    /**
     * 关联产品规格关系表
     * @return \think\model\relation\BelongsToMany
     */
    public function specRel()
    {
        return $this->belongsToMany('SpecValue', 'GoodsSpecRel')->order(['id' => 'asc']);
    }

    /**
     * 关联产品图片表
     * @return \think\model\relation\HasMany
     */
    public function image()
    {
        return $this->hasMany('GoodsImage')->order(['id' => 'asc']);
    }

    /**
     * 关联运费模板表
     * @return \think\model\relation\BelongsTo
     */
    public function delivery()
    {
        return $this->BelongsTo('Delivery');
    }

    /**
     * 关联订单评价表
     * @return \think\model\relation\HasMany
     */
    public function commentData()
    {
        return $this->hasMany('Comment');
    }

    /**
     * 计费方式
     * @param $value
     * @return mixed
     */
    public function getGoodsStatusAttr($value)
    {
        $status = [10 => '上架', 20 => '下架'];
        return ['text' => $status[$value], 'value' => $value];
    }

    /**
     * 获取产品列表
     * @param $param
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function getList($param)
    {
        // 产品列表获取条件
        $params = array_merge([
            'goods_id' => 0,
            'status' => 10,         // 产品状态
            'factory.status' => -1, //工厂状态
            'category_id' => 0,     // 分类id
            'factory_id' => 0,     // 工厂id
            'search' => '',         // 搜索关键词
            'sortType' => 'all',    // 排序类型
            'sort' => false,   // 价格/收藏量 排序 高低
            'listRows' => 15,       // 每页数量
        ], $param);
        // 筛选条件
        $filter = [];
        $params['category_id'] > 0 && $filter['goods.category_id'] = ['IN', Category::getSubCategoryId($params['category_id'])];
        $params['status'] > 0 && $filter['goods.goods_status'] = $params['status'];
        $params['goods_id'] > 0 && $filter['goods.goods_id'] = $params['goods_id'];
        $params['factory_id'] > 0 && $filter['goods.factory_id'] = $params['factory_id'];
        !empty($params['search']) && $filter['goods.goods_name'] = ['like', '%' . trim($params['search']) . '%'];
        $params['factory.status'] > -1 && $filter['factory.status'] = $params['factory.status'];
        // 排序规则
        $sort = [];
        if ($params['sortType'] === 'all') {
            $sort = ['goods.goods_sort', 'goods.goods_id' => 'desc'];
        } elseif ($params['sortType'] === 'sales') {
            $sort = ['goods.goods_sales' => 'desc'];
        } elseif ($params['sortType'] === 'price') {
            $sort = $params['sort'] == 'desc' ? ['goods.goods_max_price' => 'desc'] : ['goods.goods_min_price' => 'asc'];
        }elseif ($params['sortType'] === 'ref_price') {
            $sort = $params['sort'] == 'desc' ? ['goods.goods_max_ref_price' => 'desc'] : ['goods.goods_min_ref_price' => 'asc'];
        }elseif ($params['sortType'] === 'collection_count') {
            $sort = $params['sort'] == 'desc' ? ['goods.collection_count' => 'desc'] : ['goods.collection_count' => 'asc'];
        }
        // 产品表名称
        //$tableName = $this->getTable();
        // 多规格产品 最高价与最低价
        $GoodsSku = new GoodsSku;
        $minPriceSql = $GoodsSku->field(['MIN(goods_price)'])
            ->where('goods_id', 'EXP', "= `goods`.`goods_id`")->buildSql();
        $maxPriceSql = $GoodsSku->field(['MAX(goods_price)'])
            ->where('goods_id', 'EXP', "= `goods`.`goods_id`")->buildSql();

        $minRefPriceSql = $GoodsSku->field(['MIN(ref_price)'])
            ->where('goods_id', 'EXP', "= `goods`.`goods_id`")->buildSql();
        $maxRefPriceSql = $GoodsSku->field(['MAX(ref_price)'])
            ->where('goods_id', 'EXP', "= `goods`.`goods_id`")->buildSql();

        // 执行查询
        $list = $this
            ->setBaseQuery('goods', [
              ['factory', 'factory_id'],
            ])
            ->field(['goods.*', '(goods.sales_initial + goods.sales_actual) as goods_sales',
                "$minPriceSql AS goods_min_price",
                "$maxPriceSql AS goods_max_price",
                "$minRefPriceSql AS goods_min_ref_price",
                "$maxRefPriceSql AS goods_max_ref_price"
            ])
            ->with(['category', 'image.file', 'sku'])
            ->where('factory.is_delete', '=', 0)
            ->where('goods.is_delete', '=', 0)
            ->where($filter)
            ->order($sort)
            ->paginate($params['listRows'], false, [
                'query' => \request()->request()
            ]);
        // 整理列表数据并返回
        return $this->setGoodsListData($list, true);
    }

    /**
     * 设置产品展示的数据
     * @param $data
     * @param bool $isMultiple
     * @param callable $callback
     * @return mixed
     */
    public function setGoodsListData($data, $isMultiple = true, callable $callback = null)
    {
        if (!$isMultiple) $dataSource = [&$data]; else $dataSource = &$data;
        // 整理产品列表数据
        foreach ($dataSource as &$goods) {
            // 产品主图
            $goods['goods_image'] = $goods['image'][0]['file_path'] ?? '';
            // 产品默认规格
            $goods['goods_sku'] = $goods['sku'][0];
            // 回调函数
            is_callable($callback) && call_user_func($callback, $goods);
        }
        return $data;
    }

    /**
     * 根据产品id集获取产品列表
     * @param array $goodsIds
     * @param null $status
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getListByIds($goodsIds, $status = null)
    {
        // 筛选条件
        $filter = ['goods_id' => ['in', $goodsIds]];
        $status > 0 && $filter['goods_status'] = $status;
        if (!empty($goodsIds)) {
            $this->orderRaw('field(goods_id, ' . implode(',', $goodsIds) . ')');
        }
        // 获取产品列表数据
//        ['category', 'image.file', 'sku', 'spec_rel.spec', 'delivery.rule']
        $data = $this->field(['content'], true)
            ->with(['category', 'image.file', 'sku'])
            ->where($filter)
            ->select();
        // 整理列表数据并返回
        return $this->setGoodsListData($data, true);
    }

    /**
     * 产品多规格信息
     * @param \think\Collection $specRel
     * @param \think\Collection $skuData
     * @return array
     */
    public function getManySpecData($specRel, $skuData)
    {

        // spec_attr
        $specAttrData = [];
        foreach ($specRel as $item) {
            if (!isset($specAttrData[$item['spec_id']])) {
                $specAttrData[$item['spec_id']] = [
                    'group_id' => $item['spec']['spec_id'],
                    'group_name' => $item['spec']['spec_name'],
                    'spec_items' => [],
                ];
            }
            $specAttrData[$item['spec_id']]['spec_items'][] = [
                'item_id' => $item['spec_value_id'],
                'spec_value' => $item['spec_value'],
            ];
        }

        // spec_list
        $specListData = [];
        foreach ($skuData as $item) {
            $image = (isset($item['image']) && !empty($item['image'])) ? $item['image'] : ['file_id' => 0, 'file_path' => ''];
            $specListData[] = [
                'goods_sku_id' => $item['goods_sku_id'],
                'spec_sku_id' => $item['spec_sku_id'],
                'rows' => [],
                'form' => [
                    'image_id' => $image['file_id'],
                    'image_path' => $image['file_path'],
                    'goods_no' => $item['goods_no'],
                    'goods_price' => $item['goods_price'],
                    'goods_weight' => $item['goods_weight'],
                    'line_price' => $item['line_price'],
                    'stock_num' => $item['stock_num'],
                ],
            ];
        }
        return ['spec_attr' => array_values($specAttrData), 'spec_list' => $specListData];
    }

    /**
     * 多规格表格数据
     * @param $goods
     * @return array
     */
    public function getManySpecTable(&$goods)
    {
        $specData = $this->getManySpecData($goods['spec_rel'], $goods['sku']);
        $totalRow = count($specData['spec_list']);
        foreach ($specData['spec_list'] as $i => &$sku) {
            $rowData = [];
            $rowCount = 1;
            foreach ($specData['spec_attr'] as $attr) {
                $skuValues = $attr['spec_items'];
                $rowCount *= count($skuValues);
                $anInterBankNum = ($totalRow / $rowCount);
                $point = (($i / $anInterBankNum) % count($skuValues));
                if (0 === ($i % $anInterBankNum)) {
                    $rowData[] = [
                        'rowspan' => $anInterBankNum,
                        'item_id' => $skuValues[$point]['item_id'],
                        'spec_value' => $skuValues[$point]['spec_value']
                    ];
                }
            }
            $sku['rows'] = $rowData;
        }
        return $specData;
    }

    /**
     * 获取产品详情
     * @param $goodsId
     * @return static
     */
    public static function detail($goodsId)
    {
        /* @var $model self */
        $model = (new static)->with([
            'category',
            'image.file',
            'sku.image',
            'spec_rel.spec',
        ])->where('goods_id', '=', $goodsId)
            ->find();
        if (empty($model)) {
            return $model;
        }
        // 整理产品数据并返回
        return $model->setGoodsListData($model, false);
    }

    /**
     * 指定的产品规格信息
     * @param static $goods 产品详情
     * @param int $specSkuId
     * @return array|bool
     */
    public static function getGoodsSku($goods, $specSkuId)
    {
        // 获取指定的sku
        $goodsSku = [];
        foreach ($goods['sku'] as $item) {
            if ($item['spec_sku_id'] == $specSkuId) {
                $goodsSku = $item;
                break;
            }
        }
        if (empty($goodsSku)) {
            return false;
        }
        // 多规格文字内容
        $goodsSku['goods_attr'] = '';
        if ($goods['spec_type'] == 20) {
            $specRelData = helper::arrayColumn2Key($goods['spec_rel'], 'spec_value_id');
            $attrs = explode('_', $goodsSku['spec_sku_id']);
            foreach ($attrs as $specValueId) {
                $goodsSku['goods_attr'] .= $specRelData[$specValueId]['spec']['spec_name'] . ':'
                    . $specRelData[$specValueId]['spec_value'] . '; ';
            }
        }
        return $goodsSku;
    }

}
