<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:107:"E:\UPUPW_ANK_W64\WebRoot\Vhosts\puzhen\2.0.0\web/../source/application/store\view\statistics\data\index.php";i:1652756574;s:93:"E:\UPUPW_ANK_W64\WebRoot\Vhosts\puzhen\2.0.0\source\application\store\view\layouts\layout.php";i:1647313182;}*/ ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <title><?= $setting['store']['values']['name'] ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="renderer" content="webkit"/>
    <meta http-equiv="Cache-Control" content="no-siteapp"/>
    <link rel="icon" type="image/png" href="assets/common/i/favicon.ico"/>
    <meta name="apple-mobile-web-app-title" content="<?= $setting['store']['values']['name'] ?>"/>
    <link rel="stylesheet" href="assets/common/css/amazeui.min.css"/>
    <link rel="stylesheet" href="assets/store/css/app.css?v=<?= $version ?>"/>
    <link rel="stylesheet" href="//at.alicdn.com/t/font_783249_m68ye1gfnza.css">
    <script src="assets/common/js/jquery.min.js"></script>
    <script src="//at.alicdn.com/t/font_783249_e5yrsf08rap.js"></script>
    <script>
        BASE_URL = '<?= isset($base_url) ? $base_url : '' ?>';
        STORE_URL = '<?= isset($store_url) ? $store_url : '' ?>';
    </script>
</head>

<body data-type="">
<div class="am-g tpl-g">
    <!-- 头部 -->
    <header class="tpl-header">
        <!-- 右侧内容 -->
        <div class="tpl-header-fluid">
            <!-- 侧边切换 -->
            <div class="am-fl tpl-header-button switch-button">
                <i class="iconfont icon-menufold"></i>
            </div>
            <!-- 刷新页面 -->
            <div class="am-fl tpl-header-button refresh-button">
                <i class="iconfont icon-refresh"></i>
            </div>
            <!-- 其它功能-->
            <div class="am-fr tpl-header-navbar">
                <ul>
                    <!-- 欢迎语 -->
                    <li class="am-text-sm tpl-header-navbar-welcome">
                        <a href="<?= url('store.user/renew') ?>">欢迎你，<span><?= $store['user']['user_name'] ?></span>
                        </a>
                    </li>
                    <!-- 退出 -->
                    <li class="am-text-sm">
                        <a href="<?= url('passport/logout') ?>">
                            <i class="iconfont icon-tuichu"></i> 退出
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </header>
    <!-- 侧边导航栏 -->
    <div class="left-sidebar dis-flex">
        <?php $menus = $menus ?: []; $group = $group ?: 0; ?>
        <div class="sidebar-scroll">
            <!-- 一级菜单 -->
            <ul class="sidebar-nav">
                <li class="sidebar-nav-heading"><?= $setting['store']['values']['name'] ?></li>
                <?php foreach ($menus as $key => $item): ?>
                    <li class="sidebar-nav-link">
                        <a href="<?= isset($item['index']) ? url($item['index']) : 'javascript:void(0);' ?>"
                           class="<?= $item['active'] ? 'active' : '' ?>">
                            <?php if (isset($item['is_svg']) && $item['is_svg'] == true): ?>
                                <svg class="icon sidebar-nav-link-logo" aria-hidden="true">
                                    <use xlink:href="#<?= $item['icon'] ?>"></use>
                                </svg>
                            <?php else: ?>
                                <i class="iconfont sidebar-nav-link-logo <?= $item['icon'] ?>"
                                   style="<?= isset($item['color']) ? "color:{$item['color']};" : '' ?>"></i>
                            <?php endif; ?>
                            <?= $item['name'] ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <!-- 子级菜单-->
        <?php $second = isset($menus[$group]['submenu']) ? $menus[$group]['submenu'] : []; if (!empty($second)) : ?>
            <div class="sidebar-second-scroll">
                <ul class="left-sidebar-second">
                    <li class="sidebar-second-title"><?= $menus[$group]['name'] ?></li>
                    <li class="sidebar-second-item">
                        <?php foreach ($second as $item) : if (!isset($item['submenu'])): ?>
                                <!-- 二级菜单-->
                                <a href="<?= url($item['index']) ?>"
                                   class="<?= (isset($item['active']) && $item['active']) ? 'active' : '' ?>">
                                    <?= $item['name']; ?>
                                </a>
                            <?php else: ?>
                                <!-- 三级菜单-->
                                <div class="sidebar-third-item">
                                    <a href="javascript:void(0);"
                                       class="sidebar-nav-sub-title <?= $item['active'] ? 'active' : '' ?>">
                                        <i class="iconfont icon-caret"></i>
                                        <?= $item['name']; ?>
                                    </a>
                                    <ul class="sidebar-third-nav-sub">
                                        <?php foreach ($item['submenu'] as $third) : ?>
                                            <li>
                                                <a class="<?= $third['active'] ? 'active' : '' ?>"
                                                   href="<?= url($third['index']) ?>">
                                                    <?= $third['name']; ?></a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            <?php endif; endforeach; ?>
                    </li>
                </ul>
            </div>
        <?php endif; ?>
    </div>

    <!-- 内容区域 start -->
    <div class="tpl-content-wrapper <?= empty($second) ? 'no-sidebar-second' : '' ?>">
        <link rel="stylesheet" href="https://unpkg.com/element-ui/lib/theme-chalk/index.css">
