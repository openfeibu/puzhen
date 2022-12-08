<div class="row-content am-cf">
    <div class="row">
        <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
            <div class="widget am-cf">
                <div class="widget-head am-cf">
                    <div class="widget-title a m-cf">茶配置</div>
                </div>
                <div class="widget-body am-fr">
                    <!-- 工具栏 -->
                    <div class="page_toolbar am-margin-bottom am-cf">
                        <form class="toolbar-form" action="">
                            <input type="hidden" name="s" value="/<?= $request->pathinfo() ?>">

                            <div class="am-u-sm-12 am-u-md-3">
                                <div class="am-form-group">
                                    <?php if (checkPrivilege('tea_qrcode.tea/add')): ?>
                                        <div class="am-btn-group am-btn-group-xs">
                                            <a class="am-btn am-btn-default am-btn-success"
                                               href="<?= url('tea_qrcode.tea/add') ?>">
                                                <span class="am-icon-plus"></span> 新增
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                    <?php if (checkPrivilege('tea_qrcode.tea/delete')): ?>
                                        <div class="am-btn-group am-btn-group-xs">
                                            <a class="am-btn am-btn-default am-btn-danger batch-delete"
                                               href="javascript:; ">
                                                <span class="am-icon-trash"></span> 删除
                                            </a>
                                        </div>
                                    <?php endif; ?>
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
                                <th>code</th>
                                <th>茶名</th>
                                <th>英文茶名</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (!$list->isEmpty()): foreach ($list as $item): ?>
                                <tr>
                                    <td class="am-text-middle">
                                        <label class="am-checkbox">
                                            <input data-am-ucheck data-check="item" data-id='<?= $item['tea_id'] ?>' type="checkbox">
                                        </label>
                                    </td>
                                    <td class="am-text-middle"><?= $item['code'] ?></td>
                                    <td class="am-text-middle"><?= $item['name'] ?></td>
                                    <td class="am-text-middle"><?= $item['en_name'] ?></td>
                                    <td class="am-text-middle">
                                        <div class="tpl-table-black-operation">
                                            <?php if (checkPrivilege('tea_qrcode.tea/edit')): ?>
                                                <a href="<?= url('tea_qrcode.tea/edit', ['tea_id' => $item['tea_id']]) ?>">
                                                    <i class="am-icon-pencil"></i> 编辑
                                                </a>
                                            <?php endif; ?>

                                            <?php if (checkPrivilege('tea_qrcode.tea/delete')): ?>
                                                <a href="javascript:void(0);"
                                                   class="item-delete tpl-table-black-operation-del"
                                                   data-id="<?= $item['tea_id'] ?>">
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
        var url = "<?= url('tea_qrcode.tea/delete') ?>";
        $('.item-delete').delete('tea_id', url, '删除后不可恢复，确定要删除吗？');
        $('.batch-delete').batch_delete('tea_id', url, '删除后不可恢复，确定要删除吗？');
    });
</script>

