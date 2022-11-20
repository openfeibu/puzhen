<div class="row-content am-cf">
    <div class="row">
        <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
            <div class="widget am-cf">
                <div class="widget-head am-cf">
                    <div class="widget-title a m-cf">导航列表</div>
                </div>
                <div class="widget-body am-fr">
                    <!-- 工具栏 -->
                    <div class="page_toolbar am-margin-bottom-xs am-cf">
                        <div class="am-form-group">
                            <div class="am-btn-group am-btn-group-xs">
                                <a class="am-btn am-btn-default am-btn-success"
                                   href="<?= url('pc.nav/add') ?>">
                                    <span class="am-icon-plus"></span> 新增
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="am-scrollable-horizontal am-u-sm-12">
                        <table width="100%" class="am-table am-table-compact am-table-striped
                         tpl-table-black am-text-nowrap">
                            <thead>
                            <tr>
                                <th>导航ID</th>
                                <th>导航名称</th>
                                <th>导航英文名称</th>
                                <th>导航url</th>
                                <th>排序</th>
                                <th>状态</th>
                                <th>添加时间</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (!empty($list)): foreach ($list as $item): ?>
                                <tr>
                                    <td class="am-text-middle"><?= $item['nav_id'] ?></td>
                                    <td class="am-text-middle"><?= $item['name_h1'] ?></td>
                                    <td class="am-text-middle"><?= $item['en_name'] ?></td>
                                    <td class="am-text-middle"><?= $item['url'] ?></td>
                                    <td class="am-text-middle"><?= $item['sort'] ?></td>
                                    <td class="am-text-middle">
                                           <span class="j-state am-badge x-cur-p
                                           am-badge-<?= $item['status']['value'] == 1 ? 'success' : 'warning' ?>"
                                                 data-id="<?= $item['nav_id'] ?>"
                                                 data-state="<?= $item['status']['value'] ?>">
                                               <?= $item['status']['text'] ?>
                                           </span>
                                    </td>
                                    <td class="am-text-middle"><?= $item['create_time'] ?></td>
                                    <td class="am-text-middle">
                                        <div class="tpl-table-black-operation">
                                            <a href="<?= url('pc.nav/edit', ['nav_id' => $item['nav_id']]) ?>">
                                                <i class="am-icon-pencil"></i> 编辑
                                            </a>
                                            <a href="javascript:void(0);"
                                               class="item-delete tpl-table-black-operation-del"
                                               data-id="<?= $item['nav_id'] ?>">
                                                <i class="am-icon-trash"></i> 删除
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; else: ?>
                                <tr>
                                    <td colspan="6" class="am-text-center">暂无记录</td>
                                </tr>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function () {

        // 删除元素
        var url = "<?= url('pc.nav/delete') ?>";
        $('.item-delete').delete('nav_id', url, '删除后不可恢复，确定要删除吗？');

        // 产品状态
        $('.j-state').click(function () {
            var data = $(this).data();
            layer.confirm('确定要' + (parseInt(data.state) === 1 ? '隐藏' : '显示') + '该导航吗？'
                , {title: '友情提示'}
                , function (index) {
                    $.post("<?= url('pc.nav/state') ?>"
                        , {
                            nav_id: data.id,
                            state: Number(!(parseInt(data.state) === 1))
                        }
                        , function (result) {
                            result.code === 1 ? $.show_success(result.msg, result.url)
                                : $.show_error(result.msg);
                        });
                    layer.close(index);
                });
        });
    });
</script>

