<!-- 主体 -->
<div class="main">
    <div class="login-box  w1400">
        <div class="login-box-bg clearfix">
            <div class="login-left fl">
                <!-- <div class="login-code">
                    <div class="login-code-title">微信扫码注册</div>
                    <div class="login-code-img"><img src="images/code.jpeg" alt=""></div>
                    <span>使用微信扫一扫 </br>使用泡臣小程序，泡茶更轻松</span>
                </div> -->
            </div>
            <div class="login-right fl">
                <div class="login-tab"><a href="<?= url('passport/login') ?>"><?= lang('login') ?></a></div>
                <div class="login-form">
                    <div class="login-form-tab">
                        <div class="login-form-tab-item active">
                            手机号找回
                        </div>
                        <div class="login-form-tab-item">
                            邮箱找回
                        </div>

                    </div>
                    <form action="" id="reg-form" class="reg-form-item" style="display: block;">
                        <div class="form-input">
                            <input name="phone_number" type="text" placeholder="<?= lang('phone_number_empty') ?>" />
                        </div>
                        <div class="form-input">
                            <input name="password" type="password" placeholder="<?= lang('password_notice') ?>" />
                            <div class="form-eye "></div>
                        </div>
                        <div class="form-input">
                            <input name="code" type="text" placeholder="<?= lang('verify_code_empty') ?>" />
                            <div class="getCode" attr-type="forget_pass_phone_number"><?= lang('send_verify_code') ?></div>
                        </div>
                        <div class="form-btn" >

                            <button type="submit"><?= lang('confirm') ?></button>
                        </div>



                    </form>
                    <form action="" id="reg-form-email" class="reg-form-item">
                        <div class="form-input">
                            <input name="email" type="text" placeholder="<?= lang('email_empty') ?>" />
                        </div>
                        <div class="form-input">
                            <input name="password" type="password" placeholder="<?= lang('password_notice') ?>" />
                            <div class="form-eye "></div>
                        </div>
                        <div class="form-input">
                            <input name="code" type="text" placeholder="<?= lang('verify_code_empty') ?>" />
                            <div class="getCode" attr-type="forget_pass_email"><?= lang('send_verify_code') ?></div>
                        </div>
                        <div class="form-btn" >

                            <button type="submit"><?= lang('confirm') ?></button>
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
                phone: {
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
                check:"required"
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

    });
</script>
