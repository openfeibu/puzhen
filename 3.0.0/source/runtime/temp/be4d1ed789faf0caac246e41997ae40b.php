<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:115:"E:\UPUPW_ANK_W64\WebRoot\Vhosts\puzhen\2.0.0\web/../source/application/store\view\equipment\user_equipment\edit.php";i:1654595596;s:93:"E:\UPUPW_ANK_W64\WebRoot\Vhosts\puzhen\2.0.0\source\application\store\view\layouts\layout.php";i:1655712011;}*/ ?>
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
                <form id="my-form" class="am-form tpl-form-line-form" method="post">
                    <div class="widget-body">
                        <fieldset>
                            <div class="widget-head am-cf">
                                <div class="widget-title am-fl">用户茶电器详情</div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label"> 用户 </label>
                                <div class="am-u-sm-9 am-u-end am-padding-top-xs">
                                    <?= $model['user']['nickName'] ?>（ <?= $model['user_id'] ?>）
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label"> 茶电器 </label>
                                <div class="am-u-sm-9 am-u-end am-padding-top-xs">
                                    <?= $model['equipment']['equipment_name'] ?> <?= $model['equipment']['model'] ?>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label"> 茶电器图片 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <div class="am-form-file">
                                        <div class="am-form-file">
                                            <div class="uploader-list am-cf">
                                                <div class="file-item">
                                                    <a href="<?= $model['equipment']['image']['file_path'] ?>"
                                                       title="点击查看大图" target="_blank">
                                                        <img src="<?= $model['equipment']['image']['file_path'] ?>">
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label"> 联系人 </label>
                                <div class="am-u-sm-9 am-u-end am-padding-top-xs">
                                    <?= $model['linkname'] ?>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label"> 手机号码 </label>
                                <div class="am-u-sm-9 am-u-end am-padding-top-xs">
                                    <?= $model['phone'] ?>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label"> 购买日期 </label>
                                <div class="am-u-sm-9 am-u-end am-padding-top-xs">
                                    <?= $model['buy_date'] ?>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label"> 序列号 </label>
                                <div class="am-u-sm-9 am-u-end am-padding-top-xs">
                                    <?= $model['equipment_sn'] ?>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label">凭证 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <div class="am-form-file">
                                        <div class="uploader-list am-cf">
                                            <?php foreach ($model['image'] as $key => $item): ?>
                                                <div class="file-item">
                                                    <a href="<?= $item['file_path'] ?>" title="点击查看大图" target="_blank">
                                                        <img src="<?= $item['file_path'] ?>">
                                                    </a>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php if ($model['status']['value'] == 20): ?>
                                <div class="am-form-group">
                                    <label class="am-u-sm-3 am-u-lg-2 am-form-label"> 保修日期 </label>
                                    <div class="am-u-sm-9 am-u-end am-padding-top-xs">
                                        <?= $model['setting_warranty_days'] ?>天
                                    </div>
                                </div>
                                <div class="am-form-group">
                                    <label class="am-u-sm-3 am-u-lg-2 am-form-label"> 基础包换日期 </label>
                                    <div class="am-u-sm-9 am-u-end am-padding-top-xs">
                                        <?= $model['setting_basic_change_days'] ?>天
                                    </div>
                                </div>
                                <div class="am-form-group">
                                    <label class="am-u-sm-3 am-u-lg-2 am-form-label"> 赠送包换日期 </label>
                                    <div class="am-u-sm-9 am-u-end am-padding-top-xs">
                                        <?= $model['setting_change_days'] ?>天
                                    </div>
                                </div>

                                <div class="am-form-group">
                                    <label class="am-u-sm-3 am-u-lg-2 am-form-label"> 只换不修剩余时间 </label>
                                    <div class="am-u-sm-9 am-u-end am-padding-top-xs">
                                        <?= $model['change_days_text'] ?>天
                                    </div>
                                </div>
                                <div class="am-form-group">
                                    <label class="am-u-sm-3 am-u-lg-2 am-form-label"> 保修剩余时间 </label>
                                    <div class="am-u-sm-9 am-u-end am-padding-top-xs">
                                        <?= $model['warranty_days_text'] ?>天
                                    </div>
                                </div>
                            <?php elseif ($model['status']['value'] == 30): ?>
                                <div class="am-form-group">
                                    <label class="am-u-sm-3 am-u-lg-2 am-form-label"> 驳回原因 </label>
                                    <div class="am-u-sm-9 am-u-end am-padding-top-xs">
                                        <?= $model['reject_reason'] ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                        </fieldset>


                    </div>
                </form>
                <!-- 商家审核 -->
                <?php if (checkPrivilege('equipment.user_equipment/audit')): if ($model['status']['value'] == 10): ?>
                        <div class="widget-head am-cf" id="check">
                            <div class="widget-title am-fl">商家审核</div>
                        </div>
                        <!-- 去审核 -->
                        <form id="audit" class="audit-form am-form tpl-form-line-form" method="post"
                              action="<?= url('equipment.user_equipment/audit', ['user_equipment_id' => $model['user_equipment_id']]) ?>">
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">审核状态 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <label class="am-radio-inline">
                                        <input type="radio" name="user_equipment[status]"
                                               value="20"
                                               data-am-ucheck
                                               checked
                                               required>
                                        同意
                                    </label>
                                    <label class="am-radio-inline">
                                        <input type="radio" name="user_equipment[status]"
                                               value="30"
                                               data-am-ucheck>
                                        拒绝
                                    </label>
                                </div>
                            </div>
                            <div class="item-agree-20 form-tab-group  active">
                                <div class="am-form-group">
                                    <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">保修日期 </label>
                                    <div class="am-u-sm-9 am-u-end am-padding-top-xs">
                                        <?= $warranty_setting['warranty_days'] ?>天
                                    </div>
                                    <!--
                                    <div class="am-u-sm-9 am-u-end">
                                        <div class="am-u-sm-6">
                                            <input type="number" class="tpl-form-input" name="user_equipment[setting_warranty_days]" value="<?= $warranty_setting['warranty_days'] ?>" required>
                                        </div>
                                        <label class="am-u-sm-6 am-form-label am-text-left">天</label>
                                    </div>
                                    -->
                                </div>
                                <div class="am-form-group">
                                    <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">基础包换日期 </label>
                                    <div class="am-u-sm-9 am-u-end am-padding-top-xs">
                                        <?= $warranty_setting['basic_change_days'] ?>天
                                    </div>
                                    <!--
                                    <div class="am-u-sm-9 am-u-end">
                                        <div class="am-u-sm-6">
                                            <input type="number" class="tpl-form-input" name="user_equipment[setting_basic_change_days]" value="<?= $warranty_setting['basic_change_days'] ?>" required>
                                        </div>
                                        <label class="am-u-sm-6 am-form-label am-text-left">天</label>
                                    </div>
                                    -->
                                </div>
                                <div class="am-form-group">
                                    <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">赠送包换日期 </label>
                                    <div class="am-u-sm-9 am-u-end am-padding-top-xs">
                                        <?= $warranty_setting['change_days'] ?>天
                                    </div>
                                    
                                    <!--
                                    <div class="am-u-sm-9 am-u-end">
                                        <div class="am-u-sm-6">
                                            <input type="number" class="tpl-form-input" name="user_equipment[setting_change_days]" value="<?= $warranty_setting['change_days'] ?>" required>
                                        </div>
                                        <label class="am-u-sm-6 am-form-label am-text-left">天</label>
                                    </div>
                                    -->
                                    
                                </div>
                            </div>
                            <div class="item-agree-30 form-tab-group am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">拒绝原因 </label>
                                <div class="am-u-sm-9 am-u-end">
                                            <textarea class="am-field-valid" rows="4" placeholder="请输入拒绝原因"
                                                      name="user_equipment[reject_reason]"></textarea>
                                    <small>如审核状态为拒绝，则需要输入拒绝原因</small>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <div class="am-u-sm-10 am-u-sm-push-2 am-margin-top-lg">
                                    <button type="submit" class="j-submit am-btn am-btn-sm am-btn-secondary">
                                        确认审核
                                    </button>
                                </div>
                            </div>
                            <!-- 提示 -->
                            <?php if (checkPrivilege('store/setting/warranty')): ?>
                            <div class="tips am-margin-top-lg am-margin-bottom-sm">
                                <div class="pre">
                                   <p>配置保修包换日期请前往<a href="<?= url('store/setting/warranty') ?>" target="_blank">页面链接</a></p>
                                </div>
                            </div>
                            <?php endif; ?>
                        </form>
                    <?php endif; endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
    $(function () {

        // 切换审核状态
        $("input:radio[name='user_equipment[status]']").change(function (e) {
            $('.form-tab-group')
                .removeClass('active')
                .filter('.item-agree-' + e.currentTarget.value)
                .addClass('active');
        });

        /**
         * 表单验证提交
         * @type {*}
         */
        $('.audit-form').superForm();

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
