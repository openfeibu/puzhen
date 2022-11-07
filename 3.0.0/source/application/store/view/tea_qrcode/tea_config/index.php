<div class="row-content am-cf">
    <div class="row">
        <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
            <div class="widget am-cf">
                <form id="my-form" class="am-form tpl-form-line-form" enctype="multipart/form-data" method="post">
                    <div class="widget-body">
                        <fieldset>
                            <div class="widget-head am-cf">
                                <div class="widget-title am-fl">冲泡码数据配置</div>
                            </div>
                            <table class="am-table am-table-bordered am-table-centered
                                     am-margin-bottom-xs am-text-nowrap">
                                <tbody>
                                <tr>
                                    <th></th>
                                    <th>英文名</th>
                                    <th>最小值</th>
                                    <th>最大值</th>
                                    <th>默认</th>
                                    <th>间隔</th>
                                    <th>单位</th>
                                    <th>英文单位</th>
                                </tr>
                                <?php if (isset($configs)): foreach ($configs as $config): ?>
                                <tr>
                                    <td><?= $config['name'] ?><input type="hidden" name="configs[]" value="<?= $config['type'] ?>"></td>
                                    <td><input class="border-input" type="text" placeholder="英文名" name="<?= $config['type'] ?>[en_name]" value="<?= $config['en_name'] ?>"></td>
                                    <td><input class="border-input" type="text" placeholder="最小值" name="<?= $config['type'] ?>[min]" value="<?= $config['min'] ?>"></td>
                                    <td><input class="border-input" type="text" placeholder="最大值" name="<?= $config['type'] ?>[max]" value="<?= $config['max'] ?>"></td>
                                    <td><input class="border-input" type="text" placeholder="默认" name="<?= $config['type'] ?>[default]" value="<?= $config['default'] ?>"></td>
                                    <td><input class="border-input" type="text" placeholder="间隔" name="<?= $config['type'] ?>[interval]" value="<?= $config['interval'] ?>"></td>
                                    <td><input class="border-input" type="text" placeholder="单位" name="<?= $config['type'] ?>[unit]" value="<?= $config['unit'] ?>"></td>
                                    <td><input class="border-input" type="text" placeholder="英文单位" name="<?= $config['type'] ?>[en_unit]" value="<?= $config['en_unit'] ?>"></td>
                                </tr>
                                <?php endforeach; endif; ?>
                                </tbody>
                            </table>

                            <div class="am-form-group">
                                <div class="am-u-sm-9 am-u-sm-push-3 am-margin-top-lg">
                                    <button type="submit" class="j-submit am-btn am-btn-secondary">提交
                                    </button>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(function () {

        /**
         * 表单验证提交
         * @type {*}
         */
        $('#my-form').superForm();

    });
</script>
