<!-- 轮播图 -->
<div class="min-banner">
    <img src="assets/pc/images/banner2.png" alt="">
</div>
<!-- 主体 -->
<div class="main">
    {{include file="user/header" /}}
    <!-- 列表 -->
    <div class="product-list w1400 container">
        <div class="product-list-tab w1400 container">
            <ul class="clearfix">
                <li class="active"><?= lang('setting') ?></li>
            </ul>

        </div>
        <div class="set-list w1400 clearfix">
            <div class="set-list-item clearfix">
                <div class="set-label fl"><?= lang('username') ?><?= lang(':') ?></div>
                <div class="set-con fl"><?= $user['nickName'] ?></div>
                <div class="set-btn fr" onclick="$('.update-box-nickname').fadeIn(200)"><?= lang('edit') ?></div>
            </div>
            <div class="set-list-item clearfix">
                <div class="set-label fl"><?= lang('bind_phone_number') ?><?= lang(':') ?></div>
                <?php if($user['phone_number']): ?>
                <div class="set-con fl"><?= hide_star($user['phone_number']) ?></div>
                <?php else: ?>
                <div class="set-con fl"><?= lang('empty_phone_number_bind_notice')  ?></div>
                <div class="set-btn fr" onclick="$('.update-box-phone').fadeIn(200)"><?= lang('bind') ?></div>
                <?php endif;?>
            </div>
            <div class="set-list-item clearfix">
                <div class="set-label fl"><?= lang('bind_email') ?><?= lang(':') ?></div>
                <?php if($user['email']): ?>
                <div class="set-con fl"><?= hide_star($user['email']) ?></div>
                <?php else: ?>
                <div class="set-con fl"><?= lang('empty_email_bind_notice') ?></div>
                <div class="set-btn fr" onclick="$('.update-box-email').fadeIn(200)"><?= lang('bind') ?></div>
                <?php endif;?>

            </div>
            <div class="set-list-item clearfix">
                <div class="set-label fl"><?= lang('password') ?><?= lang(':') ?></div>
                <?php if($user['password']): ?>
                <div class="set-con fl">*************</div>
                <div class="set-btn fr" onclick="$('.update-box-password2').fadeIn(200)"><?= lang('edit') ?></div>
                <?php else: ?>
                <div class="set-con fl"><?= lang('password_unset') ?></div>
                <div class="set-btn fr" onclick="$('.update-box-password').fadeIn(200)"><?= lang('setting') ?></div>
                <?php endif;?>
            </div>

        </div>
        <div class="loginout-btn" onclick="window.location.href='<?= url('passport/logout') ?>'"><?= lang('logout') ?></div>

    </div>
</div>

<!-- 修改用户名 -->
<div class="update-box update-box-nickname">
    <div class="update-box-b">
        <div class="update-box-title">修改用户名</div>
        <div class="update-box-form">
            <form action="#" onsubmit="return changeName()" id="update-nickname-form">
                <input type="hidden" name="type" value="info">
                <div class="update-box-form-input">
                    <input name="nickName" type="text" placeholder="" value="<?= $user['nickName'] ?>"/>
                </div>
                <div class="update-box-form-btn">
                    <div class="update-box-form-submit fb-inline-block">
                        <button type="submit"><?= lang('edit') ?></button>
                    </div>
                    <div class="update-box-form-close fb-inline-block">
                        <?= lang('cancel') ?>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- 绑定手机号 -->
<div class="update-box update-box-phone">
    <div class="update-box-b">
        <div class="update-box-title"><?= lang('bind_phone_number') ?></div>
        <div class="update-box-form">
            <form action="#" onsubmit="return changePhone()" id="change-phone-form">
                <input type="hidden" name="type" value="bind_phone_number">
                <div class="update-box-form-input">
                    <input name="phone_number" type="text" placeholder="<?= lang('phone_number_empty') ?>" />
                </div>
                <div class="update-box-form-input">
                    <input name="code" type="text" placeholder="<?= lang('verify_code_empty') ?>" />
                    <div class="getCode" attr-type="bind_phone_number"><?= lang('send_verify_code') ?></div>
                </div>
                <div class="update-box-form-btn">
                    <div class="update-box-form-submit fb-inline-block">
                        <button type="submit"><?= lang('edit') ?></button>
                    </div>
                    <div class="update-box-form-close fb-inline-block">
                        <?= lang('cancel') ?>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- 绑定邮箱 -->
