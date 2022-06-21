<div class="row-content am-cf">
    <div class="row">
        <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
            <div class="widget am-cf">
                <form id="my-form" class="am-form tpl-form-line-form" method="post">
                    <div class="widget-body">
                        <fieldset>
                            <div class="widget-head am-cf">
                                <div class="widget-title am-fl">冲泡码评价详情</div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label">用户 </label>
                                <div class="am-u-sm-9 am-u-end am-padding-top-xs">
                                    <small class="am-text-sm"><?= $model['user']['nickName'] ?></small>
                                    <small class="">(用户id：<?= $model['user']['user_id'] ?>)</small>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label">产品 </label>
                                <div class="am-u-sm-9 am-u-end am-padding-top-xs">
                                    <?php if (isset($model['goods']['image'][0]['file_path'])) : ?>
                                    <a href="<?= $model['goods']['image'][0]['file_path'] ?>"
                                       title="点击查看大图" target="_blank">
                                        <img src="<?= $model['goods']['image'][0]['file_path'] ?>" alt="产品图片"
                                             width="80" height="80">
                                    </a>
                                    <?php endif; ?>
                                    <small class="">(产品id：<?= $model['goods_id'] ?>)</small>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label">冲泡码 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <a href="<?= $model['tea_qrcode']['detail_image_url'] ?>"
                                       title="点击查看大图" target="_blank">
                                        <img src="<?= $model['tea_qrcode']['detail_image_url'] ?>" alt="冲泡码"
                                             width="80" height="80">
                                    </a>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label">冲泡码名称 </label>
                                <div class="am-u-sm-9 am-u-end am-padding-top-xs">
                                    <small class="am-text-sm"><?= $model['tea_qrcode']['name'] ?></small>
                                </div>
                            </div>

                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">评价内容 </label>
                                <div class="am-u-sm-9 am-u-end am-padding-top-xs">
                                    <textarea class="am-field-valid" rows="5" placeholder="请输入评价内容"
                                              name="comment[content]" required><?= $model['content'] ?></textarea>
                                </div>
                            </div>

                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">评价排序 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <input type="number" min="0" class="tpl-form-input" name="comment[sort]"
                                           value="<?= $model['sort'] ?>" required>
                                    <small>数字越小越靠前</small>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">显示状态 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <label class="am-radio-inline">
                                        <input type="radio" name="comment[status]" value="1" data-am-ucheck
                                            <?= $model['status'] == 1 ? 'checked' : '' ?> >
                                        显示
                                    </label>
                                    <label class="am-radio-inline">
                                        <input type="radio" name="comment[status]" value="0" data-am-ucheck
                                            <?= $model['status'] == 0 ? 'checked' : '' ?> >
                                        隐藏
                                    </label>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label">评论时间 </label>
                                <div class="am-u-sm-9 am-u-end am-padding-top-xs">
                                    <small class="am-text-sm"><?= $model['create_time'] ?></small>
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
