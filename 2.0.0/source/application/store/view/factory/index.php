<div class="row-content am-cf">
    <div class="row">
        <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
            <div class="widget am-cf">
                <div class="widget-head am-cf">
                    <div class="widget-title a m-cf">工厂列表</div>
                </div>
                <div class="widget-body am-fr">
                    <!-- 工具栏 -->
                    <div class="page_toolbar am-margin-bottom am-cf">
                        <form class="toolbar-form" action="">
                            <input type="hidden" name="s" value="/<?= $request->pathinfo() ?>">
                            <div class="am-u-sm-12 am-u-md-3">
                                <div class="am-form-group">
                                    <?php if (checkPrivilege('factory/add')): ?>
                                        <div class="am-btn-group am-btn-group-xs">
                                            <a class="am-btn am-btn-default am-btn-success"
                                               href="<?= url('factory/add') ?>">
                                                <span class="am-icon-plus"></span> 新增
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
                                                   placeholder="请输入工厂名称/联系人/电话"
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
                                <th>工厂ID</th>
                                <th>工厂名称</th>
                                <th>联系人</th>
                                <th>联系电话</th>
                                <th>工厂状态</th>
                                <th>创建时间</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (!$list->isEmpty()): foreach ($list as $item): ?>
                                <tr>
                                    <td class="am-text-middle"><?= $item['factory_id'] ?></td>
                                    <td class="am-text-middle"><?= $item['factory_name'] ?></td>
                                    <td class="am-text-middle"><?= $item['linkman'] ?></td>
                                    <td class="am-text-middle"><?= $item['phone'] ?></td>
                                    <td class="am-text-middle">
                                            <span class="am-badge am-badge-<?= $item['status'] ? 'success' : 'warning' ?>">
                                               <?= $item['status'] ? '启用' : '禁用' ?>
                                           </span>
                                    </td>
                                    <td class="am-text-middle"><?= $item['create_time'] ?></td>
                                    <td class="am-text-middle">
                                        <div class="tpl-table-black-operation">
                                            <?php if (checkPrivilege('factory/enter')): ?>
                                                <a href="<?= url('factory/enter', ['factory_id' => $item['factory_id']]) ?>"
                                                   class="j-move" data-id="<?= $item['factory_id'] ?>" target="_blank">
                                                    <i class="am-icon-arrow-right"></i> 进入工厂
                                                </a>
                                            <?php endif; ?>
                                            <?php if (checkPrivilege('factory/edit')): ?>
                                                <a href="<?= url('factory/edit', ['factory_id' => $item['factory_id']]) ?>">
                                                    <i class="am-icon-pencil"></i> 编辑
                                                </a>
                                            <?php endif; ?>
                                            <?php if (!$item['is_self']): ?>
                                                <?php if (checkPrivilege('factory/delete')): ?>
                                                    <a href="javascript:void(0);"
                                                       class="item-delete tpl-table-black-operation-del"
                                                       data-id="<?= $item['factory_id'] ?>">
                                                        <i class="am-icon-trash"></i> 删除
                                                    </a>
                                                <?php endif; ?>
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
        var url = "<?= url('factory/delete') ?>";
        $('.item-delete').delete('factory_id', url, '删除后不可恢复，确定要删除吗？');

    });
</script>