<div class="update-box update-box-email">
    <div class="update-box-b">
        <div class="update-box-title"><?= lang('bind_email') ?></div>
        <div class="update-box-form">
            <form action="#" onsubmit="return changeEmail()" id="change-email-form">
                <input type="hidden" name="type" value="bind_email">
                <div class="update-box-form-input">
                    <input name="email" type="text" placeholder="<?= lang('email_empty') ?>" />
                </div>
                <div class="update-box-form-input">
                    <input name="code" type="text" placeholder="<?= lang('verify_code_empty') ?>" />
                    <div class="getCode" attr-type="bind_email"><?= lang('send_verify_code') ?></div>
                </div>
                <div class="update-box-form-btn">
                    <div class="update-box-form-submit fb-inline-block">
                        <button type="submit"><?= lang('confirm') ?></button>
                    </div>
                    <div class="update-box-form-close fb-inline-block">
                        <?= lang('cancel') ?>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- 设置密码 -->
<div class="update-box update-box-password">
    <div class="update-box-b">
        <div class="update-box-title"><?= lang('setting_password') ?></div>
        <div class="update-box-form">
            <form action="#" onsubmit="return changePassword()" id="set-password-form">
                <input type="hidden" name="type" value="set_password">
                <div class="update-box-form-input">
                    <input  name="password" type="password" placeholder="<?= lang('new_password_empty') ?>" />
                </div>
                <div class="update-box-form-input">
                    <input name="password_confirm" type="password" placeholder="<?= lang('confirm_new_password') ?>" />
                </div>
                <div class="update-box-form-btn">
                    <div class="update-box-form-submit fb-inline-block">
                        <button type="submit"><?= lang('confirm') ?></button>
                    </div>
                    <div class="update-box-form-close fb-inline-block">
                        <?= lang('cancel') ?>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- 修改密码 -->
