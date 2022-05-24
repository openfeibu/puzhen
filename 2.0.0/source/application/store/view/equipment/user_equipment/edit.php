<div class="row-content am-cf">
    <div class="row">
        <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
            <div class="widget am-cf">
                <form id="my-form" class="am-form tpl-form-line-form" method="post">
                    <div class="widget-body">
                        <fieldset>
                            <div class="widget-head am-cf">
                                <div class="widget-title am-fl">用户茶电器详情</div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label"> 用户 </label>
                                <div class="am-u-sm-9 am-u-end am-padding-top-xs">
                                    <?= $model['user']['nickName'] ?>（ <?= $model['user_id'] ?>）
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label"> 茶电器 </label>
                                <div class="am-u-sm-9 am-u-end am-padding-top-xs">
                                    <?= $model['equipment']['equipment_name'] ?> <?= $model['equipment']['model'] ?>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label"> 茶电器图片 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <div class="am-form-file">
                                        <div class="am-form-file">
                                            <div class="uploader-list am-cf">
                                                <div class="file-item">
                                                    <a href="<?= $model['equipment']['image']['file_path'] ?>"
                                                       title="点击查看大图" target="_blank">
                                                        <img src="<?= $model['equipment']['image']['file_path'] ?>">
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label"> 联系人 </label>
                                <div class="am-u-sm-9 am-u-end am-padding-top-xs">
                                    <?= $model['linkname'] ?>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label"> 手机号码 </label>
                                <div class="am-u-sm-9 am-u-end am-padding-top-xs">
                                    <?= $model['phone'] ?>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label"> 购买日期 </label>
                                <div class="am-u-sm-9 am-u-end am-padding-top-xs">
                                    <?= $model['buy_date'] ?>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label"> 序列号 </label>
                                <div class="am-u-sm-9 am-u-end am-padding-top-xs">
                                    <?= $model['equipment_sn'] ?>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label">凭证 </label>
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
                            <?php if ($model['status']['value'] == 20): ?>
                                <div class="am-form-group">
                                    <label class="am-u-sm-3 am-u-lg-2 am-form-label"> 保修日期 </label>
                                    <div class="am-u-sm-9 am-u-end am-padding-top-xs">
                                        <?= $model['setting_warranty_days'] ?>天
                                    </div>
                                </div>
                                <div class="am-form-group">
                                    <label class="am-u-sm-3 am-u-lg-2 am-form-label"> 基础包换日期 </label>
                                    <div class="am-u-sm-9 am-u-end am-padding-top-xs">
                                        <?= $model['setting_basic_change_days'] ?>天
                                    </div>
                                </div>
                                <div class="am-form-group">
                                    <label class="am-u-sm-3 am-u-lg-2 am-form-label"> 赠送包换日期 </label>
                                    <div class="am-u-sm-9 am-u-end am-padding-top-xs">
                                        <?= $model['setting_change_days'] ?>天
                                    </div>
                                </div>

                                <div class="am-form-group">
                                    <label class="am-u-sm-3 am-u-lg-2 am-form-label"> 只换不修剩余时间 </label>
                                    <div class="am-u-sm-9 am-u-end am-padding-top-xs">
                                        <?= $model['change_days_text'] ?>天
                                    </div>
                                </div>
                                <div class="am-form-group">
                                    <label class="am-u-sm-3 am-u-lg-2 am-form-label"> 保修剩余时间 </label>
                                    <div class="am-u-sm-9 am-u-end am-padding-top-xs">
                                        <?= $model['warranty_days_text'] ?>天
                                    </div>
                                </div>
                            <?php elseif ($model['status']['value'] == 30): ?>
                                <div class="am-form-group">
                                    <label class="am-u-sm-3 am-u-lg-2 am-form-label"> 驳回原因 </label>
                                    <div class="am-u-sm-9 am-u-end am-padding-top-xs">
                                        <?= $model['reject_reason'] ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                        </fieldset>


                    </div>
                </form>
                <!-- 商家审核 -->
                <?php if (checkPrivilege('equipment.user_equipment/audit')): ?>
                    <?php if ($model['status']['value'] == 10): ?>
                        <div class="widget-head am-cf" id="check">
                            <div class="widget-title am-fl">商家审核</div>
                        </div>
                        <!-- 去审核 -->
                        <form id="audit" class="audit-form am-form tpl-form-line-form" method="post"
                              action="<?= url('equipment.user_equipment/audit', ['user_equipment_id' => $model['user_equipment_id']]) ?>">
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">审核状态 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <label class="am-radio-inline">
                                        <input type="radio" name="user_equipment[status]"
                                               value="20"
                                               data-am-ucheck
                                               checked
                                               required>
                                        同意
                                    </label>
                                    <label class="am-radio-inline">
                                        <input type="radio" name="user_equipment[status]"
                                               value="30"
                                               data-am-ucheck>
                                        拒绝
                                    </label>
                                </div>
                            </div>
                            <div class="item-agree-20 form-tab-group  active">
                                <div class="am-form-group">
                                    <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">保修日期 </label>
                                    <div class="am-u-sm-9 am-u-end">
                                        <div class="am-u-sm-6">
                                            <input type="number" class="tpl-form-input" name="user_equipment[setting_warranty_days]" value="<?= $warranty_setting['warranty_days'] ?>" required>
                                        </div>
                                        <label class="am-u-sm-6 am-form-label am-text-left">天</label>
                                    </div>
                                </div>
                                <div class="am-form-group">
                                    <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">基础包换日期 </label>
                                    <div class="am-u-sm-9 am-u-end">
                                        <div class="am-u-sm-6">
                                            <input type="number" class="tpl-form-input" name="user_equipment[setting_basic_change_days]" value="<?= $warranty_setting['basic_change_days'] ?>" required>
                                        </div>
                                        <label class="am-u-sm-6 am-form-label am-text-left">天</label>
                                    </div>
                                </div>
                                <div class="am-form-group">
                                    <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">赠送包换日期 </label>
                                    <div class="am-u-sm-9 am-u-end">
                                        <div class="am-u-sm-6">
                                            <input type="number" class="tpl-form-input" name="user_equipment[setting_change_days]" value="<?= $warranty_setting['change_days'] ?>" required>
                                        </div>
                                        <label class="am-u-sm-6 am-form-label am-text-left">天</label>
                                    </div>
                                </div>
                            </div>
                            <div class="item-agree-30 form-tab-group am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">拒绝原因 </label>
                                <div class="am-u-sm-9 am-u-end">
                                            <textarea class="am-field-valid" rows="4" placeholder="请输入拒绝原因"
                                                      name="user_equipment[reject_reason]"></textarea>
                                    <small>如审核状态为拒绝，则需要输入拒绝原因</small>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <div class="am-u-sm-10 am-u-sm-push-2 am-margin-top-lg">
                                    <button type="submit" class="j-submit am-btn am-btn-sm am-btn-secondary">
                                        确认审核
                                    </button>
                                </div>
                            </div>
                        </form>
                    <?php endif; ?>
                <?php endif; ?>
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