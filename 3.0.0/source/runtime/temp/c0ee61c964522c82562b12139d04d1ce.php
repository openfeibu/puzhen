<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:96:"E:\UPUPW_ANK_W64\WebRoot\Vhosts\puzhen\2.0.0\web/../source/application/store\view\user\index.php";i:1655783346;s:93:"E:\UPUPW_ANK_W64\WebRoot\Vhosts\puzhen\2.0.0\source\application\store\view\layouts\layout.php";i:1655712011;}*/ ?>
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
        <div class="row-content am-cf">
    <div class="row">
        <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
            <div class="widget am-cf">
                <div class="widget-head am-cf">
                    <div class="widget-title am-cf">用户列表</div>
                </div>
                <div class="widget-body am-fr">
                    <!-- 工具栏 -->
                    <div class="page_toolbar am-margin-bottom-xs am-cf">
                        <form class="toolbar-form" action="">
                            <input type="hidden" name="s" value="/<?= $request->pathinfo() ?>">
                            <div class="am-u-sm-12 am-u-md-9 am-u-sm-push-3">
                                <div class="am fr">
                                    <div class="am-form-group am-fl">
                                        <!--
                                        <?php $gender = $request->get('gender'); ?>
                                        <select name="gender"
                                                data-am-selected="{btnSize: 'sm', placeholder: '请选择性别'}">
                                            <option value=""></option>
                                            <option value="-1"
                                                <?= $gender === '-1' ? 'selected' : '' ?>>全部
                                            </option>
                                            <option value="1"
                                                <?= $gender === '1' ? 'selected' : '' ?>>男
                                            </option>
                                            <option value="2"
                                                <?= $gender === '2' ? 'selected' : '' ?>>女
                                            </option>
                                            <option value="0"
                                                <?= $gender === '0' ? 'selected' : '' ?>>未知
                                            </option>
                                        </select>
                                        -->
                                    </div>
                                    <div class="am-form-group am-fl">
                                        <div class="am-input-group am-input-group-sm tpl-form-border-form">
                                            <input type="text" class="am-form-field" name="nickName"
                                                   placeholder="请输入微信昵称"
                                                   value="<?= $request->get('nickName') ?>">
                                            <div class="am-input-group-btn">
                                                <button class="am-btn am-btn-default am-icon-search"
                                                        type="submit"></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="am-scrollable-horizontal am-u-sm-12">
                        <table width="100%" class="am-table am-table-compact am-table-striped
                         tpl-table-black am-text-nowrap">
                            <thead>
                            <tr>
                                <th>用户ID</th>
                                <th>微信头像</th>
                                <th>微信昵称</th>
                                <!--
                                <th>性别</th>
                                <th>国家</th>
                                <th>省份</th>
                                <th>城市</th>
                                -->
                                <th>注册时间</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (!$list->isEmpty()): foreach ($list as $item): ?>
                                <tr>
                                    <td class="am-text-middle"><?= $item['user_id'] ?></td>
                                    <td class="am-text-middle">
                                        <a href="<?= $item['avatarUrl'] ?>" title="点击查看大图" target="_blank">
                                            <img src="<?= $item['avatarUrl'] ?>" width="72"  alt="">
                                        </a>
                                    </td>
                                    <td class="am-text-middle"><?= $item['nickName'] ?></td>
                                    <!--
                                    <td class="am-text-middle"><?= $item['gender'] ?></td>
                                    <td class="am-text-middle"><?= $item['country'] ?: '--' ?></td>
                                    <td class="am-text-middle"><?= $item['province'] ?: '--' ?></td>
                                    <td class="am-text-middle"><?= $item['city'] ?: '--' ?></td>
                                    -->
                                    <td class="am-text-middle"><?= $item['create_time'] ?></td>
                                    <td class="am-text-middle">
                                        <div class="tpl-table-black-operation">

                                            <?php if (checkPrivilege('user/delete')): ?>
                                                <a class="j-delete tpl-table-black-operation-default"
                                                   href="javascript:void(0);"
                                                   data-id="<?= $item['user_id'] ?>" title="删除用户">
                                                    <i class="am-icon-trash"></i> 删除
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; else: ?>
                                <tr>
                                    <td colspan="13" class="am-text-center">暂无记录</td>
                                </tr>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="am-u-lg-12 am-cf">
                        <div class="am-fr"><?= $list->render() ?> </div>
                        <div class="am-fr pagination-total am-margin-right">
                            <div class="am-vertical-align-middle">总记录：<?= $list->total() ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 模板：修改会员等级 -->
