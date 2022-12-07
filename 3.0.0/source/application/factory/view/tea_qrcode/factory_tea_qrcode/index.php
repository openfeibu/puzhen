<div class="row-content am-cf">
    <div class="row">
        <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
            <div class="widget am-cf">
                <div class="widget-head am-cf">
                    <div class="widget-title a m-cf">厂家冲泡码列表</div>
                </div>
                <div class="widget-body am-fr">
                    <!-- 工具栏 -->
                    <div class="page_toolbar am-margin-bottom am-cf">
                        <form class="toolbar-form" action="">
                            <input type="hidden" name="s" value="/<?= $request->pathinfo() ?>">

                            <div class="am-u-sm-12 am-u-md-3">
                                <div class="am-form-group">
                                    <?php if (checkPrivilege('tea_qrcode.factory_tea_qrcode/add')): ?>
                                        <div class="am-btn-group am-btn-group-xs">
                                            <a class="am-btn am-btn-default am-btn-success"
                                               href="<?= url('tea_qrcode.factory_tea_qrcode/add') ?>">
                                                <span class="am-icon-plus"></span> 新增
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                    <?php if (checkPrivilege('tea_qrcode.factory_tea_qrcode/delete')): ?>
                                        <div class="am-btn-group am-btn-group-xs">
                                            <a class="am-btn am-btn-default am-btn-danger batch-delete"
                                               href="javascript:; ">
                                                <span class="am-icon-trash"></span> 删除
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
                                                   placeholder="请输入冲泡码方案名称"
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
                                <th>冲泡码ID</th>
                                <th>方案名称</th>
                                <th>冲泡码</th>
                                <th>英文冲泡码</th>
                                <th>创建时间</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (!$list->isEmpty()): foreach ($list as $item): ?>
                                <tr>
                                    <td class="am-text-middle">
                                        <label class="am-checkbox">
                                            <input data-am-ucheck data-check="item" data-id='<?= $item['tea_qrcode_id'] ?>' type="checkbox">
                                        </label>
                                    </td>
                                    <td class="am-text-middle"><?= $item['tea_qrcode_id'] ?></td>
                                    <td class="am-text-middle"><?= $item['name'] ?></td>
                                    <td class="am-text-middle">
                                        <a href="<?= $item['detail_image_url'] ?>"
                                           title="点击查看大图" target="_blank">
                                            <img src="<?= $item['detail_image_url'] ?>"
                                                 width="50"  alt="冲泡码">
                                        </a>
                                    </td>
                                    <td class="am-text-middle">
                                        <?php if($item['en_detail_image_url']): ?>
                                            <a href="<?= $item['en_detail_image_url'] ?>"
                                               title="点击查看大图" target="_blank">
                                                <img src="<?= $item['en_detail_image_url'] ?>"
                                                     width="50"  alt="冲泡码">
                                            </a>
                                        <?php endif; ?>
                                    </td>
                                    <!--
                                    <td class="am-text-middle">
                                        <?php if(isset($item['goods_tea_qrcode']['goods'])):?>
                                        <a href="<?= url('goods/edit', ['goods_id' => $item['goods_tea_qrcode']['goods']['goods_id']]) ?>"
                                           title="点击查看" target="_blank">
                                            <?php if(isset($item['goods_tea_qrcode']['goods']['image'][0]['file']['file_path'])):?>
                                            <img src="<?= $item['goods_tea_qrcode']['goods']['image'][0]['file']['file_path'] ?>"
                                                 width="50"  alt="<?= $item['goods_tea_qrcode']['goods']['goods_name'] ?>">
                                            <?php endif;?>
                                        </a>
                                        <?php else: ?>
                                            
                                        <?php endif;?>
                                    </td>
                                    -->
                                    <td class="am-text-middle"><?= $item['create_time'] ?></td>
                                    <td class="am-text-middle">
                                        <div class="tpl-table-black-operation">
                                            <?php if (checkPrivilege('tea_qrcode.factory_tea_qrcode/edit')): ?>
                                                <a href="<?= url('tea_qrcode.factory_tea_qrcode/edit', ['tea_qrcode_id' => $item['tea_qrcode_id']]) ?>">
                                                    <i class="am-icon-pencil"></i> 编辑
                                                </a>
                                            <?php endif; ?>

                                            <?php if (checkPrivilege('tea_qrcode.factory_tea_qrcode/delete')): ?>
                                                <a href="javascript:void(0);"
                                                   class="item-delete tpl-table-black-operation-del"
                                                   data-id="<?= $item['tea_qrcode_id'] ?>">
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
        var url = "<?= url('tea_qrcode.factory_tea_qrcode/delete') ?>";
        $('.item-delete').delete('tea_qrcode_id', url, '删除后不可恢复，确定要删除吗？');
        $('.batch-delete').batch_delete('tea_qrcode_id', url, '删除后不可恢复，确定要删除吗？');
    });
</script>

