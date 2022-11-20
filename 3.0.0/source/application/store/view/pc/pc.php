
<div class="row-content am-cf">
    <div class="row">
        <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
            <div class="widget am-cf">
                <form id="my-form" class="am-form tpl-form-line-form" method="post">
                    <div class="widget-body">
                        <fieldset>
                            <div class="widget-head am-cf">
                                <div class="widget-title am-fl">网站设置</div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-form-label form-require"> 网站名称 </label>
                                <div class="am-u-sm-9">
                                    <input type="text" class="tpl-form-input" name="pc[name]"
                                           value="<?= $values['name'] ?? '' ?>" required>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-form-label form-require"> 网站英文名称 </label>
                                <div class="am-u-sm-9">
                                    <input type="text" class="tpl-form-input" name="pc[en_name]"
                                           value="<?= $values['en_name'] ?? '' ?>" required>
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
<script charset="utf-8" src="https://map.qq.com/api/js?v=2.exp&key=YVHBZ-LNORJ-N2WFY-FDDOG-YZQRK-XOFQ2"></script>
<script>
    $(function () {

        /**
         * 表单验证提交
         * @type {*}
         */
        $('#my-form').superForm();
        window.onload = function(){
            init();
        }
    });
</script>
