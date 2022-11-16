
<!-- 主体 -->
<div class="main">
    <div class="login-box  w1400">
        <div class="login-box-bg clearfix">
            <div class="login-left fl">
                <div class="login-code">
                    <div class="login-code-title">微信扫码注册</div>
                    <div class="login-code-img"><img src="images/code.jpeg" alt=""></div>
                    <span>使用微信扫一扫 </br>使用泡臣小程序，泡茶更轻松</span>
                </div>
            </div>
            <div class="login-right fl">
                <div class="login-tab"><a href="login.html">登录</a></div>
                <div class="login-form">
                    <div class="login-form-tab">
                        <div class="login-form-tab-item active">
                            手机号注册
                        </div>
                        <div class="login-form-tab-item">
                            邮箱注册
                        </div>

                    </div>
                    <form action="" id="reg-form" class="reg-form-item" style="display: block;">
                        <div class="form-input">
                            <input name="phone_number" type="text" placeholder="请输入手机号" />
                        </div>
                        <div class="form-input">
                            <input name="password" type="password" placeholder="6-20位密码，包含字母、数字" />
                            <div class="form-eye "></div>
                        </div>
                        <div class="form-input">
                            <input name="code" type="text" placeholder="请输入验证码" />
                            <div class="getCode"><?= lang('send_verify_code') ?></div>
                        </div>
                        <div class="form-btn" >
                            <div class="form-des" style="margin-bottom: 10px;">
                                <input class="fb-inline-block" type="checkbox" name="check" />
                                <p class="fb-inline-block">我已阅读并接受 <a href="#">用户协议</a> 和 <a href="#">隐私政策</a> </p>
                            </div>
                            <button type="submit">注册</button>
                        </div>

                    </form>
                    <form action="" id="reg-form-email" class="reg-form-item">
                        <div class="form-input">
                            <input name="email" type="text" placeholder="请输入邮箱" />
                        </div>
                        <div class="form-input">
                            <input name="password" type="password" placeholder="6-20位密码，包含字母、数字" />
                            <div class="form-eye "></div>
                        </div>
                        <div class="form-input">
                            <input name="code" type="text" placeholder="请输入验证码" />
                            <div class="getCode"><?= lang('send_verify_code') ?></div>
                        </div>
                        <div class="form-btn" >
                            <div class="form-des" style="margin-bottom: 10px;">
                                <input class="fb-inline-block" type="checkbox" name="check" />
                                <p class="fb-inline-block">我已阅读并接受 <a href="#">用户协议</a> 和 <a href="#">隐私政策</a> </p>
                            </div>
                            <button type="submit">注册</button>
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
    });
</script>