<div class="update-box update-box-password2">
    <div class="update-box-b">
        <div class="update-box-title"><?= lang('change_password') ?></div>
        <div class="update-box-form">
            <form action="#" onsubmit="return changePassword2()"  id="change-password-form">
                <input type="hidden" name="type" value="change_password">
                <div class="update-box-form-input">
                    <input  name="old_password" type="password" placeholder="<?= lang('old_password_empty') ?>" />
                </div>
                <div class="update-box-form-input">
                    <input  name="password" type="password" placeholder="<?= lang('new_password_empty') ?>" />
                </div>
                <div class="update-box-form-input">
                    <input name="password_confirm" type="password" placeholder="<?= lang('confirm_new_password') ?>" />
                </div>
                <div class="update-box-form-btn">
                    <div class="update-box-form-submit fb-inline-block">
                        <button type="submit"><?= lang('edit') ?></button>
                    </div>
                    <div class="update-box-form-close fb-inline-block">
                        <?= lang('cancel') ?>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
    let url = "<?= url('user/renew')?>";
    function changeName(){
        let name = $("input[name='nickName']").val();
        console.log(name)
        if(name.length <= 0){
            layer.msg("<?= lang('nickname_empty') ?>");
            return false;
        }
        let load = layer.load(2);
        $("#update-nickname-form").ajaxSubmit({
            url: url,
            type: 'post',
            success: function(data) { // data 保存提交后返回的数据，一般为 json 数据
                layer.close(load);
                if (data.code === 1) {
                    layer.msg(data.msg, {time: 1500, anim: 1}, function () {
                        window.location.reload();
                    });
                    return true;
                }
                layer.msg(data.msg);
            }
        });
        return false;
    }
    function changePhone(){
        let phone_number = $("input[name='phone_number']").val();
        let code =  $("#change-phone-form").find("input[name='code']").val();
        if(!/^1[3-9]\d{9}$/.test(phone_number)){
            layer.msg("<?= lang('phone_number_error') ?>");
            return false;
        }
        if(code.length == 0){
            layer.msg("<?= lang('verify_code_empty') ?>")
            return false;
        }
        let load = layer.load(2);
        $("#change-phone-form").ajaxSubmit({
            url: url,
            type: 'post',
            success: function(data) { // data 保存提交后返回的数据，一般为 json 数据
                layer.close(load);
                if (data.code === 1) {
                    layer.msg(data.msg, {time: 1500, anim: 1}, function () {
                        window.location.reload();
                    });
                    return true;
                }
                layer.msg(data.msg);
                return false;
            }
        });
        return false;
    }
    function changeEmail(){
        let email =  $("#change-email-form").find("input[name='email']").val();
        let code = $("#change-email-form").find("input[name='code']").val();

        if(!/^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+/.test(email)){
            layer.msg("<?= lang('email_error') ?>")
            return false;
        }
        if(code.length == 0){
            layer.msg("<?= lang('verify_code_empty') ?>")
            return false;
        }
        let load = layer.load(2);
        $("#change-email-form").ajaxSubmit({
            url: url,
            type: 'post',
            success: function(data) { // data 保存提交后返回的数据，一般为 json 数据
                layer.close(load);
                if (data.code === 1) {
                    layer.msg(data.msg, {time: 1500, anim: 1}, function () {
                        window.location.reload();
                    });
                    return true;
                }
                layer.msg(data.msg);
                return false;
            }
        });
        return false;

    }
    function changePassword(){
        let password =  $("#set-password-form").find("input[name='password']").val();
        let password_confirm = $("#set-password-form").find("input[name='password_confirm']").val();

        if(password.length < 6 || password_confirm.length < 6){
            layer.msg("<?= lang('password_length') ?>")
            return false;

        }
        if(password != password_confirm){
            layer.msg("<?= lang('password_confirm_error') ?>")
            return false;

        }
        let load = layer.load(2);
        $("#set-password-form").ajaxSubmit({
            url: url,
            type: 'post',
            success: function(data) { // data 保存提交后返回的数据，一般为 json 数据
                layer.close(load);
                if (data.code === 1) {
                    layer.msg(data.msg, {time: 1500, anim: 1}, function () {
                        window.location.reload();
                    });
                    return true;
                }
                layer.msg(data.msg);
                return false;
            }
        });
        return false;
    }
    function changePassword2(){
        let old_password = $("#change-password-form").find("input[name='old_password']").val();
        let password = $("#change-password-form").find("input[name='password']").val();
        let password_confirm = $("#change-password-form").find("input[name='password_confirm']").val();
        if(old_password.length < 6 ){
            layer.msg("<?= lang('old_password_length') ?>")
            return false;

        }
        if(password.length < 6 || password_confirm.length < 6){
            layer.msg("<?= lang('password_length') ?>")
            return false;

        }
        if(password != password_confirm){
            layer.msg("<?= lang('password_confirm_error') ?>")
            return false;

        }
        let load = layer.load(2);
        $("#change-password-form").ajaxSubmit({
            url: url,
            type: 'post',
            success: function(data) { // data 保存提交后返回的数据，一般为 json 数据
                layer.close(load);
                if (data.code === 1) {
                    layer.msg(data.msg, {time: 1500, anim: 1}, function () {
                        window.location.reload();
                    });
                    return true;
                }
                layer.msg(data.msg);
                return false;
            }
        });
        return false;
    }
    $(function(){
        $(".update-box-form-close").on("click",function(){
            $(this).parents(".update-box").fadeOut(200)
        })

    })


</script>
