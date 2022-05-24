<link rel="stylesheet" href="assets/store/css/goods.css?v=<?= $version ?>">
<link rel="stylesheet" href="assets/common/plugins/umeditor/themes/default/css/umeditor.css">
<div class="row-content am-cf">
    <div class="row">
        <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
            <div class="widget am-cf">
                <form id="my-form" class="am-form tpl-form-line-form" method="post">
                    <div class="widget-body">
                        <fieldset>
                            <div class="widget-head am-cf">
                                <div class="widget-title am-fl">基本信息</div>
                            </div>
                            <!--
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require"> 工厂 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <select name="goods[factory_id]" required
                                            data-am-selected="{searchBox: 1, btnSize: 'sm', placeholder:'请选择', maxHeight: 400}"
                                    >
                                        <option value=""></option>
                                        <?php if (isset($factoryList) && !$factoryList->isEmpty()):
                                            foreach ($factoryList as $item): ?>
                                                <option value="<?= $item['factory_id'] ?>">
                                                    <?= $item['factory_name'] ?></option>
                                            <?php endforeach; endif; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">产品分类 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <select name="goods[category_id]" required
                                            data-am-selected="{searchBox: 1, btnSize: 'sm',
                                             placeholder:'请选择产品分类', maxHeight: 400}">
                                        <option value=""></option>
                                        <?php if (isset($catgory)): foreach ($catgory as $first): ?>
                                            <option value="<?= $first['category_id'] ?>"><?= $first['name'] ?></option>
                                            <?php if (isset($first['child'])): foreach ($first['child'] as $two): ?>
                                                <option value="<?= $two['category_id'] ?>">
                                                    　　<?= $two['name'] ?></option>
                                                <?php if (isset($two['child'])): foreach ($two['child'] as $three): ?>
                                                    <option value="<?= $three['category_id'] ?>">
                                                        　　　<?= $three['name'] ?></option>
                                                <?php endforeach; endif; ?>
                                            <?php endforeach; endif; ?>
                                        <?php endforeach; endif; ?>
                                    </select>
                                    <small class="am-margin-left-xs">
                                        <a href="<?= url('goods.category/add') ?>">去添加</a>
                                    </small>
                                </div>
                            </div>
                            -->
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">文件 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <div class="am-form-group am-form-file">
                                        <button type="button" class="am-btn am-btn-danger am-btn-sm">
                                            <i class="am-icon-cloud-upload"></i> 选择要上传的文件</button>
                                        <input id="doc-form-file" name="myfile" type="file" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                                        <small>excel文档 xls、xlsx、csv格式</small>
                                    </div>
                                    <div id="file-list"></div>
                                </div>
                            </div>

                            <!-- 表单提交按钮 -->
                            <div class="am-form-group">
                                <div class="am-u-sm-9 am-u-sm-push-3 am-margin-top-lg">
                                    <button type="submit" class="j-submit am-btn am-btn-secondary">提交
                                    </button>
                                </div>
                            </div>

                        </fieldset>
                    </div>
                </form>
                <!-- 提示 -->
                <div class="tips am-margin-top-lg am-margin-bottom-sm">
                    <div class="pre">
                        <p>1. 点击下载模板-><a href="<?= base_url().'uploads/import_template/factory_goods.xlsx' ?>" target="_blank">"批量上传产品模板"</a>。</p>
                        <p>2. 请勿修改第一行字段，并按照对应字段填写表格。</p>
                        <p>3. 工厂名称、产品分类请严格按照系统数据填写。产品名称、参考零售价、产品重量(Kg)不能为空。</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 图片文件列表模板 -->
{{include file="layouts/_template/tpl_file_item" /}}

<!-- 文件库弹窗 -->
{{include file="layouts/_template/file_library" /}}

<script src="assets/common/js/vue.min.js"></script>
<script src="assets/common/js/ddsort.js"></script>
<script src="assets/common/plugins/umeditor/umeditor.config.js?v=<?= $version ?>"></script>
<script src="assets/common/plugins/umeditor/umeditor.min.js"></script>
<script src="assets/store/js/goods.spec.js?v=<?= $version ?>"></script>
<script>

    $(function () {


        $('#my-form').superForm();
        $('#doc-form-file').on('change', function() {
            var file = this.files[0];
            if (file.size > 10 * 1024 * 1024) { //限制上传文件的 大小,此处为10M
                $.show_error("你选择的文件超过10M了！");
                return false;
            }
            var type=this.value.toLowerCase().split('.').splice(-1); //获取上传的文件的后缀名
            if (type[0]!="xls"&&type[0]!="xlsx"&&type[0]!="csv") { //只能上传doc,docx 格式的文件
                $.show_error("文件必须为excel文档 xls、xlsx、csv格式！");
                $('#doc-form-file').val("") //如上传的文件格式不符合要求,文件显示部分不显示
                return false;
            }
            var fileNames = '';
            $.each(this.files, function() {
                fileNames += '<span class="am-badge">' + this.name + '</span> ';
            });
            $('#file-list').html(fileNames);
        });

    });
</script>
