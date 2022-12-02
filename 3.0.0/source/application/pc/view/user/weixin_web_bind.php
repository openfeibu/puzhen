<!-- 主体 -->
<div class="main">
    <div class="login-box  w1400">
        <div class="login-box-bg clearfix">
            <div class="login-left reg-left fl">
                <div class="login-code">
                    <?php if(null !== session('msg')): ?><p> <span><?= session('msg') ?></span></p><?php endif;?>
                    <div class="login-code-title"><?= lang('weixin_qrcode_bind') ?></div>
                    <div class="login-code-img" id="login_container">

                    </div>
                    <!-- <span>使用微信扫一扫 </br>使用泡臣小程序，泡茶更轻松</span> -->
                </div>
            </div>
        </div>
    </div>
</div>


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