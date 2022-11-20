<div class="main">
    <div class="login-box  w1400">
        <div class="login-box-bg clearfix">
            <div class="login-left fl">
                <div class="login-code">
                    <div class="login-code-title"><?= lang('weixin_qrcode_login') ?></div>
                    <div class="login-code-img" id="login_container">

                    </div>
<!--                    <span>使用微信扫一扫 </br>使用泡臣小程序，泡茶更轻松</span>-->
                </div>
            </div>
            <div class="login-right fl">
                <div class="login-tab"><a href="<?= url('passport/register')?>"><?= lang('register_abbr')?></a></div>
                <div class="login-form">
                    <div class="login-form-title">
                        <?= lang('user_login') ?>
                    </div>
                    <form action="" id="login-form">
                        <div class="form-input">
                            <input name="account" type="text" placeholder="<?= lang('account_notice')?>" />
                        </div>
                        <div class="form-input">
                            <input name="password" type="password" placeholder="<?= lang('password_notice') ?>" />
                            <div class="form-eye "></div>
                        </div>
                        <div class="form-btn">
                            <button type="submit"><?= lang('login')?></button>
                        </div>
                        <div class="form-des">
                            <a class="fr forgotpassword" href="<?= url('passport/forget_pass')?>"><?= lang('forget_pass')?></a>
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
<script type="text/javascript" src="http://res.wx.qq.com/connect/zh_CN/htmledition/js/wxLogin.js"></script>
<script type="text/javascript">
    var obj = new WxLogin({
        self_redirect:false,
        id:"login_container", //第三方页面显示二维码的容器id
        appid: "wx8ce4381ddbb54393",
        scope: "snsapi_login", //应用授权作用域
        redirect_uri: encodeURIComponent("<?= $weixinLoginRedirectUrl; ?>"),//回调地址
        state: "<?= $state; ?>",
        style: "black",
        href:"data:text/css;base64,LmltcG93ZXJCb3ggLnFyY29kZSB7d2lkdGg6IDIwMHB4O30KLmltcG93ZXJCb3ggLnRpdGxlIHtkaXNwbGF5OiBub25lO30KLmltcG93ZXJCb3ggLmluZm8ge3dpZHRoOiAyMDBweDt9Ci5zdGF0dXNfaWNvbiB7ZGlzcGxheTogbm9uZX0KLmltcG93ZXJCb3ggLnN0YXR1cyB7dGV4dC1hbGlnbjogY2VudGVyO2NvbG9yOiNmZmZ9IA=="//自定义样式链接
    });
</script>