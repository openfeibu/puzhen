
<!-- 主体 -->
<div class="main">
    <div class="login-box  w1400">
        <div class="login-box-bg clearfix">
            <div class="login-left fl">
                <div class="login-code">
                    <div class="login-code-title"><?= lang('weixin_qrcode_reg') ?></div>
                    <div class="login-code-img" id="login_container">

                    </div>
                </div>
            </div>
            <div class="login-right fl">
                <div class="login-tab"><a href="<?= url('passport/login') ?>"><?= lang('login_abbr') ?></a></div>
                <div class="login-form">
                    <?php if($think_lang=='zh-cn'):?>
                    <div class="login-form-tab">
                        <div class="login-form-tab-item active">
                            <?= lang('phone_number_reg') ?>
                        </div>
                        <div class="login-form-tab-item">
                            <?= lang('email_reg') ?>
                        </div>

                    </div>
                    <?php else:?>
                    <div class="login-form-tab">
                        <div class="login-form-tab-item active">
                            <?= lang('email_reg') ?>
                        </div>
                    </div>
                    <?php endif;?>
                    <form action="" id="reg-form" class="reg-form-item" <?php if($think_lang=='zh-cn'): ?>style="display: block;"<?php endif;?>>
                        <div class="form-input">
                            <input name="phone_number" type="text" placeholder="<?= lang('phone_number_empty') ?>" />
                        </div>
                        <div class="form-input">
                            <input name="password" type="password" placeholder="<?= lang('password_notice') ?>" />
                            <div class="form-eye "></div>
                        </div>
                        <div class="form-input">
                            <input name="code" type="text" placeholder="<?= lang('verify_code_empty') ?>" />
                            <div class="getCode" attr-type="register_phone_number"><?= lang('send_verify_code') ?></div>
                        </div>
                        <div class="form-btn" >
                            <div class="form-des" style="margin-bottom: 10px;">
                                <input class="fb-inline-block" type="checkbox" name="check" />
                                <p class="fb-inline-block"><?= lang('I have read and accepted') ?> <a href="#">用户协议</a> 和 <a href="#">隐私政策</a> </p>
                            </div>
                            <button type="submit"><?= lang('register') ?></button>
                        </div>

                    </form>
                    <form action="" id="reg-form-email" class="reg-form-item" <?php if($think_lang=='en-us'): ?>style="display: block;"<?php endif;?>>
                        <div class="form-input">
                            <input name="email" type="text" placeholder="<?= lang('email_empty') ?>" />
                        </div>
                        <div class="form-input">
                            <input name="password" type="password" placeholder="<?= lang('password_notice') ?>" />
                            <div class="form-eye "></div>
                        </div>
                        <div class="form-input">
                            <input name="code" type="text" placeholder="<?= lang('verify_code_empty') ?>" />
                            <div class="getCode" attr-type="register_email"><?= lang('send_verify_code') ?></div>
                        </div>
                        <div class="form-btn" >
                            <div class="form-des" style="margin-bottom: 10px;">
                                <input class="fb-inline-block" type="checkbox" name="check" />
                                <p class="fb-inline-block"><?= lang('I have read and accepted') ?> <a href="<?= url('article/detail','article_id='.$userAgreement['article_id']);?>"><?= $userAgreement[$prefix.'article_title'] ?: $userAgreement['article_title'];?></a> <?= lang('and');?>  <a href="<?= url('article/detail','article_id='.$privacyPolicy['article_id']);?>"><?= $privacyPolicy[$prefix.'article_title'] ?: $privacyPolicy['article_title'];?></a> </p>
                            </div>
                            <button type="submit"><?= lang('register') ?></button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

</div>



<script>
    $(function() {
        $("#reg-form").validate({
            rules: {
                phone_number: {
                    required: true,
                    isMobile:true
                },
                password: {
                    required: true,
                    minlength: 6
                },
                code:{
                    required: true,
                },
                check:"required",

            },
            messages: {
                phone_number:{
                    required: "<?= lang('phone_number_empty'); ?>",
                    isMobile: "<?= lang('phone_number_error'); ?>"
                },

                password: {
                    required: "<?= lang('password_empty'); ?>",
                    minlength: "<?= lang('password_length'); ?>"
                },
                code: {
                    required: "<?= lang('verify_code_empty'); ?>"

                },
                check: {
                    required: function(){
                        fb_alert("请先同意 用户协议 和 隐私政策")
                    }

                },
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

        $("#reg-form-email").validate({
            rules: {
                email: {
                    required: true,
                    email:true
                },
                password: {
                    required: true,
                    minlength: 6
                },
                code:{
                    required: true,
                },
                check:"required"
            },
            messages: {
                email:{
                    required: "<?= lang('email_empty'); ?>",
                    email: "<?= lang('email_error'); ?>"
                },

                password: {
                    required: "<?= lang('password_empty'); ?>",
                    minlength: "<?= lang('password_length'); ?>"
                },
                code: {
                    required: "<?= lang('verify_code_empty'); ?>"

                },
                check: {
                    required: function(){
                        fb_alert("请先同意 用户协议 和 隐私政策")
                    }

                },
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
        $(".login-form-tab-item").on("click",function(){
            var i = $(this).index(".login-form-tab-item");
            $(this).addClass("active").siblings(".login-form-tab-item").removeClass("active");
            $(".reg-form-item").hide().eq(i).show()
        })
        /*
        //获取验证码
        $("#reg-form .getCode").on("click",function(){
            let that = this;
            if($(that).hasClass("active")){
                return false;
            }
            var phone_number = $("input[name='phone_number']").val();
            if(!phone_number)
            {
                layer.msg(lang_arr['phone_number_empty']);
                return false;
            }
            var load = layer.load(2);
            $.ajax({
                url : "<?= url('passport/send_register_sms')?>",
                data : {'phone_number': phone_number},
                type : 'post',
                success : function (data) {
                    layer.close(load);
                    if(data.code == 0)
                    {
                        layer.msg(data.msg);
                        return false;
                    }
                    $(that).addClass("active")
                    var i = 60;
                    $(that).text(i+"<?= lang('js_request_too_frequent') ?>");
                    var timer = setInterval(function(){
                        --i;
                        $(that).text(i+"<?= lang('js_request_too_frequent') ?>");
                        if(i <= 0){
                            clearInterval(timer);
                            $(that).removeClass("active").text("<?= lang('send_verify_code') ?>")
                        }
                    },1000)
                },
                error : function (jqXHR, textStatus, errorThrown) {
                    layer.close(load);
                    $.ajax_error(jqXHR, textStatus, errorThrown);
                }
            });



        })
        */
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