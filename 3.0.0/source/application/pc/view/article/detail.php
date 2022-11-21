<!-- 轮播图 -->
{{include file="layouts/banner" /}}
<!-- 主体 -->
<div class="main">
    <?php if($detail): ?>
    <?= $detail[$prefix.'article_content'] ?: $detail['article_content']; ?>
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
                    <span><?= $setting['store']['values'][$prefix.'address'] ?: $setting['store']['values']['address'];;?></span>
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
    <?php endif; ?>
    <?php else: ?>
        <div class="nodata">
            <div class="test"><?= lang('nodata'); ?></div>
        </div>
    <?php endif; ?>
</div>