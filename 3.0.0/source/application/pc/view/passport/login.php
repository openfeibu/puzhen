<div class="main">
    <div class="login-box  w1400">
        <div class="login-box-bg clearfix">
            <div class="login-left fl">
                <div class="login-code">
                    <div class="login-code-title">微信扫码登录</div>
                    <div class="login-code-img"><img src="images/code.jpeg" alt=""></div>
                    <span>使用微信扫一扫 </br>使用泡臣小程序，泡茶更轻松</span>
                </div>
            </div>
            <div class="login-right fl">
                <div class="login-tab"><a href="<?= url('passport/register')?>"><?= lang('register')?></a></div>
                <div class="login-form">
                    <div class="login-form-title">
                        用户登录
                    </div>
                    <form action="" id="login-form">
                        <div class="form-input">
                            <input name="account" type="text" placeholder="请输入手机号/邮箱" />
                        </div>
                        <div class="form-input">
                            <input name="password" type="password" placeholder="8-20位密码，包含字母、数字" />
                            <div class="form-eye "></div>
                        </div>
                        <div class="form-btn">
                            <button type="submit">登录</button>
                        </div>
                        <div class="form-des">
                            <a class="fr forgotpassword" href="forgotpassword.html">忘记密码</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="assets/common/js/jquery.form.min.js"></script>
<script src="assets/common/plugins/layer/layer.js"></script>
<script>
    $(function() {
        $("#login-form").validate({
            rules: {
                account: "required",
                password: {
                    required: true,
                    minlength: 6
                },
                // confirm_password: {
                //     required: true,
                //     minlength: 5,
                //     equalTo: "#password"
                // },
            },
            messages: {
                account: "<?= lang('account_empty'); ?>",

                password: {
                    required: "<?= lang('password_empty'); ?>",
                    minlength: "<?= lang('password_length'); ?>"
                },
                // confirm_password: {
                //     required: "请输入密码",
                //     minlength: "密码长度不能小于 5 个字符",
                //     equalTo: "两次密码输入不一致"
                // },

            },submitHandler: function(form) {
                $(form).ajaxSubmit({
                    type: 'post', // 提交方式 get/post
                    success: function(data) { // data 保存提交后返回的数据，一般为 json 数据
                        if (data.code === 1) {
                            layer.msg(data.msg, {time: 1500, anim: 1}, function () {
                                window.location = data.url;
                            });
                            return true;
                        }
                        layer.msg(data.msg, {time: 1500, anim: 6});
                    }
                });
                return false;
            }
        })
    });

</script>
</html>