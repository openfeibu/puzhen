<!-- 轮播图 -->
<div class="min-banner">
    <img src="assets/pc/images//banner2.png" alt="">
</div>
<!-- 主体 -->
<div class="main">
    <?= $detail['article_content']; ?>

    <?php if($detail['article_id'] == 5):?>
    <div class="about-page w1400 container" style="margin-top: 0px;">
        <div class="about-page-contact clearfix">
            <div class="about-page-contact-test fb-inline-block">
                <div class="about-page-contact-test-title">
                    <p><?= lang('contact_us'); ?></p>
                    <span>CONTACT US</span>
                </div>
                <div class="about-page-contact-test-address">
                    <p><?= lang('address'); ?></p>
                    <span><?= $setting['store']['values']['address'];?></span>
                </div>
                <div class="about-page-contact-test-phone">
                    <p><?= lang('tel'); ?></p>
                    <span><?= $setting['store']['values']['tel'];?></span>
                </div>
                <div class="about-page-contact-test-email">
                    <p><?= lang('email'); ?></p>
                    <span><?= $setting['store']['values']['email'];?></span>
                </div>
            </div>
            <div class="about-page-contact-img fb-inline-block">
                <img src="assets/pc/images/code.jpeg" alt="">
            </div>
        </div>
    </div>
    <?php endif;?>
</div>