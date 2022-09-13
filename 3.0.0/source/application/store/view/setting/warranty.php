<div class="row-content am-cf">
    <div class="row">
        <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
            <div class="widget am-cf">
                <form id="my-form" class="am-form tpl-form-line-form" enctype="multipart/form-data" method="post">
                    <div class="widget-body">
                        <fieldset>
                            <div class="widget-head am-cf">
                                <div class="widget-title am-fl">茶电器设置</div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-form-label form-require">
                                    保修日期
                                </label>
                                <div class="am-u-sm-9">
                                    <div class="am-u-sm-6">
                                        <input type="number" class="am-form-field" name="warranty[warranty_days]"
                                               value="<?= $values['warranty_days'] ?>" required>
                                    </div>
                                    <label class="am-u-sm-6 am-form-label am-text-left">天</label>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-form-label form-require">
                                    基础包换日期
                                </label>
                                <div class="am-u-sm-9">
                                    <div class="am-u-sm-6">
                                        <input type="text" class="tpl-form-input" name="warranty[basic_change_days]"
                                               value="<?= $values['basic_change_days'] ?>" required>
                                    </div>
                                    <label class="am-u-sm-6 am-form-label am-text-left">天</label>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-form-label form-require">
                                    赠送包换日期
                                </label>
                                <div class="am-u-sm-9">
                                    <div class="am-u-sm-6">
                                        <input type="text" class="tpl-form-input" name="warranty[change_days]"
                                               value="<?= $values['change_days'] ?>" required>
                                    </div>
                                    <label class="am-u-sm-6 am-form-label am-text-left">天</label>
                                </div>
                            </div>
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
