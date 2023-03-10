<div class="row-content am-cf">
    <div class="row">
        <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
            <div class="widget am-cf">
                <div class="widget-head am-cf">
                    <div class="widget-title a m-cf">加盟申请列表</div>
                </div>
                <div class="widget-body am-fr">
                    <!-- 工具栏 -->
                    <div class="page_toolbar am-margin-bottom am-cf">
                        <form class="toolbar-form" action="">
                            <input type="hidden" name="s" value="/<?= $request->pathinfo() ?>">
                            <div class="am-u-sm-12 am-u-md-3">
                                <div class="am-form-group">
                                    <div class="am-form-group">
                                        <?php if (checkPrivilege('distributor.distributor_apply/delete')): ?>
                                            <div class="am-btn-group am-btn-group-xs">
                                                <a class="am-btn am-btn-default am-btn-danger batch-delete"
                                                   href="javascript:; ">
                                                    <span class="am-icon-trash"></span> 删除
                                                </a>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="am-u-sm-12 am-u-md-9">
                                <div class="am fr">
                                    <div class="am-form-group am-fl">
                                        <div class="am-input-group am-input-group-sm tpl-form-border-form">
                                            <input type="text" class="am-form-field" name="search"
                                                   placeholder="企业名称/联系人/联系人手机号"
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
                                <th>
                                    <label class="am-checkbox">
                                        <input data-am-ucheck data-check="all" type="checkbox">
                                    </label>
                                </th>
                                <th>申请ID</th>
                                <th class="am-text-middle">用户</th>
                                <th>企业名称</th>
                                <th>联系人</th>
                                <th>手机号码</th>
                                <th>创建时间</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (!$list->isEmpty()): foreach ($list as $item): ?>
                                <tr>
                                    <td class="am-text-middle">
                                        <label class="am-checkbox">
                                            <input data-am-ucheck data-check="item" data-id='<?= $item['apply_id'] ?>' type="checkbox">
                                        </label>
                                    </td>
                                    <td class="am-text-middle"><?= $item['apply_id'] ?></td>
                                    <td class="am-text-middle">
                                        <p class=""><?= $item['user']['nickName'] ?></p>
                                        <p class="am-link-muted">(用户id：<?= $item['user']['user_id'] ?>)</p>
                                    </td>
                                    <td class="am-text-middle"><?= $item['distributor_name'] ?></td>
                                    <td class="am-text-middle"><?= $item['linkman'] ?></td>
                                    <td class="am-text-middle"><?= $item['phone'] ?></td>
                                    <td class="am-text-middle"><?= $item['create_time'] ?></td>
                                    <td class="am-text-middle">
                                        <div class="tpl-table-black-operation">
                                            <?php if (checkPrivilege('distributor.distributor_apply/edit')): ?>
                                              
                                                <a href="<?= url('distributor.distributor_apply/edit',
                                                           ['apply_id' => $item['apply_id']]) ?>">详情</a>

                                            <?php endif; ?>
                                            <?php if (checkPrivilege('distributor.distributor_apply/delete')): ?>
                                                <a href="javascript:void(0);"
                                                   class="item-delete tpl-table-black-operation-del"
                                                   data-id="<?= $item['apply_id'] ?>">
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
        var url = "<?= url('distributor.distributor_apply/delete') ?>";
        $('.item-delete').delete('apply_id', url, '删除后不可恢复，确定要删除吗？');
        $('.batch-delete').batch_delete('apply_id', url, '删除后不可恢复，确定要删除吗？');

    });
</script>

