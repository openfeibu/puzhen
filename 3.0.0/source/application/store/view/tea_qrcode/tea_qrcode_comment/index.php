<div class="row-content am-cf">
    <div class="row">
        <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
            <div class="widget am-cf">
                <div class="widget-head am-cf">
                    <div class="widget-title am-cf">评价列表</div>
                </div>
                <div class="widget-body am-fr">
                    <div class="am-scrollable-horizontal am-u-sm-12">
                        <table width="100%" class="am-table am-table-compact am-table-striped
                         tpl-table-black am-text-nowrap">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>产品</th>
                                <th>冲泡码方案名称</th>
                                <th>冲泡码</th>
                                <th class="am-text-middle">用户</th>
                                <th>评价内容</th>
                                <th>显示状态</th>
                                <th>评价排序</th>
                                <th>评价时间</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (!$list->isEmpty()): foreach ($list as $item): ?>
                                <tr>
                                    <td class="am-text-middle"><?= $item['comment_id'] ?></td>
                                    <td class="am-text-middle">
                                        <?php if (isset($item['goods']['image'][0]['file_path'])) : ?>
                                        <a href="<?= $item['goods']['image'][0]['file_path'] ?>"
                                           title="点击查看大图" target="_blank">
                                            <img src="<?= $item['goods']['image'][0]['file_path'] ?>"
                                                 width="50"  alt="产品图片">
                                        </a>
                                        <?php endif; ?>
                                        <p class="am-link-muted">(产品ID：<?= $item['goods_id'] ?>)</p>
                                    </td>
                                    <td class="am-text-middle">
                                        <p class="item-title"><?= $item['tea_qrcode']['name'] ?></p>
                                    </td>
                                    <td class="am-text-middle">
                                        <a href="<?= $item['tea_qrcode']['detail_image_url'] ?>"
                                           title="点击查看大图" target="_blank">
                                            <img src="<?= $item['tea_qrcode']['detail_image_url'] ?>"
                                                 width="50"  alt="冲泡码">
                                        </a>
                                    </td>
                                    <td class="am-text-middle">
                                        <p class=""><?= $item['user']['nickName'] ?></p>
                                        <p class="am-link-muted">(用户id：<?= $item['user']['user_id'] ?>)</p>
                                    </td>
                                    <td class="am-text-middle">
                                        <p class="item-title"><?= $item['content'] ?></p>
                                    </td>

                                    <td class="am-text-middle">
                                        <?php if ($item['status']) : ?>
                                            <span class="x-color-green">显示</span>
                                        <?php else: ?>
                                            <span class="x-color-red">隐藏</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="am-text-middle"><?= $item['sort'] ?></td>
                                    <td class="am-text-middle"><?= $item['create_time'] ?></td>
                                    <td class="am-text-middle">
                                        <div class="tpl-table-black-operation">
                                            <?php if (checkPrivilege('tea_qrcode.tea_qrcode_comment/detail')): ?>
                                                <a class="tpl-table-black-operation-default"
                                                   href="<?= url('tea_qrcode.tea_qrcode_comment/detail', ['comment_id' => $item['comment_id']]) ?>">
                                                    <i class="am-icon-pencil"></i> 详情
                                                </a>
                                            <?php endif; ?>
                                            <?php if (checkPrivilege('tea_qrcode.tea_qrcode_comment/delete')): ?>
                                                <a href="javascript:void(0);"
                                                   class="item-delete tpl-table-black-operation-default"
                                                   data-id="<?= $item['comment_id'] ?>">
                                                    <i class="am-icon-trash"></i> 删除
                                                </a>
                                            <?php endif; ?>
                                            <?php if (checkPrivilege('tea_qrcode.factory_tea_qrcode/edit')): ?>
                                                <a class="tpl-table-black-operation-default"
                                                   href="<?= url('tea_qrcode.factory_tea_qrcode/edit', ['tea_qrcode_id' => $item['tea_qrcode_id']]) ?>" target="_blank">
                                                    <i class="iconfont icon-order-o"></i> 冲泡码详情
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
        var url = "<?= url('tea_qrcode.tea_qrcode_comment/delete') ?>";
        $('.item-delete').delete('comment_id', url);
    });
</script>