<div id="app" v-cloak class="page-statistics-data row-content am-cf">
    <!-- 数据概况 -->
    <div class="row">
        <div class="am-u-sm-12 am-margin-bottom">
            <div class="widget widget-survey am-cf" v-loading="survey.loading">
                <div class="widget-head am-cf">
                    <div class="widget-title">数据概况</div>
                    <div class="widget-screen am-cf">
                        <!-- 日期选择器 -->
                        <div class="yxs-date-editor am-fl">
                            <el-date-picker
                                    v-model="survey.dateValue"
                                    type="daterange"
                                    size="small"
                                    @change="onChangeDate"
                                    value-format="yyyy-MM-dd"
                                    range-separator="至"
                                    start-placeholder="开始日期"
                                    end-placeholder="结束日期">
                            </el-date-picker>
                        </div>
                        <!-- 快捷选项 -->
                        <div class="widget-screen_shortcut am-fl">
                            <div class="shortcut-days am-cf">
                                <div class="shortcut-days_item am-fl">
                                    <a href="javascript:void(0);" @click="onFastDate(7)">7天</a>
                                </div>
                                <div class="shortcut-days_item am-fl">
                                    <a href="javascript:void(0);" @click="onFastDate(30)">30天</a>
                                </div>
                                <div class="shortcut-days_item item-clear am-fl">
                                    <a href="javascript:void(0);" @click="onFastDate(0)">清空</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="widget-body">
                    <div class="widget-body-center am-cf">
                        <div class="am-u-sm-6 am-u-md-6 am-u-lg-4">
                            <div class="widget-outline dis-flex flex-y-center">
                                <div class="outline-left">
                                    <img src="assets/store/img/statistics/survey/03.png" alt="">
                                </div>
                                <div class="outline-right dis-flex flex-dir-column flex-x-center">
                                    <div class="item-name">用户数量</div>
                                    <div class="item-value">{{ survey.values.user_total }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="am-u-sm-6 am-u-md-6 am-u-lg-4">
                            <div class="widget-outline dis-flex flex-y-center">
                                <div class="outline-left">
                                    <img src="assets/store/img/statistics/survey/04.png" alt="">
                                </div>
                                <div class="outline-right dis-flex flex-dir-column flex-x-center">
                                    <div class="item-name">厂家数量</div>
                                    <div class="item-value">{{ survey.values.factory_total }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="am-u-sm-6 am-u-md-6 am-u-lg-4">
                            <div class="widget-outline dis-flex flex-y-center">
                                <div class="outline-left">
                                    <img src="assets/store/img/statistics/survey/05.png" alt="">
                                </div>
                                <div class="outline-right dis-flex flex-dir-column flex-x-center">
                                    <div class="item-name">服务网点数量</div>
                                    <div class="item-value">{{ survey.values.distributor_total }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="am-u-sm-6 am-u-md-6 am-u-lg-4">
                            <div class="widget-outline dis-flex flex-y-center">
                                <div class="outline-left">
                                    <img src="assets/store/img/statistics/survey/02.png" alt="">
                                </div>
                                <div class="outline-right dis-flex flex-dir-column flex-x-center">
                                    <div class="item-name">商品数量</div>
                                    <div class="item-value">{{ survey.values.goods_total }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="am-u-sm-6 am-u-md-6 am-u-lg-4">
                            <div class="widget-outline dis-flex flex-y-center">
                                <div class="outline-left">
                                    <img src="assets/store/img/statistics/survey/03.png" alt="">
                                </div>
                                <div class="outline-right dis-flex flex-dir-column flex-x-center">
                                    <div class="item-name">茶艺机数量</div>
                                    <div class="item-value">{{ survey.values.equipment_total }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="am-u-sm-6 am-u-md-6 am-u-lg-4">
                            <div class="widget-outline dis-flex flex-y-center">
                                <div class="outline-left">
                                    <img src="assets/store/img/statistics/survey/02.png" alt="">
                                </div>
                                <div class="outline-right dis-flex flex-dir-column flex-x-center">
                                    <div class="item-name">茶艺机延保信息数量</div>
                                    <div class="item-value">{{ survey.values.user_equipment_total }}</div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 近七日交易走势 -->

    <!-- 排行榜 -->

</div>

<script src="assets/common/js/echarts.min.js"></script>
<script src="assets/common/js/echarts-walden.js"></script>
<script src="assets/common/js/vue.min.js?v=1.1.35"></script>
<script src="https://unpkg.com/element-ui/lib/index.js"></script>

<script type="text/javascript">

    new Vue({
        el: '#app',
        data: {
            // 数据概况
            survey: {
                loading: false,
                dateValue: [],
                values: <?= \app\common\library\helper::jsonEncode($survey) ?>
            },
            // 商品销售榜

            // 用户消费榜

        },

        mounted() {
            // 近七日交易走势

        },

        methods: {

            // 监听事件：日期选择快捷导航
            onFastDate: function (days) {
                var startDate, endDate;
                // 清空日期
                if (days === 0) {
                    this.survey.dateValue = [];
                } else {
                    startDate = $.getDay(-days);
                    endDate = $.getDay(0);
                    this.survey.dateValue = [startDate, endDate];
                }
                // api: 获取数据概况
                this.__getApiData__survey(startDate, endDate);
            },

            // 监听事件：日期选择框改变
            onChangeDate: function (e) {
                // api: 获取数据概况
                this.__getApiData__survey(e[0], e[1]);
            },

            // 获取数据概况
            __getApiData__survey: function (startDate, endDate) {
                var app = this;
                // 请求api数据
                app.survey.loading = true;
                // api地址
                var url = '<?= url('statistics.data/survey') ?>';
                $.post(url, {
                    startDate: startDate,
                    endDate: endDate
                }, function (result) {
                    app.survey.values = result.data;
                    app.survey.loading = false;
                });
            },

            /**
             * 近七日交易走势
             * @type {HTMLElement}
             */

        }

    });

</script>
    </div>
    <!-- 内容区域 end -->

</div>
<script src="assets/common/plugins/layer/layer.js"></script>
<script src="assets/common/js/jquery.form.min.js"></script>
<script src="assets/common/js/amazeui.min.js"></script>
<script src="assets/common/js/webuploader.html5only.js"></script>
<script src="assets/common/js/art-template.js"></script>
<script src="assets/store/js/app.js?v=<?= $version ?>"></script>
<script src="assets/store/js/file.library.js?v=<?= $version ?>"></script>
</body>

</html>
