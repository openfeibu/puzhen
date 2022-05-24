<div class="row-content am-cf">
    <div class="row">
        <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
            <div class="widget am-cf">
                <div class="widget-head am-cf">
                    <div class="widget-title a m-cf"><?= $title ?></div>
                </div>
                <div class="widget-body am-fr">
                    <!-- 工具栏 -->
                    <div class="page_toolbar am-margin-bottom am-cf">
                        <form class="toolbar-form" action="">
                            <input type="hidden" name="s" value="/<?= $request->pathinfo() ?>">
                            <div class="am-u-sm-12 am-u-md-3">
                                <div class="am-form-group">
                                    <?php if (checkPrivilege('equipment.user_equipment/add')): ?>
                                        <div class="am-btn-group am-btn-group-xs">
                                            <a class="am-btn am-btn-default am-btn-success"
                                               href="<?= url('equipment.user_equipment/add') ?>">
                                                <span class="am-icon-plus"></span> 新增用户茶电器
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="am-u-sm-12 am-u-md-9">
                                <div class="am fr">
                                    <div class="am-form-group am-fl">
                                        <div class="am-input-group am-input-group-sm tpl-form-border-form">
                                            <input type="text" class="am-form-field" name="search"
                                                   placeholder="联系人/联系人手机号"
                                                   value="<?= $request->get('search') ?>">
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
                                <th>申请ID</th>
                                <th class="am-text-middle">用户</th>
                                <th>联系人</th>
                                <th>手机号</th>
                                <th>购买日期</th>
                                <th>茶电器</th>
                                <!--<th>茶电器图片</th>-->
                                <th>序列号</th>
                                <?php if ($status == 20): ?>
                                    <th>只换不修剩余时间</th>
                                    <th>保修剩余时间</th>
                                <?php elseif ($status == 30): ?>
                                    <th>驳回原因</th>
                                <?php endif; ?>
                                <th>创建时间</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (!$list->isEmpty()): foreach ($list as $item): ?>
                                <tr>
                                    <td class="am-text-middle"><?= $item['user_equipment_id'] ?></td>
                                    <td class="am-text-middle">
                                        <p class=""><?= $item['user']['nickName'] ?></p>
                                        <p class="am-link-muted">(用户id：<?= $item['user']['user_id'] ?>)</p>
                                    </td>
                                    <td class="am-text-middle"><?= $item['linkname'] ?></td>
                                    <td class="am-text-middle"><?= $item['phone'] ?></td>
                                    <td class="am-text-middle"><?= $item['buy_date'] ?></td>
                                    <td class="am-text-middle">
                                        <div class="goods-info">
                                            <p class="goods-title"><?= $item['equipment']['equipment_name'] ?></p>
                                            <p class="goods-spec am-link-muted"><?= $item['equipment']['model'] ?></p>
                                        </div>

                                    </td>
                                    <!--
                                    <td class="am-text-middle">
                                        <a href="<?= $item['equipment']['image']['file_path'] ?>" title="点击查看大图" target="_blank">
                                            <img src="<?= $item['equipment']['image']['file_path'] ?>" width="72" height="72" alt="">
                                        </a>
                                    </td>
                                    -->
                                    <td class="am-text-middle"><?= $item['equipment_sn'] ?></td>
                                    <?php if ($status == 20): ?>
                                        <td class="am-text-middle"><?= $item['change_days_text'] ?></td>
                                        <td class="am-text-middle"><?= $item['warranty_days_text'] ?></td>
                                    <?php elseif ($status == 30): ?>
                                        <td class="am-text-middle"><?= $item['reject_reason'] ?></td>
                                    <?php endif; ?>
                                    <td class="am-text-middle"><?= $item['create_time'] ?></td>
                                    <td class="am-text-middle">
                                        <div class="tpl-table-black-operation">
                                            <?php if (checkPrivilege('equipment.user_equipment/edit')): ?>
                                                <?php if ($item['status']['value'] == 10): ?>
                                                    <a class="j-audit"
                                                       href="<?= url('equipment.user_equipment/edit#check',
                                                           ['user_equipment_id' => $item['user_equipment_id']]) ?>">去审核</a>
                                                <?php else: ?>
                                                    <a href="<?= url('equipment.user_equipment/edit',
                                                           ['user_equipment_id' => $item['user_equipment_id']]) ?>">详情</a>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                            <?php if (checkPrivilege('equipment.user_equipment/delete')): ?>
                                                <a href="javascript:void(0);"
                                                   class="item-delete tpl-table-black-operation-del"
                                                   data-id="<?= $item['user_equipment_id'] ?>">
                                                    <i class="am-icon-trash"></i> 删除
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; else: ?>
                                <tr>
                                    <td colspan="11" class="am-text-center">暂无记录</td>
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
<script>
    $(function () {

        // 删除元素
        var url = "<?= url('equipment.user_equipment/delete') ?>";
        $('.item-delete').delete('user_equipment_id', url, '删除后不可恢复，确定要删除吗？');

    });
</script>

