<div class="row-content am-cf">
    <div class="row">
        <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
            <div class="widget am-cf">
                <div class="widget-head am-cf">
                    <div class="widget-title am-cf">出售中的产品</div>
                </div>
                <div class="widget-body am-fr">
                    <!-- 工具栏 -->
                    <div class="am-u-sm-12 am-u-md-12">
                        <div class="am-form-group">
                            <?php if (checkPrivilege('goods/add')): ?>
                                <div class="am-btn-group am-btn-group-xs">
                                    <a class="am-btn am-btn-default am-btn-success"
                                       href="<?= url('goods/add') ?>">
                                        <span class="am-icon-plus"></span> 新增产品
                                    </a>
                                </div>
                            <?php endif; ?>
                            <?php if (checkPrivilege('goods/import')): ?>
                                <div class="am-btn-group am-btn-group-xs">
                                    <a class="am-btn am-btn-default am-btn-success"
                                       href="<?= url('goods/import') ?>">
                                        <span class="am-icon-plus"></span> 批量导入
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="page_toolbar am-margin-bottom-xs am-cf">
                        <form class="toolbar-form" action="">
                            <input type="hidden" name="s" value="/<?= $request->pathinfo() ?>">
                          
                            <div class="am-u-sm-12 am-u-md-12">
                                <div class="am fr">
                                    <div class="am-form-group am-fl">
                                        <select name="factory_id"
                                                data-am-selected="{searchBox: 1, btnSize: 'sm', placeholder: '工厂', maxHeight: 400, btnWidth:150}" class="form_change">
                                            <option value="0">全部工厂</option>
                                            <?php if (isset($factoryList)): foreach ($factoryList as $factory): ?>
                                                <option value="<?= $factory['factory_id'] ?>"
                                                    <?= $request->get('factory_id') == $factory['factory_id'] ? 'selected' : '' ?>>
                                                    <?= $factory['factory_name'] ?>
                                                </option>
                                            <?php endforeach; endif; ?>
                                        </select>
                                    </div>
                                    <div class="am-form-group am-fl">
                                        <?php $category_id = $request->get('category_id') ?: null; ?>
                                        <select name="category_id"
                                                data-am-selected="{searchBox: 1, btnSize: 'sm',  placeholder: '产品分类', maxHeight: 400}">
                                            <option value="0">全部分类</option>
                                            <?php if (isset($catgory)): foreach ($catgory as $first): ?>
                                                <option value="<?= $first['category_id'] ?>"
                                                    <?= $category_id == $first['category_id'] ? 'selected' : '' ?>>
                                                    <?= $first['name'] ?></option>
                                                <?php if (isset($first['child'])): foreach ($first['child'] as $two): ?>
                                                    <option value="<?= $two['category_id'] ?>"
                                                        <?= $category_id == $two['category_id'] ? 'selected' : '' ?>>
                                                        　　<?= $two['name'] ?></option>
                                                <?php endforeach; endif; ?>
                                            <?php endforeach; endif; ?>
                                        </select>
                                    </div>
                                    <div class="am-form-group am-fl">
                                        <?php $status = $request->get('status') ?: null; ?>
                                        <select name="status"
                                                data-am-selected="{btnSize: 'sm', placeholder: '产品状态'}">
                                            <option value="0">全部状态</option>
                                            <option value="10"
                                                <?= $status == 10 ? 'selected' : '' ?>>上架
                                            </option>
                                            <option value="20"
                                                <?= $status == 20 ? 'selected' : '' ?>>下架
                                            </option>
                                        </select>
                                    </div>
                                    <div class="am-form-group am-fl">
                                        <div class="am-input-group am-input-group-sm tpl-form-border-form">
                                            <input type="text" class="am-form-field" name="goods_id"
                                                   placeholder="请输入产品ID"
                                                   value="<?= $request->get('goods_id') ?>">
                                        </div>
                                    </div>
                                    <div class="am-form-group am-fl">
                                        <div class="am-input-group am-input-group-sm tpl-form-border-form">
                                            <input type="text" class="am-form-field" name="search"
                                                   placeholder="请输入产品名称"
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
                                <th>产品ID</th>
                                <th>产品图片</th>
                                <th>产品名称</th>
                                <th>产品分类</th>
                                <th>工厂</th>
                                <!--<th>实际销量</th>-->
                                <th>收藏量</th>
                                <th>产品排序</th>
                                <th>产品状态</th>
                                <th>冲泡码</th>
                                <th>添加时间</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (!$list->isEmpty()): foreach ($list as $item): ?>
                                <tr>
                                    <td class="am-text-middle"><?= $item['goods_id'] ?></td>
                                    <td class="am-text-middle">
                                        <a href="<?= $item['goods_image'] ?>"
                                           title="点击查看大图" target="_blank">
                                            <img src="<?= $item['goods_image'] ?>"
                                                 width="50"  alt="产品图片">
                                        </a>
                                    </td>
                                    <td class="am-text-middle">
                                        <p class="item-title"><?= $item['goods_name'] ?></p>
                                    </td>
                                    <td class="am-text-middle"><?= $item['category']['name'] ?></td>
                                    <td class="am-text-middle"><?= $item['factory']['factory_name'] ?></td>
                                    <!--<td class="am-text-middle"><?= $item['sales_actual'] ?></td>-->
                                    <td class="am-text-middle"><?= $item['collection_count'] ?>
                                    <td class="am-text-middle"><?= $item['goods_sort'] ?></td>
                                    <td class="am-text-middle">
                                           <span class="j-state am-badge x-cur-p
                                           am-badge-<?= $item['goods_status']['value'] == 10 ? 'success' : 'warning' ?>"
                                                 data-id="<?= $item['goods_id'] ?>"
                                                 data-state="<?= $item['goods_status']['value'] ?>">
                                               <?= $item['goods_status']['text'] ?>
                                           </span>
                                    </td>
                                    <td class="am-text-middle">
                                        <?php if (isset($item['goods_tea_qrcode']) && $item['goods_tea_qrcode']): ?>
                                            <a href="<?= url('tea_qrcode.factory_tea_qrcode/edit',
                                                ['tea_qrcode_id' => $item['goods_tea_qrcode']['tea_qrcode_id']]) ?>">
                                                查看
                                            </a>
                                            <a href="<?= url('goods/bind_tea_qrcode',
                                                ['goods_id' => $item['goods_id']]) ?>">
                                                换绑
                                            </a>
                                        <?php else: ?>
                                            <a href="<?= url('tea_qrcode.factory_tea_qrcode/add',
                                                ['goods_id' => $item['goods_id']]) ?>">
                                                添加
                                            </a>
                                            <a href="<?= url('goods/bind_tea_qrcode',
                                                ['goods_id' => $item['goods_id']]) ?>">
                                                绑定
                                            </a>
                                        <?php endif; ?>
    
                                    </td>
                                    <td class="am-text-middle"><?= $item['create_time'] ?></td>
                                    <td class="am-text-middle">
                                        <div class="tpl-table-black-operation">
                                            <?php if (checkPrivilege('goods/edit')): ?>
                                                <a href="<?= url('goods/edit',
                                                    ['goods_id' => $item['goods_id']]) ?>">
                                                    <i class="am-icon-pencil"></i> 编辑
                                                </a>
                                            <?php endif; ?>
                                            <?php if (checkPrivilege('goods/delete')): ?>
                                                <a href="javascript:;" class="item-delete tpl-table-black-operation-del"
                                                   data-id="<?= $item['goods_id'] ?>">
                                                    <i class="am-icon-trash"></i> 删除
                                                </a>
                                            <?php endif; ?>
                                            <?php if (checkPrivilege('goods/copy')): ?>
                                                <a class="tpl-table-black-operation-green" href="<?= url('goods/copy',
                                                    ['goods_id' => $item['goods_id']]) ?>">
                                                    一键复制
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; else: ?>
                                <tr>
                                    <td colspan="9" class="am-text-center">暂无记录</td>
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

        // 产品状态
        $('.j-state').click(function () {
            // 验证权限
            if (!"<?= checkPrivilege('goods/state')?>") {
                return false;
            }
            var data = $(this).data();
            layer.confirm('确定要' + (parseInt(data.state) === 10 ? '下架' : '上架') + '该产品吗？'
                , {title: '友情提示'}
                , function (index) {
                    $.post("<?= url('goods/state') ?>"
                        , {
                            goods_id: data.id,
                            state: Number(!(parseInt(data.state) === 10))
                        }
                        , function (result) {
                            result.code === 1 ? $.show_success(result.msg, result.url)
                                : $.show_error(result.msg);
                        });
                    layer.close(index);
                });
        });

        // 删除元素
        var url = "<?= url('goods/delete') ?>";
        $('.item-delete').delete('goods_id', url);

    });
</script>