<script id="tpl-grade" type="text/template">
    <div class="am-padding-xs am-padding-top">
        <form class="am-form tpl-form-line-form" method="post" action="">
            <div class="am-tab-panel am-padding-0 am-active">
                <div class="am-form-group">
                    <label class="am-u-sm-3 am-form-label form-require">
                        会员等级
                    </label>
                    <div class="am-u-sm-8 am-u-end">
                        <select name="grade[grade_id]"
                                data-am-selected="{btnSize: 'sm', placeholder: '请选择会员等级'}">
                            <option value="0">无等级</option>
                            <?php foreach ($gradeList as $item): ?>
                                <option value="<?= $item['grade_id'] ?>"
                                    <?= $grade == $item['grade_id'] ? 'selected' : '' ?>><?= $item['name'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="am-form-group">
                    <label class="am-u-sm-3 am-form-label"> 管理员备注 </label>
                    <div class="am-u-sm-8 am-u-end">
                                <textarea rows="2" name="grade[remark]" placeholder="请输入管理员备注"
                                          class="am-field-valid"></textarea>
                    </div>
                </div>
            </div>
        </form>
    </div>
</script>

<!-- 模板：用户充值 -->
<script id="tpl-recharge" type="text/template">
    <div class="am-padding-xs am-padding-top-sm">
        <form class="am-form tpl-form-line-form" method="post" action="">
            <div class="j-tabs am-tabs">

                <ul class="am-tabs-nav am-nav am-nav-tabs">
                    <li class="am-active"><a href="#tab1">充值余额</a></li>
                    <li><a href="#tab2">充值积分</a></li>
                </ul>

                <div class="am-tabs-bd am-padding-xs">

                    <div class="am-tab-panel am-padding-0 am-active" id="tab1">
                        <div class="am-form-group">
                            <label class="am-u-sm-3 am-form-label">
                                当前余额
                            </label>
                            <div class="am-u-sm-8 am-u-end">
                                <div class="am-form--static">{{ balance }}</div>
                            </div>
                        </div>
                        <div class="am-form-group">
                            <label class="am-u-sm-3 am-form-label">
                                充值方式
                            </label>
                            <div class="am-u-sm-8 am-u-end">
                                <label class="am-radio-inline">
                                    <input type="radio" name="recharge[balance][mode]"
                                           value="inc" data-am-ucheck checked>
                                    增加
                                </label>
                                <label class="am-radio-inline">
                                    <input type="radio" name="recharge[balance][mode]" value="dec" data-am-ucheck>
                                    减少
                                </label>
                                <label class="am-radio-inline">
                                    <input type="radio" name="recharge[balance][mode]" value="final" data-am-ucheck>
                                    最终金额
                                </label>
                            </div>
                        </div>
                        <div class="am-form-group">
                            <label class="am-u-sm-3 am-form-label">
                                变更金额
                            </label>
                            <div class="am-u-sm-8 am-u-end">
                                <input type="number" min="0" class="tpl-form-input"
                                       placeholder="请输入要变更的金额" name="recharge[balance][money]" value="" required>
                            </div>
                        </div>
                        <div class="am-form-group">
                            <label class="am-u-sm-3 am-form-label">
                                管理员备注
                            </label>
                            <div class="am-u-sm-8 am-u-end">
                                <textarea rows="2" name="recharge[balance][remark]" placeholder="请输入管理员备注"
                                          class="am-field-valid"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="am-tab-panel am-padding-0" id="tab2">
                        <div class="am-form-group">
                            <label class="am-u-sm-3 am-form-label">
                                当前积分
                            </label>
                            <div class="am-u-sm-8 am-u-end">
                                <div class="am-form--static">{{ points }}</div>
                            </div>
                        </div>
                        <div class="am-form-group">
                            <label class="am-u-sm-3 am-form-label">
                                充值方式
                            </label>
                            <div class="am-u-sm-8 am-u-end">
                                <label class="am-radio-inline">
                                    <input type="radio" name="recharge[points][mode]"
                                           value="inc" data-am-ucheck checked>
                                    增加
                                </label>
                                <label class="am-radio-inline">
                                    <input type="radio" name="recharge[points][mode]" value="dec" data-am-ucheck>
                                    减少
                                </label>
                                <label class="am-radio-inline">
                                    <input type="radio" name="recharge[points][mode]" value="final" data-am-ucheck>
                                    最终积分
                                </label>
                            </div>
                        </div>
                        <div class="am-form-group">
                            <label class="am-u-sm-3 am-form-label">
                                变更数量
                            </label>
                            <div class="am-u-sm-8 am-u-end">
                                <input type="number" min="0" class="tpl-form-input"
                                       placeholder="请输入要变更的数量" name="recharge[points][value]" value="" required>
                            </div>
                        </div>
                        <div class="am-form-group">
                            <label class="am-u-sm-3 am-form-label">
                                管理员备注
                            </label>
                            <div class="am-u-sm-8 am-u-end">
                                <textarea rows="2" name="recharge[points][remark]" placeholder="请输入管理员备注"
                                          class="am-field-valid"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>
</script>

<script>
    $(function () {

        /**
         * 账户充值
         */
        $('.j-recharge').on('click', function () {
            var $tabs, data = $(this).data();
            $.showModal({
                title: '用户充值'
                , area: '460px'
                , content: template('tpl-recharge', data)
                , uCheck: true
                , success: function ($content) {
                    $tabs = $content.find('.j-tabs');
                    $tabs.tabs({noSwipe: 1});
                }
                , yes: function ($content) {
                    $content.find('form').myAjaxSubmit({
                        url: '<?= url('user/recharge') ?>',
                        data: {
                            user_id: data.id,
                            source: $tabs.data('amui.tabs').activeIndex
                        }
                    });
                    return true;
                }
            });
        });

        /**
         * 修改会员等级
         */
        $('.j-grade').on('click', function () {
            var data = $(this).data();
            $.showModal({
                title: '修改会员等级'
                , area: '460px'
                , content: template('tpl-grade', data)
                , uCheck: true
                , success: function ($content) {
                }
                , yes: function ($content) {
                    $content.find('form').myAjaxSubmit({
                        url: '<?= url('user/grade') ?>',
                        data: {user_id: data.id}
                    });
                    return true;
                }
            });
        });

        /**
         * 注册操作事件
         * @type {jQuery|HTMLElement}
         */
        var $dropdown = $('.j-opSelect');
        $dropdown.dropdown();
        $dropdown.on('click', 'li a', function () {
            var $this = $(this);
            var id = $this.parent().parent().data('id');
            var type = $this.data('type');
            if (type === 'delete') {
                layer.confirm('删除后不可恢复，确定要删除吗？', function (index) {
                    $.post("index.php?s=/store/apps.dealer.user/delete", {dealer_id: id}, function (result) {
                        result.code === 1 ? $.show_success(result.msg, result.url)
                            : $.show_error(result.msg);
                    });
                    layer.close(index);
                });
            }
            $dropdown.dropdown('close');
        });

        // 删除元素
        var url = "<?= url('user/delete') ?>";
        $('.j-delete').delete('user_id', url, '删除后不可恢复，确定要删除吗？');

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
<script>
    $(function () {
        
    });
</script>
</body>

</html>
