<div class="row-content am-cf">
    <div class="row">
        <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
            <div class="widget am-cf">
                <div class="widget-head am-cf">
                    <div class="widget-title am-cf">产品分类</div>
                </div>
                <div class="widget-body am-fr">
                    <div class="tips am-margin-bottom-sm am-u-sm-12">
                        <div class="pre">
                            <p> 注：产品分类最多添加2级</p>
                        </div>
                    </div>
                    <div class="am-u-sm-12 am-u-md-6 am-u-lg-6">
                        <div class="am-form-group">
                            <div class="am-btn-toolbar">
                                <?php if (checkPrivilege('goods.category/add')): ?>
                                    <div class="am-btn-group am-btn-group-xs">
                                        <a class="am-btn am-btn-default am-btn-success am-radius"
                                           href="<?= url('goods.category/add') ?>">
                                            <span class="am-icon-plus"></span> 新增
                                        </a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="am-u-sm-12">
                        <table width="100%" class="am-table am-table-compact am-table-striped tpl-table-black ">
                            <thead>
                            <tr>
                                <th>分类ID</th>
                                <th>分类名称</th>
                                <th>分类排序</th>
                                <th>官网状态</th>
                                <th>添加时间</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (!empty($list)): foreach ($list as $first): ?>
                                <tr>
                                    <td class="am-text-middle"><?= $first['category_id'] ?></td>
                                    <td class="am-text-middle"><?= $first['name'] ?> <?= $first['en_name'] ?></td>
                                    <td class="am-text-middle"><?= $first['sort'] ?></td>
                                    <td class="am-text-middle">
                                           <span class="j-show_web am-badge x-cur-p
                                           am-badge-<?= $first['show_web']  ? 'success' : 'warning' ?>"
                                                 data-id="<?= $first['category_id'] ?>"
                                                 data-show_web="<?= $first['show_web'] ?>">
                                                <?= $first['show_web'] ? '官网显示' : '官网隐藏' ?>
                                           </span>
                                    </td>
                                    <td class="am-text-middle"><?= $first['create_time'] ?></td>
                                    <td class="am-text-middle">
                                        <div class="tpl-table-black-operation">
                                            <?php if (checkPrivilege('goods.category/edit')): ?>
                                                <a href="<?= url('goods.category/edit',
                                                    ['category_id' => $first['category_id']]) ?>">
                                                    <i class="am-icon-pencil"></i> 编辑
                                                </a>
                                            <?php endif; ?>
                                            <?php if (checkPrivilege('goods.category/delete')): ?>
                                                <a href="javascript:;" class="item-delete tpl-table-black-operation-del"
                                                   data-id="<?= $first['category_id'] ?>">
                                                    <i class="am-icon-trash"></i> 删除
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                                <?php if (isset($first['child'])): foreach ($first['child'] as $two): ?>
                                    <tr>
                                        <td class="am-text-middle"><?= $two['category_id'] ?></td>
                                        <td class="am-text-middle">　-- <?= $two['name'] ?> <?= $two['en_name'] ?></td>
                                        <td class="am-text-middle"><?= $two['sort'] ?></td>
                                        <td class="am-text-middle">
                                           <span class="j-show_web am-badge x-cur-p
                                           am-badge-<?= $two['show_web']  ? 'success' : 'warning' ?>"
                                                 data-id="<?= $two['category_id'] ?>"
                                                 data-show_web="<?= $two['show_web'] ?>">
                                                <?= $two['show_web'] ? '官网显示' : '官网隐藏' ?>
                                           </span>
                                        </td>
                                        <td class="am-text-middle"><?= $two['create_time'] ?></td>
                                        <td class="am-text-middle">
                                            <div class="tpl-table-black-operation">
                                                <?php if (checkPrivilege('goods.category/edit')): ?>
                                                    <a href="<?= url('goods.category/edit',
                                                        ['category_id' => $two['category_id']]) ?>">
                                                        <i class="am-icon-pencil"></i> 编辑
                                                    </a>
                                                <?php endif; ?>
                                                <?php if (checkPrivilege('goods.category/delete')): ?>
                                                    <a href="javascript:;"
                                                       class="item-delete tpl-table-black-operation-del"
                                                       data-id="<?= $two['category_id'] ?>">
                                                        <i class="am-icon-trash"></i> 删除
                                                    </a>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php if (isset($two['child'])): foreach ($two['child'] as $three): ?>
                                        <tr>
                                            <td class="am-text-middle"><?= $three['category_id'] ?></td>
                                            <td class="am-text-middle">　　　-- <?= $three['name'] ?> <?= $three['en_name'] ?></td>
                                            <td class="am-text-middle">
                                           <span class="j-show_web am-badge x-cur-p
                                           am-badge-<?= $three['show_web']  ? 'success' : 'warning' ?>"
                                                 data-id="<?= $three['category_id'] ?>"
                                                 data-show_web="<?= $three['show_web'] ?>">
                                                <?= $three['show_web'] ? '官网显示' : '官网隐藏' ?>
                                           </span>
                                            </td>
                                            <td class="am-text-middle"><?= $three['create_time'] ?></td>
                                            <td class="am-text-middle">
                                                <div class="tpl-table-black-operation">
                                                    <?php if (checkPrivilege('goods.category/edit')): ?>
                                                        <a href="<?= url('goods.category/edit',
                                                            ['category_id' => $three['category_id']]) ?>">
                                                            <i class="am-icon-pencil"></i> 编辑
                                                        </a>
                                                    <?php endif; ?>
                                                    <?php if (checkPrivilege('goods.category/delete')): ?>
                                                        <a href="javascript:;"
                                                           class="item-delete tpl-table-black-operation-del"
                                                           data-id="<?= $three['category_id'] ?>">
                                                            <i class="am-icon-trash"></i> 删除
                                                        </a>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; endif; ?>
                                <?php endforeach; endif; ?>
                            <?php endforeach; else: ?>
                                <tr>
                                    <td colspan="5" class="am-text-center">暂无记录</td>
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
        var url = "<?= url('goods.category/delete') ?>";
        $('.item-delete').delete('category_id', url);
        $('.j-show_web').click(function () {
            var data = $(this).data();
            layer.confirm('确定官网' + (parseInt(data.show_web) ? '隐藏' : '显示') + '该分类吗？'
                , {title: '友情提示'}
                , function (index) {
                    $.post("<?= url('goods.category/showWeb') ?>"
                        , {
                            category_id: data.id,
                            showWeb: Number(!(parseInt(data.show_web) === 1))
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

