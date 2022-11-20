<div class="footer clearfix">
    <div class="footer-con clearfix">
        <div class="container w1060 clearfix">
            <div class="footer-con-left col-lg-10 col-md-10 col-sm-12 col-xs-12 " >
                <div class="footer-info">
                    <p><?= lang('address') ?><?= lang(': ') ?><?= $setting['store']['values'][$prefix.'address'] ?: $setting['store']['values']['address'];?></p>
                    <p><?= lang('tel') ?><?= lang(': ') ?><?= $setting['store']['values']['tel'];?></p>
                    <p><?= $setting['store']['values'][$prefix.'right'] ?: $setting['store']['values']['right'];?></p>
                    <p>
                        <?php if($think_lang == 'en-us'): ?>
                        <a href="http://www.feibu.info" target="_blank">Guangzhou Feibu Information Technology Co., LTD</a> Provide Technical Support
                        <?php else: ?>
                        <a href="http://www.feibu.info" target="_blank">广州飞步信息科技有限公司</a> 提供技术支持
                        <?php endif; ?>
                    </p>
                </div>
                <div class="footer-link">
                    <a href="<?= url('/factory'); ?>"><?= lang('factory_entrance') ?></a>
                    <a href="<?=url('tea_qrcode/add'); ?>"><?= lang('diy_qrcode'); ?></a>
                    <a href="<?= url('article/contact');?>"><?= lang('contact_us'); ?></a>
                </div>
            </div>
            <div class="footer-con-right col-lg-2 col-md-2 col-sm-12 col-xs-12  ">
                <div class="footer-ewm">
                    <img src="assets/pc/images/code.jpeg" alt="" />
                    <p><?= lang('wechat_public_account') ?></p>
                </div>
            </div>

        </div>
        <div class="container footer-logo w1060">
            <p><?= $setting['pc']['values'][$prefix.'name'];?></p>
        </div>
    </div>

</div>

<!-- 移动端导航 -->
<div id="wap-nav">
    <div class="nav-box transition500">
        <div class="wap-header">
            <span class="wapNav-close icon_close"></span>
        </div>

        <ul>

            <li <?php if(request()->pathinfo() == 'pc/index/index' || request()->pathinfo() == '/'): ?> class="active" <?php endif;?>>
                <a href="<?= $base_url ?? url('') ?>"><?= lang('home');?></a>
                <div class="line transition "></div>
            </li>

            <?php if(!empty($navList)): foreach ($navList as $key => $item): ?>
            <li <?php if(request()->pathinfo() == 'pc/'.$item['url']): ?> class="active" <?php endif;?>>
                <a href="<?= $pc_url.'/'.$item['url'] ?>"><?= $item['name'] ?></a>
            </li>
            <?php endforeach; endif;?>
            <li>
                <a href="<?= url('/factory') ?>"><?= lang('factory_entrance') ?></a>
            </li>
            <li>
                <div class="nav-search fixed-nav-item-search"><?= lang('search'); ?></div>
            </li>
        </ul>
    </div>
</div>
<div class="fixed-search">
    <div class="fixed-search-close"></div>
    <div class="fixed-search-form">
        <form action="<?= url('goods/index') ?>" method="post">
            <div class="fixed-search-form-input"><input type="text" placeholder="<?= lang('search_empty'); ?>" name="search"></div>
            <div class="fixed-search-form-submit"><button type="submit"><?= lang('search'); ?></button></div>
        </form>
    </div>
</div>
<!-- 加载 -->
<div class="fb-loading" style="display: none;">
    <div class="loader-inner ball-clip-rotate-pulse">
        <div></div>
        <div></div>
    </div>
</div>
<script>
    $(function(){
        //获取手机验证码
        $(".getCode").on("click",function(){
            let that = this;
            if($(that).hasClass("active")){
                return false;
            }
            let code_type = $(that).attr('attr-type');
            let url = "<?= url('user/send_code') ?>";
            let data = {'code_type':code_type};

            if(code_type == 'bind_phone_number' || code_type == 'register_phone_number' || code_type == 'forget_pass_phone_number')
            {
                data.phone_number = $(that).parents("form").find("input[name='phone_number']").val();
                if(!/^1[3-9]\d{9}$/.test(data.phone_number)){
                    layer.msg("<?= lang('phone_number_error') ?>");
                    return false;
                }
            }else if(code_type == 'bind_email' || code_type == 'register_email' || code_type == 'forget_pass_email')
            {
                data.email = $(that).parents("form").find("input[name='email']").val();
                if(!/^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+/.test(data.email)){
                    layer.msg("<?= lang('email_error') ?>")
                    return false;
                }
            }else{
                layer.msg(lang_arr['illegal_action']);
                return false;
            }
            let load = layer.load(2);
            $.ajax({
                url : "<?= url('passport/send_code')?>",
                data : data,
                type : 'post',
                success : function (data) {
                    layer.close(load);
                    if(data.code !== 1)
                    {
                        layer.msg(data.msg);
                        return false;
                    }
                    $(that).addClass("active")
                    let i = 60;
                    $(that).text(i+"<?= lang('js_request_too_frequent') ?>");
                    let timer = setInterval(function(){
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
    })
</script>
