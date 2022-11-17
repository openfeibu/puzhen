<!-- 主体 -->
<div class="main">
    <div class="login-box  w1400">
        <div class="login-box-bg clearfix">
            <div class="login-left fl">
                <div class="login-code">
                    <div class="login-code-title"><?= lang('weixin_qrcode_bind') ?></div>
                    <div class="login-code-img" id="login_container">

                    </div>
                    <!-- <span>使用微信扫一扫 </br>使用泡臣小程序，泡茶更轻松</span> -->
                </div>
            </div>
            <div class="login-right fl">
                <div class="binding-box">
                    <div>
                        <div class="binding-test">
                            <?php if(null !== session('msg')): ?><p> <span><?= session('msg') ?></span></p><?php endif;?>
                            <span><?= $pc['user']['phone_number'] ?: $pc['user']['email']?></span><?= lang('register_weixin_web_bind_notice') ?>
                        </div>
                        <div class="binding-btn" >
                            <a href="<?= url('user/index') ?>"><?= lang('skip') ?></a>
                        </div>
                    </div>
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
        href:"data:text/css;base64,LmltcG93ZXJCb3ggLnFyY29kZSB7d2lkdGg6IDIwMHB4O30NCi5pbXBvd2VyQm94IC50aXRsZSB7ZGlzcGxheTogbm9uZTt9DQouaW1wb3dlckJveCAuaW5mbyB7d2lkdGg6IDIwMHB4O30NCi5zdGF0dXNfaWNvbiB7ZGlzcGxheTogbm9uZX0NCi5pbXBvd2VyQm94IC5zdGF0dXMge3RleHQtYWxpZ246IGNlbnRlcjt9"//自定义样式链接
    });
</script>