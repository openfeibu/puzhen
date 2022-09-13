<div class="row-content am-cf">
    <div class="row">
        <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
            <div class="widget am-cf">
                <form id="my-form" class="am-form tpl-form-line-form" method="post">
                    <div class="widget-body">
                        <fieldset>
                            <div class="widget-head am-cf">
                                <div class="widget-title am-fl">加盟申请详情</div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label"> 用户 </label>
                                <div class="am-u-sm-9 am-u-end am-padding-top-xs">
                                    <?= $model['user']['nickName'] ?>（ <?= $model['user_id'] ?>）
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label"> 企业名称 </label>
                                <div class="am-u-sm-9 am-u-end am-padding-top-xs">
                                    <?= $model['distributor_name'] ?>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label"> 联系人 </label>
                                <div class="am-u-sm-9 am-u-end am-padding-top-xs">
                                    <?= $model['linkman'] ?>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label"> 手机号码 </label>
                                <div class="am-u-sm-9 am-u-end am-padding-top-xs">
                                    <?= $model['phone'] ?>
                                </div>
                            </div>
                            
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label">企业照片 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <div class="am-form-file">
                                        <div class="uploader-list am-cf">
                                            <?php foreach ($model['image'] as $key => $item): ?>
                                                <div class="file-item">
                                                    <a href="<?= $item['file_path'] ?>" title="点击查看大图" target="_blank">
                                                        <img src="<?= $item['file_path'] ?>">
                                                    </a>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
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

        // 切换审核状态
        $("input:radio[name='user_equipment[status]']").change(function (e) {
            $('.form-tab-group')
                .removeClass('active')
                .filter('.item-agree-' + e.currentTarget.value)
                .addClass('active');
        });

        /**
         * 表单验证提交
         * @type {*}
         */
        $('.audit-form').superForm();

    });
</script>