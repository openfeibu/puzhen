<div class="row-content am-cf">
    <div class="row">
        <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
            <div class="widget am-cf">
                <form id="my-form" class="am-form tpl-form-line-form" enctype="multipart/form-data" method="post">
                    <div class="widget-body">
                        <fieldset>
                            <div class="widget-head am-cf">
                                <div class="widget-title am-fl">邮件通知（网易邮箱）</div>
                            </div>
                            <input type="hidden" name="email[default]" value="NetEase">

                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-form-label form-require">
                                    账号
                                </label>
                                <div class="am-u-sm-9">
                                    <input type="text" class="tpl-form-input" name="email[engine][NetEase][username]"
                                           value="<?= $values['engine']['NetEase']['username'] ?>" required>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-form-label form-require">
                                    密码
                                </label>
                                <div class="am-u-sm-9">
                                    <input type="text" class="tpl-form-input" name="email[engine][NetEase][password]"
                                           value="<?= $values['engine']['NetEase']['password'] ?>" required>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-form-label form-require"> Host </label>
                                <div class="am-u-sm-9">
                                    <input type="text" class="tpl-form-input" name="email[engine][NetEase][host]"
                                           value="<?= $values['engine']['NetEase']['host'] ?>" required>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-form-label form-require"> 端口 </label>
                                <div class="am-u-sm-9">
                                    <input type="text" class="tpl-form-input" name="email[engine][NetEase][port]"
                                           value="<?= $values['engine']['NetEase']['port'] ?>" required>
                                </div>
                            </div>

                            <div class="widget-head am-cf">
                                <div class="widget-title am-fl">服务网点申请</div>
                            </div>

                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-form-label form-require">
                                    主题 <span class="tpl-form-line-small-title">Subject</span>
                                </label>
                                <div class="am-u-sm-9">
                                    <input type="text" class="tpl-form-input"
                                           name="email[template][distributor_apply][subject]"
                                           value="<?= $values['template']['distributor_apply']['subject'] ?>">
                                    <small>例如：服务网点申请</small>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-form-label form-require">
                                    内容 <span class="tpl-form-line-small-title">Body</span>
                                </label>
                                <div class="am-u-sm-9">
                                    <textarea class=""  name="email[template][distributor_apply][body]"><?= $values['template']['distributor_apply']['body'] ?></textarea>
                                    <small>例如：您有新的服务网点申请，请到系统上查看。</small>
                                </div>
                            </div>

                            <div class="widget-head am-cf">
                                <div class="widget-title am-fl">用户注册验证码</div>
                            </div>

                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-form-label form-require">
                                    主题 <span class="tpl-form-line-small-title">Subject</span>
                                </label>
                                <div class="am-u-sm-9">
                                    <input type="text" class="tpl-form-input"
                                           name="email[template][user_register][subject]"
                                           value="<?= $values['template']['user_register']['subject'] ?>">
                                    <small>例如：感谢您的注册，请查收您的注册验证码！</small>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-form-label form-require">
                                    内容 <span class="tpl-form-line-small-title">Body</span>
                                </label>
                                <div class="am-u-sm-9">
                                    <textarea class=""  name="email[template][user_register][body]"><?= $values['template']['user_register']['body'] ?></textarea>
                                    <small>例如：验证码${code}，您正在注册成为${product}用户，感谢您的支持！</small>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-form-label form-require">
                                    主题英文 <span class="tpl-form-line-small-title">Subject</span>
                                </label>
                                <div class="am-u-sm-9">
                                    <input type="text" class="tpl-form-input"
                                           name="email[template][user_register][en_subject]"
                                           value="<?= $values['template']['user_register']['en_subject'] ?? '' ?>">
                                    <small>例如：Thank you for your registration, please check your registration verification code!</small>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-form-label form-require">
                                    内容英文 <span class="tpl-form-line-small-title">Body</span>
                                </label>
                                <div class="am-u-sm-9">
                                    <textarea class=""  name="email[template][user_register][en_body]"><?= $values['template']['user_register']['en_body'] ?? '' ?></textarea>
                                    <small>例如：The code is ${code}. Thank you for your support!</small>
                                </div>
                            </div>
                            <div class="widget-head am-cf">
                                <div class="widget-title am-fl">用户忘记密码验证码</div>
                            </div>

                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-form-label form-require">
                                    主题 <span class="tpl-form-line-small-title">Subject</span>
                                </label>
                                <div class="am-u-sm-9">
                                    <input type="text" class="tpl-form-input"
                                           name="email[template][user_forget_pass][subject]"
                                           value="<?= $values['template']['user_forget_pass']['subject'] ?? '' ?>">
                                    <small>例如：重置密码！</small>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-form-label form-require">
                                    内容 <span class="tpl-form-line-small-title">Body</span>
                                </label>
                                <div class="am-u-sm-9">
                                    <textarea class=""  name="email[template][user_forget_pass][body]"><?= $values['template']['user_forget_pass']['body'] ?? ''?></textarea>
                                    <small>例如：验证码${code}，您正在尝试修改${product}登录密码，请妥善保管账户信息。</small>
                                </div>
                            </div>

                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-form-label form-require">
                                    主题英文 <span class="tpl-form-line-small-title">Subject</span>
                                </label>
                                <div class="am-u-sm-9">
                                    <input type="text" class="tpl-form-input"
                                           name="email[template][user_forget_pass][en_subject]"
                                           value="<?= $values['template']['user_forget_pass']['en_subject'] ?? '' ?>">
                                    <small>例如：Reset the password!</small>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-form-label form-require">
                                    内容英文 <span class="tpl-form-line-small-title">Body</span>
                                </label>
                                <div class="am-u-sm-9">
                                    <textarea class=""  name="email[template][user_forget_pass][en_body]"><?= $values['template']['user_forget_pass']['en_body'] ?? ''?></textarea>
                                    <small>例如：The code is ${code}, you are trying to change the login password, please keep the account information properly.</small>
                                </div>
                            </div>


                            <div class="widget-head am-cf">
                                <div class="widget-title am-fl">用户绑定邮箱验证码</div>
                            </div>

                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-form-label form-require">
                                    主题 <span class="tpl-form-line-small-title">Subject</span>
                                </label>
                                <div class="am-u-sm-9">
                                    <input type="text" class="tpl-form-input"
                                           name="email[template][user_bind_email][subject]"
                                           value="<?= $values['template']['user_bind_email']['subject'] ?? '' ?>">
                                    <small>例如：绑定邮箱！</small>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-form-label form-require">
                                    内容 <span class="tpl-form-line-small-title">Body</span>
                                </label>
                                <div class="am-u-sm-9">
                                    <textarea class=""  name="email[template][user_bind_email][body]"><?= $values['template']['user_bind_email']['body'] ?? ''?></textarea>
                                    <small>例如：验证码${code}，您正在进行${product}身份验证，打死不要告诉别人哦！</small>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-form-label form-require">
                                    主题英文 <span class="tpl-form-line-small-title">Subject</span>
                                </label>
                                <div class="am-u-sm-9">
                                    <input type="text" class="tpl-form-input"
                                           name="email[template][user_bind_email][en_subject]"
                                           value="<?= $values['template']['user_bind_email']['en_subject'] ?? '' ?>">
                                    <small>例如：Binding email!</small>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-form-label form-require">
                                    内容英文 <span class="tpl-form-line-small-title">Body</span>
                                </label>
                                <div class="am-u-sm-9">
                                    <textarea class=""  name="email[template][user_bind_email][en_body]"><?= $values['template']['user_bind_email']['en_body'] ?? ''?></textarea>
                                    <small>例如：The code is ${code}, please keep the account information properly.</small>
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

        /**
         * 发送测试短信
         */
        $('.j-sendTestMsg').click(function () {
            var msgType = $(this).data('msg-type')
                , formData = {
                AccessKeyId: $('input[name="email[engine][aliyun][AccessKeyId]"]').val()
                , AccessKeySecret: $('input[name="email[engine][aliyun][AccessKeySecret]"]').val()
                , sign: $('input[name="email[engine][aliyun][sign]"]').val()
                , msg_type: msgType
                , template_code: $('input[name="email[engine][aliyun][' + msgType + '][template_code]"]').val()
                , accept_phone: $('input[name="email[engine][aliyun][' + msgType + '][accept_phone]"]').val()
            };
            if (!formData.AccessKeyId.length) {
                layer.msg('请填写 AccessKeyId');
                return false;
            }
            if (!formData.AccessKeySecret.length) {
                layer.msg('请填写 AccessKeySecret');
                return false;
            }
            if (!formData.sign.length) {
                layer.msg('请填写 短信签名');
                return false;
            }
            if (!formData.template_code.length) {
                layer.msg('请填写 模板ID');
                return false;
            }
            if (!formData.accept_phone.length) {
                layer.msg('请填写 接收手机号');
                return false;
            }
            layer.confirm('确定要发送测试短信吗', function (index) {
                var load = layer.load();
                var url = "<?= url('setting/emailTest') ?>";
                $.post(url, formData, function (result) {
                    layer.msg(result.msg);
                    layer.close(load);
                });
                layer.close(index);
            });
        });

    });
</script>
